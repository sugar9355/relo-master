<div id="item_info_{{ $added_item->booking_item_id }}" class="modal fade show" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $added_item->item_name }}</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form action="{{route('update_item_info', $booking->booking_id)}}" id="update_item_{{ $added_item->booking_item_id }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <input type="hidden" name="item_id" value="{{ $added_item->item_id }}">
                    <input type="hidden" name="item_name" value="{{ $added_item->item_name }}">
                    <input type="hidden" name="item_image" value="{{ $added_item->item_image }}">
                    <input type="hidden" name="booking_id" value="{{ $added_item->booking_id }}">
                    <input type="hidden" name="booking_item_id" value="{{ $added_item->booking_item_id }}">

                    <div class="form-row">
                        <div class="form-group col-md-3 text-center">

                        </div>
                        <div class="form-group col-md-3 text-center">
                            <strong>Quantity</strong> <input class="form-control text-center" min=0 type="number"
                                name="quantity" value="{{ $added_item->quantity }}">
                        </div>
                        <div class="form-group col-md-3 text-center">
                            @if(isset($categories[0]))
                            <strong>Item Category Name:</strong>
                            <select name="category" class="form-control" readonly>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($added_item->similar_item == $category->id) selected
                                    @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <div class="form-group col-md-3 text-center">

                        </div>
                    </div>

                    <div class="form-group">


                        <div class="col-md-12">
                            @if(isset($item_images))
                            @foreach($item_images as $image)
                            @if($image->booking_item_id == $added_item->booking_item_id)
                            <hr>
                            <div class="form-row">
                                <img src="{{$image->file_path}}" class="img-fluid hvr-icon" width="200px" height="200px">
                            </div>
                            @endif
                            @endforeach
                            @endif

                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-3 text-center"><strong>Length</strong></div>
                        <div class="form-group col-md-3 text-center"><strong>Height</strong></div>
                        <div class="form-group col-md-3 text-center"><strong>Width</strong></div>
                        <div class="form-group col-md-3 text-center"><strong>Weight</strong></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 ">
                            <input class="form-control text-center" value="{{ $added_item->breadth }}" name="breadth" >
                        </div>
                        <div class="form-group col-md-3 text-center">
                            <input class="form-control text-center" value="{{ $added_item->height }}" name="height" >
                        </div>
                        <div class="form-group col-md-3 text-center">
                            <input class="form-control text-center" value="{{ $added_item->width }}" name="width" >
                        </div>
                        <div class="form-group col-md-3 text-center">
                            <input class="form-control text-center" value="{{ $added_item->weight }}" name="weight" >
                        </div>
                    </div>
                    <hr>

                    <div class="form-group" @if(isset($added_item->dis_assems) && $added_item->dis_assems == 0)style="display: none" @endif>
                        <div class="col-md-12 text-left">
                            <label class="form-label"><strong>What needs to be disassembled/reassembled?</strong><br>
                                Please specify the item and the level of complexity from 1-5, i.e "bed frame, level
                                2"</label>
                            @if(!empty($ranking))
                            <select name="ranking" class="form-control" disabled>
                                @foreach($ranking as $rank)
                                <option value="{{$rank->ranking_id}}" @if($added_item->ranking == $rank->ranking_id)
                                    selected @endif>{{$rank->alphabet}} - {{$rank->ranking_name}}</option>
                                @endforeach
                            </select>
                            @endif

                        </div>
                    </div>
                    <hr @if(isset($added_item->dis_assems) && $added_item->dis_assems == 0)style="display: none" @endif>
                    <div class="form-group" @if ($booking->service_type_id == 6)style="display: none" @endif>
                        <div class="col-md-12 text-left">

                            @if(!empty($question))
                            <table>
                                @foreach($question as $k => $q)

                                @if($q->item_id == $added_item->item_id)
                                <tr>
                                    <td>
                                        <label class="form-label">Q).{{$q->title}} ?</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(isset($selected_item_answers[$q->id]->question_id) &&
                                        $selected_item_answers[$q->id]->question_id == $q->id)
                                        @if($selected_item_answers[$q->id]->answer == 'yes') Yes @endif
                                        @endif

                                        @if(isset($selected_item_answers[$q->id]->question_id) &&
                                        $selected_item_answers[$q->id]->question_id == $q->id)
                                        @if($selected_item_answers[$q->id]->answer == 'no') checked @endif
                                        @endif


                                    </td>
                                </tr>
                                @endif

                                @endforeach
                            </table>
                            @endif

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button name ="btn_submit" onclick="update_item_info({{ $added_item->booking_item_id }})" type="button" class="btn_update btn btn-success">Save</button>
                        <button type="button" class="btn btn-default border border-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>