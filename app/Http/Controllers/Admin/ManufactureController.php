<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\CogsAllocat;
use App\Customer;
use App\Account;

class ManufactureController extends Controller
{
    public function index(Request $request){

    $ref_def_id = Customer::select('id')
        ->Where('def', '=', '1')    
        ->get();
    $def_id =$ref_def_id[0]->id;

    $products = Product::selectRaw("products.*,(SUM(CASE WHEN product_order_details.type = 'D' AND product_order_details.status = 'onhand' AND product_order_details.owner = '".$def_id."' THEN product_order_details.quantity ELSE 0 END) - SUM(CASE WHEN product_order_details.type = 'C' AND product_order_details.status = 'onhand' AND product_order_details.owner = '".$def_id."' THEN product_order_details.quantity ELSE 0 END)) AS quantity_balance")
        ->where('products.model', 'good')
        ->where('products.type', 'single')
        ->where('products.status', 'show')    
        ->leftjoin('product_order_details', 'product_order_details.products_id', '=', 'products.id')            
        ->groupBy('products.id')
        ->get();

    return view('admin.manufacture.index', compact('products'));
    }
    public function create()
    {
        $products = Product::where('model','material')->get();
        $accounts = Account::where('accounts_group_id', 12)
        ->get();
        return view('admin.manufacture.create', compact('accounts','products'));
    }

    public function store(StoreProductRequest $request)
    {
        $accounts = $request->input('accounts', []);
        $amounts = $request->input('amounts', []);
        $manufactures = $request->input('manufactures', []);
        $quantitys = $request->input('quantities', []);

        $cogs =0;
        for ($account=0; $account < count($accounts); $account++) {
            $cogs += $amounts[$account];            
        }
        $bruto =  $request->input('price')-$cogs;
        $bv = substr_replace($bruto, '0000', -4, 4);

        $data=array_merge($request->all(), ['cogs' => $cogs,'bv' => $bv]);
        $product=Product::create($data);
        for ($account=0; $account < count($accounts); $account++) {
            if ($accounts[$account] != '') {
                $product->accounts()->attach($accounts[$account], ['amount' => $amounts[$account]]);
            }
        }
        if($request->model=='good'){
            for ($manufacture=0; $manufacture < count($manufactures); $manufacture++) {
                if ($manufactures[$manufacture] != '') {
                    $product->manufacture()->attach($manufactures[$manufacture], ['quantity' => $quantitys[$manufacture]]);
                }
            }
        }

        return redirect()->route('admin.manufacture.index');
    }

    public function edit(Request $request,$id)
    {
        $product = Product::find($id);
        // return $id;
        $accounts = Account::where('accounts_group_id', 12)
        ->get();
        $products = Product::where('model','material')->get();
        $product->load('accounts');
        
        return view('admin.manufacture.edit', compact('product', 'accounts','products'));
    }

    public function update(StoreProductRequest $request, Product $product,$id)
    {
        abort_unless(\Gate::allows('product_edit'), 403);
        $product = Product::find($id);
        $accounts = $request->input('accounts', []);
        $amounts = $request->input('amounts', []);
        $manufactures = $request->input('manufactures', []);
        $quantitys = $request->input('quantities', []);
        $cogs =0;
        //set cogs
        for ($account=0; $account < count($accounts); $account++) {
            $cogs += $amounts[$account];            
        }

        $data = $request->all();
        
        $img_path="/images/products";
        $basepath=str_replace("laravel-admin","public_html/admin",\base_path());
        $data = $request->all();
        if ($request->file('img') != null) {
            $resource = $request->file('img');
            //$img_name = $resource->getClientOriginalName();
            $name=strtolower($request->input('name'));
            $name=str_replace(" ","-",$name);
            $img_name = $img_path."/".$name."-".$product->id."-01.".$resource->getClientOriginalExtension();
            try {
                //unlink old
                $data = array_merge($data, ['img' => $img_name]);
                $resource->move($basepath . $img_path, $img_name);
            } catch (QueryException $exception) {
                return back()->withError('File is too large!')->withInput();
            }
        }
        $bruto =  $request->input('price')-$cogs;
        $bv = substr_replace($bruto, '0000', -4, 4);

        $data=array_merge($data, ['cogs' => $cogs,'bv' => $bv]);
        
        $product->update($data);

        $product->accounts()->detach();
        for ($account=0; $account < count($accounts); $account++) {
            if ($accounts[$account] != '') {
                $product->accounts()->attach($accounts[$account], ['amount' => $amounts[$account]]);
            }
        }

        $product->manufacture()->detach();
        if($request->model=='good'){
            for ($manufacture=0; $manufacture < count($manufactures); $manufacture++) {
                if ($manufactures[$manufacture] != '') {
                    $product->manufacture()->attach($manufactures[$manufacture], ['quantity' => $quantitys[$manufacture]]);
                }
            }
        }
        return redirect()->route('admin.manufacture.index');

    }

    public function destroy(Product $product,$id)
    {
        $product = Product::find($id);
        // return $product;
        $product->accounts()->detach();
        $product->manufacture()->detach();
        $product->delete();
        return back();
    }


}
?>