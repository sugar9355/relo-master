<div class="card hvr-shadow m-3 shadow">
    <div class="card-body">
        <div class="row">
            @foreach($selected_items as $k => $added_item )
            <div id="div_item_{{ $added_item->pk_booking_item_id }}" class="card p-1 ml-3">

                <div class="btn-group w-100" role="group">
                    <form id="ajaxform{{ $added_item->pk_booking_item_id }}" action="/quantity/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                        <input type="hidden" name="btn_submit" value="5">
                        <input type="hidden" name="booking_item_id" value="{{$added_item->pk_booking_item_id}}">
                        <input type="hidden" id="quantity_{{ $added_item->pk_booking_item_id }}" name="quantity" value="{{$added_item->quantity}}">
                        <input type="hidden" id="action{{ $added_item->pk_booking_item_id }}" name="action" value="">
                    </form>
                </div>

                <a href="{{ $added_item->file_path }}" class="p-0 m-0 text-center">
                    <img src="{{ $added_item->file_path }}" class="card-img-top" alt="" style="height: 60px;width: auto">
                </a>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="col-4 text-center p-1" onclick="quantity_update('{{ $added_item->pk_booking_item_id }}','+');" style="background:#1478ce;color:white;cursor:pointer">
                        <i class="icon icon-plus2"></i>
                    </div>
                    <div class="col-4 text-center text-info">
                        {{ $added_item->quantity }}
                    </div>
                    <div class="col-4 text-center p-1" onclick="quantity_update('{{ $added_item->pk_booking_item_id }}','-');" style="background:#1478ce;color:white;cursor:pointer">
                        <i class="icon icon-minus2"></i>
                    </div>
                </div>


                <div class="btn-group w-100 text-center">
                    <form id="ajaxpkg{{ $added_item->pk_booking_item_id }}" action="/packaging/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data" class="col-12">
                        {{ csrf_field() }}
                        <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                        <input type="hidden" name="booking_item_id" value="{{$added_item->pk_booking_item_id}}">

                        <div class="col-12 mt-3">
                            <div class="row mb-2">
                                <div class="col-8 text-nowrap"><h6>Wrapping</h6></div>
                                <div class="col-4">
                                    <input class="js-switch float-right" type="checkbox" id="pkg_{{ $added_item->pk_booking_item_id }}" onclick="add_packaging('{{ $added_item->pk_booking_item_id }}','pkg');"@if($added_item->Pakaging == 1 )checked @endif
                                    name="packaging" value="1">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12 mt-3">
                            <div class="row mb-2">
                                <div class="col-8"><h6>Junk Removal</h6></div>
                                <div class="col-4">
                                    <input class="js-switch float-right" type="checkbox" id="jnk_{{ $added_item->pk_booking_item_id }}" onclick="add_packaging('{{ $added_item->pk_booking_item_id }}','jnk');"@if($added_item->junk_removal == 1 )checked @endif
                                    name="junkremoval" value="1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="btn-group w-100" role="group">
                    <button type="button" class="border-0 btn btn-info text-white" data-toggle="modal" data-target="#item_info_{{ $added_item->pk_booking_item_id }}">View</button>
                    <button type="button" class="border-0 btn btn-secondary text-white" data-toggle="modal" data-target="#item_delete{{ $added_item->pk_booking_item_id }}">Remove</button>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    @foreach ($selected_items as $k => $added_item)
    var pkg_{{$k}} = document.getElementById('{{"pkg_" . $added_item->pk_booking_item_id}}');
    var init = new Switchery(pkg_{{$k}}, {color: '#41b7f1', size: 'small'});
    var jnk_{{$k}} = document.getElementById('{{"jnk_" . $added_item->pk_booking_item_id}}');
    var init = new Switchery(jnk_{{$k}}, {color: '#41b7f1', size: 'small'});

    pkg_{{$k}}.onchange = function() {
        if(pkg_{{$k}}.checked) {
            add_packaging('{{ $added_item->pk_booking_item_id }}','pkg');
        }
    }
    jnk_{{$k}}.onchange = function() {
        if(jnk_{{$k}}.changed) {
            add_packaging('{{ $added_item->pk_booking_item_id }}','jnk');
        }
    }
    @endforeach
</script>