@extends('user.layout.base')

@section('title', 'My Trips ')

@section('styles')
    <style>
        .modal-title{color: black;}
        .myLabel{color: black;}
    </style>
@endsection

@section('content')

    <div class="col-md-9">
        <div class="dash-content">
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">Saved Jobs</h4>
                </div>
            </div>

            <div class="row no-margin ride-detail">
                <div class="col-md-12">
                    @if($trips->count() > 0 || $storageTrips->count() > 0 || $junkTrips->count() > 0)
                        <table class="table table-condensed" style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>@lang('user.booking_id')</th>
                                <th>@lang('user.date')</th>
                                <th>Deposit</th>
                                <th>Estimated Amount</th>
                                <th>@lang('user.type')</th>
                                <th>@lang('user.payment')</th>
                                <th>Action</th>
                                <th>View</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($trips as $index => $trip)
                                @if($trip->status == 'SAVE' || $trip->status == 'Pending')
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y',strtotime($trip->booking_date))}}</td>
                                        <td>{{currency($trip->charge_deposit)}}</td>
                                        <td>{{currency($trip->min) .'-'. currency($trip->max)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        @if($trip->status == 'SAVE')
                                            <td><a class="btn btn-info" href="/book_now/moving/{{ $trip->id }}"
                                                   onclick="return confirm('Are You Sure?')">Book
                                                    Now/Pay</a></td>
                                        @else
                                            <td>Pending</td>
                                        @endif
                                        <td><a class="btn btn-info" href="/trip/show/moving/{{ $trip->id }}">View</a></td>
                                    </tr>
                                @endif
                            @endforeach

                            @foreach($storageTrips as $index => $trip)
                                @if($trip->status == 'SAVE' || $trip->status == 'Pending')
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y',strtotime($trip->booking_date))}}</td>
                                        <td>{{currency($trip->charge_deposit)}}</td>
                                        <td>{{currency($trip->min) .'-'. currency($trip->max)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        @if($trip->status == 'SAVE')
                                            <td><a class="btn btn-info" href="/book_now/storage/{{ $trip->id }}"
                                                   onclick="return confirm('Are You Sure?')">Book
                                                    Now/Pay</a></td>
                                        @else
                                            <td>Pending</td>
                                        @endif
                                        <td><a class="btn btn-info" href="/trip/show/storage/{{ $trip->id }}">View</a></td>
                                    </tr>
                                @endif
                            @endforeach

                            @foreach($junkTrips as $index => $trip)
                                @if($trip->status == 'SAVE' || $trip->status == 'Pending')
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y',strtotime($trip->booking_date))}}</td>
                                        <td>{{currency($trip->charge_deposit)}}</td>
                                        <td>{{currency($trip->min) .'-'. currency($trip->max)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        @if($trip->status == 'SAVE')
                                            <td><a class="btn btn-info" href="/book_now/junk/{{ $trip->id }}"
                                                   onclick="return confirm('Are You Sure?')">Book
                                                    Now/Pay</a></td>
                                        @else
                                            <td>Pending</td>
                                        @endif
                                        <td><a class="btn btn-info" href="/trip/show/junk/{{ $trip->id }}">View</a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No trips Available</p>
                    @endif
                </div>
            </div>

            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">Past Jobs</h4>
                </div>
            </div>

            <div class="row no-margin ride-detail">
                <div class="col-md-12">
                    @if($trips->count() > 0 || $storageTrips->count() > 0 || $junkTrips->count() > 0)
                        <table class="table table-condensed" style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>@lang('user.booking_id')</th>
                                <th>@lang('user.date')</th>
                                <th>@lang('user.amount')</th>
                                <th>@lang('user.type')</th>
                                <th>@lang('user.payment')</th>
                                <th>View</th>
                                <th>Return Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($trips as $index => $trip)
                                @if($trip->status == 'COMPLETED')
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y',strtotime($trip->booking_date))}}</td>
                                        <td>{{currency($trip->quotation)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        <td><a class="btn btn-info" href="/trip/show/moving/{{ $trip->id }}">View</a></td>
                                        <td>Not Applicable</td>
                                    </tr>
                                @endif
                            @endforeach

                            @foreach($storageTrips as $index => $trip)
                                @if($trip->status == 'COMPLETED')
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y',strtotime($trip->booking_date))}}</td>
                                        <td>{{currency($trip->quotation)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        <td><a class="btn btn-info" href="/trip/show/storage/{{ $trip->id }}">View</a></td>
                                        <td>
                                            @if(!$trip->drop)
                                                <a class="btn btn-info" onclick="showStorageItemModal('{{ $trip->id }}')">Return</a>
                                            @else
                                                Returned
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @foreach($junkTrips as $index => $trip)
                                @if($trip->status == 'COMPLETED')
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y',strtotime($trip->booking_date))}}</td>
                                        <td>{{currency($trip->quotation)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        <td><a class="btn btn-info" href="/trip/show/junk/{{ $trip->id }}">View</a></td>
                                        <td>Not Applicable</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">No trips Available</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
    </div>
@endsection

@section('scripts')
    <script>
		function showStorageItemModal(id) {
			let url = '/trip/storage/item/' + id;
			axios.get(url)
				.then(data => {
					$(".modal").html(data.data.html).modal();
				})
				.catch(error => {
					console.log(error);
				})
		}
		function submitMyModalForm() {
			$("#itemForm").submit();
		}
    </script>
@endsection
