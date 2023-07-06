@foreach($selected_items as $s_item)
<div class="col-sm-3 col-md-2 col-lg-2 col-xl-1">
    <div id="div_item_{{ $s_item->booking_item_id }}" class="card">

        <div class="text-center">
            <form id="ajax-form{{ $s_item->booking_item_id }}" action="/admin/items_quantity/{{$booking_id}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="booking_id" value="{{$booking_id}}">
                <input type="hidden" name="btn_submit" value="5">
                <input type="hidden" name="booking_item_id" value="{{$s_item->booking_item_id}}">
                <input type="hidden" id="quantity{{ $s_item->booking_item_id }}" name="quantity" value="{{$s_item->quantity}}">
                <input type="hidden" id="action{{ $s_item->booking_item_id }}" name="action" value="">
            </form>

            <div class="col-md-12 text-center">
                <button type="button" class="border-0 bg-white text-success p-0" name="update_quantity" onclick="quantity_update('{{ $s_item->booking_item_id }}','+');"><i class="icon icon-plus2"></i></button>
                <button type="button" class="border-0 bg-white text-success p-0" name="update_quantity" onclick="quantity_update('{{ $s_item->booking_item_id }}','-');"><i class="icon icon-minus2"></i></button>
                <button type="button" class="border-0 bg-white text-danger p-0" data-toggle="modal" data-target="#item_delete{{ $s_item->booking_item_id }}"><i class="icon icon-trash-alt"></i></button>
                <button type="button" class="border-0 bg-white text-info p-0"  data-toggle="modal" data-target="#item_info_{{ $s_item->booking_item_id }}"><i class="icon icon-eye2"></i></button>
            </div>
        </div>

        <div class="card-image text-center">
            <img src="{{ $s_item->file_path }}" class="card-img-top" style="height: 80px; width: auto" alt="">
        </div>

        <p class="text-info text-center" style="margin-bottom: 0">
            <span>Quantity:</span>  {{ $s_item->quantity }}
        </p>
    </div>
</div>
@endforeach
