@if($selected_items)

<!-- Grid -->
<div class="row">

@foreach($selected_items as $added_item)
@if($added_item->truck_id == $truck->truck_id)
<style>
.mobile-quantity-icon {
    width: 56px;
    height: 56px;
    line-height: 56px;
    border-radius: 50%;
    border-color: #1478ce;
    background-color: #1478ce;
    color : white;
    cursor : pointer;
}
.table td, .table th {
    padding: .75rem 0;
}

</style>
<div class="col-xl-3 col-sm-12">

    <div id="quantity_item" class="card" style="display:none;">
        <div id="div_item_quantity" class="card-box bg-success text-white text-center">s</div>
    </div>

    <div id="div_item_{{ $added_item->booking_item_id }}" class="card p-1">

        <div class="btn-group w-100" role="group">
            <form id="ajaxform{{ $added_item->booking_item_id }}" action="/quantity/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                <input type="hidden" name="btn_submit" value="5">
                <input type="hidden" name="booking_item_id" value="{{$added_item->booking_item_id}}">
                <input type="hidden" id="quantity_{{ $added_item->booking_item_id }}" name="quantity" value="{{$added_item->quantity}}">
                <input type="hidden" id="action{{ $added_item->booking_item_id }}" name="action" value="">
            </form>
        </div>
    <li> 
    <form id="ajaxpkg{{ $added_item->booking_item_id }}" action="/packaging/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data" class="col-12">
            {{ csrf_field() }}
            <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
            <input type="hidden" name="booking_item_id" value="{{$added_item->booking_item_id}}">
            <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr class="d-flex flex-row"> 
                      <td colspan=4>
                        <a href="javascript:void(0)" class="p-0 m-0 text-center" data-toggle="modal" data-target="#item_info_{{ $added_item->booking_item_id }}">
                            <img src="{{ $added_item->file_path }}" class="card-img-top" alt="" style="height: auto;width: auto">
                        </a>
                        </td>
                    </tr>
                    <tr class="d-flex flex-row"> 
                        <td>
                            <div class="text-center p-1" onclick="quantity_update('{{ $added_item->booking_item_id }}','-');">
                                <i class="icon icon-minus2 mobile-quantity-icon"></i>
                            </div>
                        </td>
                        <td>
                            <input type="number" value="{{ $added_item->quantity }}" class="form-control mt-2" style="max-width: 64px;">
                        </td>
                        <td>
                            <div class="text-center p-1" onclick="quantity_update('{{ $added_item->booking_item_id }}','+');">
                                <i class="icon icon-plus2 mobile-quantity-icon"></i>
                            </div>
                        </td>                        
                        <td>
                            <a style="padding: 0px;" href="#" data-toggle="modal" data-target="#item_delete{{ $added_item->booking_item_id }}">
                            <i class="fa fa-trash-o mt-3 ml-2" aria-hidden="true" style="font-size: 2.2em;"></i>
                            </a>
                        </td>
                    </tr>
                  </tbody>
                </table>
            </div>
    </form>               
    </li>
</div>
</div>

@include('booking.inventory.item_info')
@include('booking.inventory.item_delete')
@endif
@endforeach
@endif
</div>
<script>
    @foreach ($selected_items as $k => $added_item)
    var pkg_{{$k}} = document.getElementById('{{"pkg_" . $added_item->booking_item_id}}');
    var init = new Switchery(pkg_{{$k}}, {color: '#41b7f1', size: 'small'});
    var jnk_{{$k}} = document.getElementById('{{"jnk_" . $added_item->booking_item_id}}');
    var init = new Switchery(jnk_{{$k}}, {color: '#41b7f1', size: 'small'});

    pkg_{{$k}}.onchange = function() {
        if(pkg_{{$k}}.checked) {
            add_packaging('{{ $added_item->booking_item_id }}','pkg');
        }
    }
    jnk_{{$k}}.onchange = function() {
        if(jnk_{{$k}}.changed) {
            add_packaging('{{ $added_item->booking_item_id }}','jnk');
        }
    }
    @endforeach
</script>