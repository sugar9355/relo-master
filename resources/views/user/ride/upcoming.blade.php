@extends('user.layout.base')

@section('title', 'Upcoming Trips ')

@section('content')

    <div class="col-md-9">
        <div class="dash-content">
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">@lang('user.upcoming_trips')</h4>
                </div>
            </div>

            <div class="row no-margin ride-detail">
                <div class="col-md-12">
                    @if($trips->count() > 0 || $storageTrips->count() > 0 || $junkTrips->count() > 0)
                        <table class="table table-condensed" style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th>@lang('user.booking_id')</th>
                                <th>@lang('user.date')</th>
                                <th>@lang('user.time')</th>
                                <th>@lang('user.amount')</th>
                                <th>Remaining Amount</th>
                                <th>@lang('user.type')</th>
                                <th>@lang('user.payment')</th>
                                <th>View</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($trips as $index => $trip)
                                @if($trip->status == 'ASSIGNED' || $trip->status == 'UNASSIGNED')
                                    <tr>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y', strtotime($trip->booking_date))}}</td>
                                        <td>{{$trip->time}}</td>
                                        <td>{{currency($trip->quotation)}}</td>
                                        <td>{{currency($trip->quotation - $trip->charge_deposit)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        <td><a class="btn btn-info" href="/trip/show/moving/{{ $trip->id }}">View</a></td>
                                    </tr>
                                @endif
                            @endforeach

                            @foreach($storageTrips as $index => $trip)
                                @if($trip->status == 'ASSIGNED' || $trip->status == 'UNASSIGNED')
                                    <tr>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y', strtotime($trip->booking_date))}}</td>
                                        <td>{{$trip->time}}</td>
                                        <td>{{currency($trip->quotation)}}</td>
                                        <td>{{currency($trip->quotation - $trip->charge_deposit)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
                                        <td><a class="btn btn-info" href="/trip/show/storage/{{ $trip->id }}">View</a></td>
                                    </tr>
                                @endif
                            @endforeach

                            @foreach($junkTrips as $index => $trip)
                                @if($trip->status == 'ASSIGNED' || $trip->status == 'UNASSIGNED')
                                    <tr>
                                        <td>{{ $trip->id }}</td>
                                        <td>{{date('d-m-Y', strtotime($trip->booking_date))}}</td>
                                        <td>{{$trip->time}}</td>
                                        <td>{{currency($trip->quotation)}}</td>
                                        <td>{{currency($trip->quotation - $trip->charge_deposit)}}</td>
                                        <td>{{$trip->serviceType}}</td>
                                        <td>@lang('user.paid_via') Card</td>
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

        </div>
    </div>
@endsection
