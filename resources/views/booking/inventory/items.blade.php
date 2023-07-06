@if (!empty($selected_array) || $preset_show)
<div class="row">
    @foreach($items as $item)
    @php if(!isset($selected_array[$item->id])) { if(!isset($search)) {continue;} @endphp
    <div class="col-xl-3 col-sm-3" id="itemList{{ $item->id }}">
        <div class="card card-body bg-light text-center mb-3" style="padding: 1.6rem 2em!important;">
            @if(!isset($item->file_path))
            <a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
                <img src="/no_item.jpg" class="card-img" height="60" alt="">
                <!-- <span class="card-img-actions-overlay card-img"><i class="icon-zoomin3"></i></span> -->
            </a>
            
            @else
            <span class="close__  close-btn close-btn2 ml-auto cursor rounded-circle d-flex align-items-center justify-content-center close_popup" onclick="deleteItem('{{ $item->id }}')"><i class="icon-close2"></i></span>
            @if(!isset($item->file_path))
            <a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
                <img src="/no_item.jpg" class="card-img" height="60" alt="">
            
            </a>
            @else
            <a href="#" data-toggle="modal" data-target="#item_add_{{ $item->id }}">
                <img src="{{$item->file_path}}" class="card-img" height="60" alt="">
            
            </a>
            @endif
            @endif

            @if (isset($item->preset_quantity))
                <small class="pt-2">{{ ucfirst($item->name) }} - {{$item->preset_quantity}}</small>
            @else
                <small class="pt-2">{{ ucfirst($item->name) }}</small>
            @endif
            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#item_add_{{ $item->id }}">Add to Cart</button>
        </div>
    </div>
    @php } else { @endphp
        <div class="col-xl-3 col-sm-3">

    <div id="quantity_item" class="card" style="display:none;">
        <div id="div_item_quantity" class="card-box bg-success text-white text-center">s</div>
    </div>

    <div id="div_item_{{ $selected_array[$item->id]['booking_item_id'] }}" class="card p-1" style="padding: 2.2rem 2em!important;">

        <div class="btn-group w-100" role="group">
            <form id="ajaxform{{ $selected_array[$item->id]['booking_item_id'] }}" action="/quantity/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                <input type="hidden" name="btn_submit" value="5">
                <input type="hidden" name="booking_item_id" value="{{$selected_array[$item->id]['booking_item_id']}}">
                <input type="hidden" id="quantity_{{ $selected_array[$item->id]['booking_item_id'] }}" name="quantity" value="{{$selected_array[$item->id]['quantity']}}">
                <input type="hidden" id="action{{ $selected_array[$item->id]['booking_item_id'] }}" name="action" value="">
            </form>
        </div>

        <a href="{{ isset($item->file_path) ? $item->file_path : '/no_item.jpg' }}" class="p-0 m-0 text-center">
            <img src="{{ isset($item->file_path) ? $item->file_path : '/no_item.jpg' }}" class="card-img-top" alt="" style="height: 60px;width: auto">
        </a>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="col-4 text-center p-1" onclick="quantity_update('{{ $selected_array[$item->id]['booking_item_id'] }}','-');" style="background:#1478ce;color:white;cursor:pointer">
                <i class="icon icon-minus2"></i>
            </div>
            <div class="col-4 text-center text-info" id="quantity-{{ $selected_array[$item->id]['booking_item_id'] }}">
                {{ $selected_array[$item->id]['quantity'] }}
            </div>
            <div class="col-4 text-center p-1" onclick="quantity_update('{{ $selected_array[$item->id]['booking_item_id'] }}','+');" style="background:#1478ce;color:white;cursor:pointer">
                <i class="icon icon-plus2"></i>
            </div>
        </div>


        <!-- <div class="btn-group w-100 text-center mt-3" @if ($booking->service_type_id == 5)style="display: none" @endif>
            <form id="ajaxpkg{{ $selected_array[$item->id]['booking_item_id'] }}" action="/packaging/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data" class="col-12">
                {{ csrf_field() }}
                <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                <input type="hidden" name="booking_item_id" value="{{$selected_array[$item->id]['booking_item_id']}}">

                <div class="col-12 mt-3">
                    <div class="row mb-2">
                        <div class="col-8 text-nowrap"><h6>Wrapping</h6></div>
                        <div class="col-4">
                            <input class="js-switch float-right" type="checkbox" id="pkg_{{ $selected_array[$item->id]['booking_item_id'] }}" onclick="add_packaging('{{ $selected_array[$item->id]['booking_item_id'] }}','pkg');"@if(isset($item->Pakaging) && $item->Pakaging == 1 )checked @endif
                            name="packaging" value="1">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 mt-3">
                    <div class="row mb-2">
                        <div class="col-8"><h6>Junk Removal</h6></div>
                        <div class="col-4">
                            <input class="js-switch float-right" type="checkbox" id="jnk_{{ $selected_array[$item->id]['booking_item_id'] }}" onclick="add_packaging('{{ $selected_array[$item->id]['booking_item_id'] }}','jnk');"@if(isset($item->junk_removal) && $item->junk_removal == 1 )checked @endif
                            name="junkremoval" value="1">
                        </div>
                    </div>
                </div>
            </form>
        </div> -->

        <!-- <div class="btn-group w-100 mt-3" role="group">
            <button type="button" class="border-0 btn btn-info text-white" data-toggle="modal" data-target="#item_info_{{ $selected_array[$item->id]['booking_item_id'] }}">View</button>
            <button type="button" class="border-0 btn btn-secondary text-white" data-toggle="modal" data-target="#item_delete{{ $selected_array[$item->id]['booking_item_id'] }}">Remove</button>
        </div> -->

    </div>
    </div>
    @php } @endphp

    @include('booking.inventory.ranking_add')

    @endforeach
</div>
@if ($preset_show)
<div class="row" style="float: right; padding-right: 20px;">
    <button class="btn btn-info" id="select_preset_items" onclick="add_preset({{$items}})">Add to Cart</button>
</div>
@endif
@endif
@if (!empty($selected_array) || $preset_show)
<div id="preset_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="frm_add_preset" action="/add_preset/{{ ($booking->booking_id) ?: null }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @foreach ($items as $item)
                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                <input type="hidden" name="item_name[{{$item->id}}]" value="{{ $item->name }}">
                <input type="hidden" name="item_image[{{$item->id}}]" value="{{ $item->image }}">
                <input type="hidden" name="file_path[{{$item->id}}]" value="{{ $item->file_path }}">
                @endforeach

                <div class="modal-header text-white bg-info">
                    <h3 class="m-0">Selected Preset</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    @foreach ($items as $item)
                    <div class="row mb-3 ml-1 mr-1" style="border-bottom: 3px solid #9e9e9e6b">
                        <div class="col-2" style="display: flex; align-items: center; justify-content: center;">
                            <div class="text-center" style="padding: 2px; border: 2px solid #9e9e9e6b; border-radius: 3px;">
                                <img src="{{isset($item->file_path) ? $item->file_path : '/no_item.jpg'}}" alt="inventory item" style="height: 80px; width: 80px">
                            </div>
                        </div>

                        <div class="col-10">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" style="@if (!isset($R[$item->id]))display: none @endif">
                                        <label for="" class="form-label" style="font-size: 12px;">What needs to be disassembled/reassembled?</label>
                                        @if(!empty($ranking))
                                        <select name="ranking[{{$item->id}}]" class="form-control">
                                            <option value="" disabled selected> Select</option>
                                            @foreach($ranking as $rank)
                                            <option value="{{$rank->ranking_id}}">{{$rank->alphabet}} - {{$rank->ranking_name}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="" style="font-size: 12px;">Quantity</label>
                                        @php
                                            $quantity = isset($item->preset_quantity) ? $item->preset_quantity : 1;
                                        @endphp

                                        <!-- <input type="number" name="quantity[{{$item->id}}]" id="quantity" class="form-control" value="{{$quantity}}"> -->
                                        <div class="col-12" style="border: 1px solid #cfcfcf;white-space: nowrap;display: inline-flex;align-items: center; justify-content: space-between;margin: 20px 0 20px 10px;">

                                            <input type="button" class="product-subtractt sub" value="-" onclick="decreases('{{$item->id}}','quantitys_')" style="color: #000 !important; border: none!important; outline: none!important; background: none!important; padding: 10px 20px; font-size: 20px;">
                                            <input style="border:none; outline:none; font-size:20px; color:grey; text-align:center;" type="text" id="quantitys_{{$item->id}}" name="quantity[{{$item->id}}]" value="1" size="1">
                                            <input class="product-pluss add" type="button" value="+" onclick="increases('{{$item->id}}','quantitys_')" style="color: #000 !important; border: none!important; outline: none!important; background: none!important; padding: 10px 20px; font-size: 20px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3" style="border-bottom: 1px solid #9e9e9e6b">
                                <div class="col-6">
                                    <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                                        <label class="form-label" style="font-size: 12px;">Pickup Location of Seleted item</label>
                                        @if(!empty($booking_location))
                                        <select name="pick_up_loc_id[{{$item->id}}]" class="form-control" required>
                                        @foreach($booking_location as $k => $loc)
                                            @if ($k != count($booking_location) - 1)
                                            <option value="{{$loc->booking_loc_id}}" @if ($k == 0) selected @endif>{{$loc->location}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                                        <label class="form-label" style="font-size: 12px;">Drop off Location of Seleted item</label>
                                        @if(!empty($booking_location))
                                        <select name="drop_off_loc_id[{{$item->id}}]" class="form-control" required>
                                        @foreach($booking_location as $k => $loc)
                                        @if ($k != 0)
                                            <option value="{{$loc->booking_loc_id}}" @if ($k == count($booking_location) - 1) selected @endif>{{$loc->location}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                @if(!empty($item->question))
                                @foreach(json_decode($item->question) as $q)
                                @if ($q->allow)
                                <div class="form-group col-md-6">	
                                    <p style="font-size: 12px;"><strong>Q). {{$q->title}} </strong></p>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="answer[{{$q->id}}]-yes" name="answer[{{$item->id}}][{{$q->id}}]" class="custom-control-input">
                                        <label class="custom-control-label" for="answer[{{$q->id}}]-yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="answer[{{$q->id}}]-no" name="answer[{{$item->id}}][{{$q->id}}]" class="custom-control-input">
                                        <label class="custom-control-label" for="answer[{{$q->id}}]-no">No</label>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" name="btn_submit" onclick="select_preset();" data-dismiss="modal">Add Item</button>
                    <button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif