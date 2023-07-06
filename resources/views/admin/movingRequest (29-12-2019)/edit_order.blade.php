@extends('admin.layout.base')

@section('title', 'Request details ')

@section('content')
    <style>
        .form-check-inline{
            height: 60px;
            padding: 1.3em;
        }
        .question-head{
            padding: 2.5rem 0;
        }
    </style>
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h4>Request details</h4>
                <div class="row">
                    <form class="form-horizontal" id="updateOrderForm" action="{{ route('admin.user_request.updateOrder', $request->id    ) }}" method="POST" enctype="multipart/form-data" role="form">
                        <input type="hidden" name="_method" value="PATCH">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="service_type" class="col-form-label">Service Type</label>
                                    <input type="text" id="service_type" class="form-control" value="{{ $request->serviceType }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="booking_date" class="col-form-label">Booking Date</label>
                                    <input type="text" id="booking_date" class="form-control" value="{{ $request->booking_date }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="distance" class="col-form-label">Distance</label>
                                    <input type="text" id="distance" class="form-control" value="{{ $request->distance }} Miles" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="minutes" class="col-form-label">Minutes</label>
                                    <input type="text" id="minutes" class="form-control" value="{{ $request->minutes }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <input type="hidden" id="locationsList" value="{{ $locations }}">
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">Start Location</label>
                                    <input type="text" id="start" class="form-control" value="{{ $request->s_address }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">Floor</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->first()->floor }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">Zip Code</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->first()->zip_code }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">How will the movers be moving the furniture?</label>
                                    @if($request->locations->first()->flight == null)
                                        <input type="text" id="start" class="form-control" value="Elevator" disabled>
                                    @elseif($request->locations->first()->elevator_type == null)
                                        <input type="text" id="start" class="form-control" value="Stairs" disabled>
                                    @else
                                        <input type="text" id="start" class="form-control" value="Both" disabled>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">What kind of stairs are they?</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->first()->stair_type }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">how many flights are there ?</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->first()->flight }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">What kind of elevator will they be using?</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->first()->elevator_type }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">Detailed Address</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->first()->detail_address }}" disabled>
                                </div>
                            </div>

                            @foreach(json_decode($request->waypoints) as $index => $locations)
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <label for="start" class="col-form-label">Stop Location {{ $index + 1 }}</label>
                                        <input type="text" id="start" class="form-control" value="{{ $locations }}" disabled>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="floor" class="col-form-label">Floor</label>
                                        <input type="text" id="floor" class="form-control" value="{{ $request->locations[$index+1]->floor }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <label for="floor" class="col-form-label">Zip Code</label>
                                        <input type="text" id="floor" class="form-control" value="{{ $request->locations[$index+1]->zip_code }}" disabled>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="start" class="col-form-label">How will the movers be moving the furniture?</label>
                                        @if($request->locations[$index+1]->flight == null)
                                            <input type="text" id="start" class="form-control" value="Elevator" disabled>
                                        @elseif($request->locations[$index+1]->elevator_type == null)
                                            <input type="text" id="start" class="form-control" value="Stairs" disabled>
                                        @else
                                            <input type="text" id="start" class="form-control" value="Both" disabled>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <label for="floor" class="col-form-label">What kind of stairs are they?</label>
                                        <input type="text" id="floor" class="form-control" value="{{ $request->locations[$index+1]->stair_type }}" disabled>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="start" class="col-form-label">how many flights are there ?</label>
                                        <input type="text" id="floor" class="form-control" value="{{ $request->locations[$index+1]->flight }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <label for="floor" class="col-form-label">What kind of elevator will they be using?</label>
                                        <input type="text" id="floor" class="form-control" value="{{ $request->locations[$index+1]->elevator_type }}" disabled>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="start" class="col-form-label">Detailed Address</label>
                                        <input type="text" id="floor" class="form-control" value="{{ $request->locations[$index+1]->detail_address }}" disabled>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">End Location</label>
                                    <input type="text" id="start" class="form-control" value="{{ $request->d_address }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">Floor</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->last()->floor }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">Zip Code</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->last()->zip_code }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">How will the movers be moving the furniture?</label>
                                    @if($request->locations->last()->flight == null)
                                        <input type="text" id="start" class="form-control" value="Elevator" disabled>
                                    @elseif($request->locations->last()->elevator_type == null)
                                        <input type="text" id="start" class="form-control" value="Stairs" disabled>
                                    @else
                                        <input type="text" id="start" class="form-control" value="Both" disabled>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">What kind of stairs are they?</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->last()->stair_type }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">how many flights are there ?</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->last()->flight }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <label for="floor" class="col-form-label">What kind of elevator will they be using?</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->last()->elevator_type }}" disabled>
                                </div>
                                <div class="col-xs-6">
                                    <label for="start" class="col-form-label">Detailed Address</label>
                                    <input type="text" id="floor" class="form-control" value="{{ $request->locations->last()->detail_address }}" disabled>
                                </div>
                            </div>
                            <div id="item">
                                @foreach($request->userMovingRequestItems as $itemIndex => $item)
                                    <div class="form-group row item{{ $itemIndex }}" style="border-top: 1px solid #000;">
                                        <div class="col-xs-6">
                                            <label for="floor" class="col-form-label">Item</label>
                                            <input type="text" id="floor" name="item[]" class="form-control" value="{{ $item->name }}" readonly>
                                        </div>
                                        @php $cartOptions = json_decode($item->options); @endphp


                                        @foreach($item->item->questions as $questionIndex => $question)
                                            <div class="col-xs-6">
                                                <label for="{{ $questionIndex }}" class="question-head col-form-label">{{ $question->title }}</label>
                                                @foreach($question->answers as $answer)
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            @php
                                                                $myAnswer = $question->id.'_'.$answer->title;
                                                                $active = null;
                                                                if($cartOptions->answersArray[$questionIndex] == $myAnswer){
                                                                    $active = 'checked';
                                                                }
                                                            @endphp
                                                            <input type="radio" class="form-check-input" name="answer_{{ $itemIndex.'_'.$questionIndex }}" value="{{ $question->id }}_{{ $answer->title }}" {{ $active }}>  {{ $answer->title }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                        <div class="col-xs-6">
                                            <label for="floor" class="col-form-label">Additional Information</label>
                                            <input type="text" id="floor" name="additional_information[]" class="form-control" value="{{ $cartOptions->additional_info }}">
                                        </div>
                                        <div class="col-xs-6">
                                            <label for="floor" class="col-form-label">Pickup Address</label>
                                            <input type="text" id="floor" name="pickup[]" class="form-control" value="{{ $cartOptions->pickup }}">
                                        </div>
                                        <div class="col-xs-6">
                                            <label for="floor" class="col-form-label">Drop Address</label>
                                            <input type="text" id="floor" name="drop[]" class="form-control" value="{{ $cartOptions->drop }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6" style="margin: 20px 0">
                            <button class="btn btn-info" type="submit" id="addRow">Add</button>
                        </div>
                        <div class="col-md-6" style="margin: 20px 0">
                            <button class="btn btn-danger" type="submit" id="removeRow">Remove</button>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit" id="updateOrder">Update Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Please Select Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sel1">Select Item:</label>
                        <select class="form-control" id="sel1" onchange="selectOption(this)">
                            <option value="">Select Items</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitRowItem">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
        .panel-group .panel {
            border-radius: 0;
            box-shadow: none;
            border-color: #EEEEEE;
        }

        .select2-container{
            width: 200px !important;
        }

        .panel-default > .panel-heading {
            padding: 0;
            border-radius: 0;
            color: #212121;
            background-color: #FAFAFA;
            border-color: #EEEEEE;
        }

        .panel-title {
            font-size: 14px;
        }

        .panel-title > a {
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .more-less {
            float: right;
            color: #212121;
        }

        .panel-default > .panel-heading + .panel-collapse > .panel-body {
            border-top-color: #EEEEEE;
        }
    </style>
@endsection

@section('scripts')
    <script>
        let optionVal = null;
        function validateItems(){
            let $item = $("#item");
            let $children = $item.children();
            for (let i = 0; i < $children.length; i++) {
                let $mainDiv = $($children[i]);
                let radioBtns = $mainDiv.find('input[type=radio]');
                let radioCount = radioBtns.length;
                for (let j = 0; j < radioCount; j++) {
                    let name = $(radioBtns[j]).attr('name');
                    if (!$('input[name=' + name + ']').is(":checked")){
                        return false;
                    }
                }
            }
            return true;
        }
        $(function () {
            $("#sel1").select2();
            $('#removeRow').on('click', (event) => {
                event.preventDefault();
                let $item = $("#item");
                let $children = $item.children();
                let div = $children[$children.length-1];
                if ($children.length === 1){
                    $('#removeRow').attr('disabled', 'true')
                }
                $(div).remove();
            });
            $('#updateOrder').on('click', (event) => {
                event.preventDefault();
                let $item = $("#item");
                let $children = $item.children();
                if ($children.length === 0){
                    alert('Please Add At Least One Item');
                    return;
                }
                let validated = validateItems();
                if (!validated){
                    alert('Please Enter All Item Information Correctly');
                    return false;
                }
                $('#updateOrderForm').submit();
            });
            $('#addRow').on('click', (event) => {
                event.preventDefault();
                $(".modal").modal();

            });
            $('#submitRowItem').on('click', () => {
                if (optionVal == null){
                    return false;
                }
                $('.modal').modal('toggle');

                $('#removeRow').removeAttr('disabled');
                let newItem = optionVal;
                optionVal = null;
                $('#sel1').val("").trigger('change');
                let $item = $("#item");
                let $children = $item.children();
                let index = $children.length;
                let locationsList = JSON.parse($("#locationsList").val());

                $.get('/admin/user_request/get_item/'+newItem, (data) => {
                    let html = `<div class="form-group row item${ index }" style="border-top: 1px solid #000;">
                                        <div class="col-xs-6">
                                            <label for="floor" class="col-form-label">Item</label>
                                            <input type="text" id="floor" name="item[]" class="form-control" value="${ data.name }" readonly>
                                        </div>`;

                    data.questions.forEach((question, questionIndex) => {
                        html += `<div class="col-xs-6">
                                    <label for="${ questionIndex }" class="question-head col-form-label">${ question.title }</label>`;
                                question.answers.forEach((answer, answerIndex) => {
                                    html += `<div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input"
                                                            name="answer_${ index +'_'+ questionIndex }"
                                                            value="${ question.id }_${ answer.title }" required>  ${ answer.title }
                                                </label>
                                            </div>`;
                                });
                        html += `</div>`;
                    });

                    html += `<div class="col-xs-6">
                                <label for="floor" class="col-form-label">Additional Information</label>
                                <input type="text" id="floor" name="additional_information[]" required class="form-control">
                            </div>
                            <div class="col-xs-6">
                                <label for="floor" class="col-form-label">Pickup Address</label>
                                <select name="pickup[]" class="form-control">`;
                                    locationsList.forEach((location, index) => {
                                                    let selected = "";
                                                    if (index === 0){
                                                        selected = "selected";
                                                    }
                                                    html += `<option value="${location}" ${selected}>${location}</option>`;
                                                });
                    html +=     `</select>
                            </div>
                            <div class="col-xs-6">
                                <label for="floor" class="col-form-label">Drop Address</label>
                                <select name="drop[]" class="form-control">`;
                                    locationsList.forEach((location,index) => {
                                        let selected = "";
                                        let lastIndex = locationsList.length-1;
                                        console.log(lastIndex);
                                        if (index === lastIndex){
                                            selected = "selected";
                                        }
                                        html += `<option value="${location}" ${selected}>${location}</option>`;
                                    });
                    html +=     `</select>
                            </div>`;

                    $item.append(html);
                });
            });
        });

        function selectOption(me) {
            let val = $(me).val();
            optionVal = val;
            if (val == ""){
                optionVal = null;
            }
        }
    </script>
@endsection
