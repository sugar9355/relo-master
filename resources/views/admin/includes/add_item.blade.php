<div id="item_add_{{ $item->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="frm_add_items{{ $item->id }}" action="/admin/add_item/{{ ($booking_id) ?: null }}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="item_name" value="{{ $item->name }}">
                <input type="hidden" name="item_image" value="{{ $item->image }}">
                <input type="hidden" name="file_path" value="{{ $item->file_path }}">
                <div class="modal-header text-white bg-info">
                    <h3 class="m-0">{{ $item->name }}</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="text-center">
                        @if($item->file_path == '')
                        <img src="/no_item.jpg" height="100" alt="No Item Image">
                        @else
                        <img src="{{$item->file_path}}" height="100" alt="Item Image">
                        @endif
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

                    <div class="form-group">
                        <label for="">Quantity</label>
                        @php
                            $quantity = isset($item->preset_quantity) ? $item->preset_quantity : 1;
                        @endphp
                        <input type="number" name="quantity" class="form-control" value="{{$quantity}}">
                    </div>

                    <div class="form-group" style="@if (count($booking_location) == 2)display: none @endif">
                        <div class="col-md-12 text-left">
                        <label class="form-label"><strong>Selected Pickup Location of Seleted item</strong></label>
                            @if(!empty($booking_location))
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" name="btn_submit" onclick="add_item({{ $item->id }});" data-dismiss="modal">Add Item</button>
                    <button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">Close</button>
                </div>

            </form>

        </div>

    </div>
</div>