@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    </div>

    <div class="card-body">
        <form action="{{ route("admin.delivery.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                Permintaan List
                </div>

                <div class="card-body">
                    <table class="table" id="products_table">
                        <thead>
                            <tr>
                                <th>Permintaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (old('orderan', ['']) as $index => $oldorder)
                                <tr id="product{{ $index }}">
                                    <td>
                                        <select name="orderan[]" class="form-control product_list">
                                            <option value="">-- Pilih Permintaan --</option>
                                            @foreach ($orderan as $order)
                                                <option  value="{{ $order->id }}"{{ $oldorder == $order->id ? ' selected' : '' }}>
                                                    {{ $order->id }}
                                                </option>
                                            @endforeach
                                   
                                    </td>
                                    <!-- <td>
                               
                                </tr>
                            @endforeach
                            <tr id="product{{ count(old('orderan', [''])) }}"></tr>
                        </tbody>
                        <!-- <tr>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    Total
                                    </td>
                                    <td>
                                    <input type="number" name="total" class="form-control" value="{{ old('total') ?? '0' }}" readonly />
                                    </td>
                                </tr> -->
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                            <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="Teruskan">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    let row_number = {{ count(old('products', [''])) }};
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
      $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#product" + (row_number - 1)).html('');
        row_number--;
      }
    });

    $(document).on("change", "select.product_list" , function() {
        let data_key = $(this).closest('tr').attr('id');
        let qty = $('tr#'+data_key+' input.qty_list').val();
        let sub = qty * $(this).find(':selected').data('price');
        //alert(data_key);
        $('tr#'+data_key+' input.cogs_hidden')
        .val(
            $(this).find(':selected').data('cogs')
        );
        $('tr#'+data_key+' input.price_list')
        .val(
            $(this).find(':selected').data('price')
        );
        $('tr#'+data_key+' input.sub_list')
        .val(sub);
        var sum = 0;
        $('.sub_list').each(function () {
            sum += Number($(this).val());
        });
        $("input[name='total']")
        .val(sum);
    });

    $(document).on("change", "input.qty_list" , function() {
        let data_key = $(this).closest('tr').attr('id');
        let price = $('tr#'+data_key+' input.price_list').val();
        let sub = $(this).val() * price;
        $('tr#'+data_key+' input.sub_list')
        .val(sub);
        var sum = 0;
        $('.sub_list').each(function () {
            sum += Number($(this).val());
        });
        $("input[name='total']")
        .val(sum);
    });

    $(document).on("change", "input.price_list" , function() {
        let data_key = $(this).closest('tr').attr('id');
        let qty = $('tr#'+data_key+' input.qty_list').val();
        let sub = $(this).val() * qty;
        $('tr#'+data_key+' input.sub_list')
        .val(sub);
        var sum = 0;
        $('.sub_list').each(function () {
            sum += Number($(this).val());
        });
        $("input[name='total']")
        .val(sum);
    });

  });
</script>
@endsection
