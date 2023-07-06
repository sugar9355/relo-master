<div id="item_add_{{ $item->id }}" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content" style="max-width: 400px; margin: auto; padding: 1em 2em 1em 1em;">

    <form id="frm_add_items{{ $item->id }}" action="/add_item/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

        {{csrf_field()}}

        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <input type="hidden" name="item_name" value="{{ $item->name }}">
        @if($item->file_path!='')
            <input type="hidden" name="item_image" value="{{ $item->image }}">
            <input type="hidden" name="file_path" value="{{ $item->file_path }}">
        @else
            <input type="hidden" name="item_image" value="/no_item.jpg">
            <input type="hidden" name="file_path" value="/no_item.jpg">
        @endif

        <!-- <div class="modal-header text-dark bg-light">
            <h3 class="m-0">{{ $item->name }}</h3>
        </div> -->

        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <img src="{{isset($item->file_path) ? $item->file_path : '/no_item.jpg'}}" style="height: 100px;width: auto" alt="">
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h3 class="m-0">{{ $item->name }}</h3>
                </div>
            </div>
            
            <div class="row">
            <div class="col-12 d-flex justify-content-center"
                    style="border: 1px solid #cfcfcf;white-space: nowrap;display: inline-flex;align-items: center; justify-content: space-between;margin: 20px 0 20px 10px;">
                    @php
                        $quantity = isset($item->preset_quantity) ? $item->preset_quantity : 1;
                    @endphp

                    <input type="button" class="product-subtractt sub" value="-" onclick="decrease({{$item->id}})"
                        style="color: #000 !important; border: none!important; outline: none!important; background: none!important; padding: 10px 20px; font-size: 20px;">

                    <input style="border:none; outline:none; font-size:20px; color:grey; text-align:center;" type="text" id="quantity_{{ $item->id }}"
                        name="quantity" value="{{$quantity}}" size="1" id="number">

                    <input class="product-pluss add" type="button" value="+" onclick="increase({{$item->id}})"
                        style="color: #000 !important; border: none!important; outline: none!important; background: none!important; padding: 10px 20px; font-size: 20px">

                </div>
            </div>

            <div class="form-group" style="@if (!isset($R[$item->id]))display: none @endif">
                <label class="form-label"><strong>What needs to be disassembled/reassembled?</strong><br>
                    Please specify the item and the level of complexity from 1-5, i.e "bed frame, level 2"</label>
                @if(!empty($ranking))
                    <select name="ranking" class="form-control">
                        <option value="" disabled selected> Select</option>
                    @foreach($ranking as $rank)
                            <option value="{{$rank->ranking_id}}">{{$rank->alphabet}} - {{$rank->ranking_name}}</option>
                    @endforeach
                    </select>
                @endif
            </div>

            {{-- <div class="form-group">
                <label for="">Quantity</label>
                @php
                    $quantity = isset($item->preset_quantity) ? $item->preset_quantity : 1;
                @endphp
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{$quantity}}">
            </div> --}}

            <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                <div class="col-md-12 text-left">
                <label class="form-label"><strong>Selected Pickup Location of Seleted item</strong></label>
                    @if(!empty($booking_location))
                    @php
                        $array = $booking_location->toArray();
                        $out = array_splice($array, 1, 1);
                        $length = count($array);
                        $booking_location = array_replace($array, array($length => $out[0]));
                    @endphp
        
                    <select name="pick_up_loc_id" class="form-control" required>
                    @foreach($booking_location as $k => $loc)
                    @if ($k != count($booking_location) - 1)
                        <option value="{{$loc->booking_loc_id}}" @if ($k == 0) selected @endif>{{$loc->location}}</option>
                    @endif
                    @endforeach
                    </select>
                    @endif
                </div>
            </div>
            <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                <div class="col-md-12 text-left">
                <label class="form-label"><strong>Selected Drop off Location of Seleted item</strong></label>
                    @if(!empty($booking_location))
                    <select name="drop_off_loc_id" class="form-control" required>
                    @foreach($booking_location as $k => $loc)
                    @if ($k != 0)
                        <option value="{{$loc->booking_loc_id}}" @if ($k == count($booking_location) - 1) selected @endif>{{$loc->location}}</option>
                    @endif
                    @endforeach
                    </select>
                    @endif
                </div>
            </div>

            <div class="form-row" @if ($booking->service_type_id == 6)style="display: none"@endif>
            
                @if(!empty($item->question))
                    
                    @foreach(json_decode($item->question) as $q)
                        
                    @if ($q->allow)
                    <div class="form-group col-md-6">    
                        <p><strong>Q). {{$q->title}} </strong></p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="answer[{{$q->id}}]-yes" name="answer[{{$q->id}}]" class="custom-control-input">
                                <label class="custom-control-label" for="answer[{{$q->id}}]-yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="answer[{{$q->id}}]-no" name="answer[{{$q->id}}]" class="custom-control-input">
                                <label class="custom-control-label" for="answer[{{$q->id}}]-no">No</label>
                            </div>
                    </div>
                    @endif
                    @endforeach
                @endif
            </div>
        
            @if(!empty($booking_location))
                @foreach($booking_location as $k => $loc)
                    @if($k == 0)
                    <input type="hidden" name="pick_up_loc_id" value="{{$loc->booking_loc_id}}">
                    @elseif($k == (count($booking_location) - 1))
                    <input type="hidden" name="drop_off_loc_id" value="{{$loc->booking_loc_id}}">
                    @endif
                @endforeach
            @endif
    </div>
    <div class="modal-footer" style="margin-left: 1em;">
        {{-- <button name ="btn_submit" type="submit" class="btn btn-success" value="5">Add Item</button> --}}
        <button type="button" class="btn btn-success" name="btn_submit" onclick="add_item({{ $item->id }});" data-dismiss="modal" style="width: 100%;">Add to Cart</button>
        <button type="button" class="btn btn-default border border-secondary" data-dismiss="modal" style="width: 100%;">Close</button>
    </div>
    
</form>

</div>

</div>
</div>