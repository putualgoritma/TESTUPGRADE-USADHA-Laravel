@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.product.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.manufacture.update", [$product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ csrf_field() }}
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.product.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($product) ? $product->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                <label for="img">{{ trans('global.product.fields.img') }}*</label>
                <input type="file" id="img" name="img" class="form-control" value="{{ old('img', isset($product) ? $product->img : '') }}">
                @if($errors->has('img'))
                    <em class="invalid-feedback">
                        {{ $errors->first('img') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.img_helper') }}
                </p>
                <p>
                    <img src="{{ old('img', isset($product) ? $product->img : '') }}" alt="{{ old('name', isset($product) ? $product->name : '') }}" width="300">
                </p>
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('global.product.fields.description') }}</label>
                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label for="price">{{ trans('global.product.fields.price') }}</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', isset($product) ? $product->price : '') }}" step="0.01">
                @if($errors->has('price'))
                    <em class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.price_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                <label for="discount">{{ trans('global.product.fields.discount') }}</label>
                <input type="number" id="discount" name="discount" class="form-control" value="{{ old('discount', isset($product) ? $product->discount : '') }}" step="0.01">
                @if($errors->has('discount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.discount_helper') }}
                </p>
            </div>
            <!-- <div class="form-group {{ $errors->has('cogs') ? 'has-error' : '' }}">
                <label for="cogs">{{ trans('global.product.fields.cogs') }}</label>
                <input type="number" id="cogs" name="cogs" class="form-control" value="{{ old('cogs', isset($product) ? $product->cogs : '') }}" step="0.01">
                @if($errors->has('cogs'))
                    <em class="invalid-feedback">
                        {{ $errors->first('cogs') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.product.fields.cogs_helper') }}
                </p>
            </div> -->
            <div class="form-group {{ $errors->has('model') ? 'has-error' : '' }}">
                <label for="model">{{ trans('global.product.fields.model') }}*</label>
                <select name="model" id="model" class="form-control">
                    @if($product->model == 'material')
                        <option value="material" selected>Material</option>
                        <option value="good">Good</option>
                    @endif
                    @if($product->model == 'good')
                        <option value="material">Material</option>
                        <option value="good" selected>Good</option>
                    @endif
                    @if($errors->has('model'))
                        <em class="invalid-feedback">
                            {{ $errors->first('model') }}
                        </em>
                    @endif
                </select>
                @if($errors->has('model'))
                    <em class="invalid-feedback">
                        {{ $errors->first('model') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.order.fields.customers_id_helper') }}
                </p>
            </div>

            <div class="card">
                <div class="card-header">
                    Products
                </div>
                <div class="card-body">
                    <table class="table" id="accounts_table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (old('accounts', $product->accounts->count() ? $product->accounts : ['']) as $product_account)
                            <tr id="account{{ $loop->index }}">
                                <td>
                                    <select name="accounts[]" class="form-control">
                                        <option value="">-- choose account --</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}"
                                                @if (old('accounts.' . $loop->parent->index, optional($product_account)->id) == $account->id) selected @endif
                                            >{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="amounts[]" class="form-control"
                                           value="{{ (old('amounts.' . $loop->index) ?? optional(optional($product_account)->pivot)->amount) ?? '1' }}" />
                                </td>
                            </tr>
                        @endforeach
                        <tr id="account{{ count(old('accounts', $product->accounts->count() ? $product->accounts : [''])) }}"></tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                            <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card tampil {{ $product->model ==  'material' ? 'd-none' : ''  }}">

                <div class="card-header">
                    List Manufacture
                </div>
                <div class="card-body">
                    <table class="table" id="products_table">
                        <thead>
                        <tr>
                            <th>List Product Material</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (old('manufactures', $product->manufacture->count() ? $product->manufacture : ['']) as $product_manufacture)
                            <tr id="product{{ $loop->index }}">
                                <td>
                                    <select name="manufactures[]" class="form-control">
                                        <option value="">-- choose product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}"
                                                @if (old('manufactures.' . $loop->parent->index, optional($product_manufacture)->id) == $product->id) selected @endif
                                            >{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantities[]" class="form-control"
                                           value="{{ (old('quantities.' . $loop->index) ?? optional(optional($product_manufacture)->pivot)->quantity) ?? '1' }}" />
                                </td>
                            </tr>
                        @endforeach
                        <tr id="product{{ count(old('manufactures',$product->manufacture->count() ? $product->manufacture : [''])) }}"></tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row1" class="btn btn-default pull-left">+ Add Row</button>
                            <button id='delete_row1' class="pull-right btn btn-danger">- Delete Row</button>
                        </div>
                    </div>
                </div>
            </div>
                <div class="d-none">
                    <h4>Anda memilih: <span id="selected" class="kata" type="hidden"></span></h4>
                </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script>
      $(document).ready(function(){
        let row_number = {{ count(old('accounts', $product->accounts->count() ? $product->accounts : [''])) }};
        $("#add_row").click(function(e){
          e.preventDefault();
          let new_row_number = row_number - 1;
          $('#account' + row_number).html($('#account' + new_row_number).html()).find('td:first-child');
          $('#accounts_table').append('<tr id="account' + (row_number + 1) + '"></tr>');
          row_number++;
        });

        $("#delete_row").click(function(e){
          e.preventDefault();
          if(row_number > 1){
            $("#account" + (row_number - 1)).html('');
            row_number--;
          }
        });
      });

      $(document).ready(function(){
        let row_number = {{ count(old('manufactures',$product->manufacture->count() ? $product->manufacture : [''])) }};
        $("#add_row1").click(function(e){
          e.preventDefault();
          let new_row_number = row_number - 1;
          $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
          $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
          row_number++;
        });

        $("#delete_row1").click(function(e){
          e.preventDefault();
          if(row_number > 1){
            $("#product" + (row_number - 1)).html('');
            row_number--;
          }
        });
      });


$('#model').on('change', function(){
  const selectedModel = $('#model').val();
  $('#selected').text(selectedModel);
  var teks = $(".kata").text();
    if(teks =='material')
        $('.tampil').hide();
        else{
        $('.tampil').show();
        $('.tampil').removeClass("d-none");
        }
  }); 

    </script>
@endsection