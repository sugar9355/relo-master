<div class="card border-blue">
    <div class="card-header bg-primary-800 header-elements-sm-inline">
        <h6 class="card-title h3">@if($date_type == 'pending') Pending @else Calendar {{date("Y")}} @endif</h6>
        <div class="header-elements w-50 justify-content-end">
        <form action="/admin/shuffle_show" method="post" enctype="multipart/form-data" class="w-100" id="shuffle_form">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group mb-0 col text-right pt-1">
                        <h5><strong>{{$c_date['now_month_text']}} {{$c_date['now_year']}}</strong></h5>
                    </div>
                    <div class="form-group mb-0 col">
                    <div class="form-group mb-0 col">
                        <select name="date_type" id="date_type" class="form-control form-control-sm">
                            <option value="0" @if($date_type == 0)selected @endif>Pickup</option>
                            <option value="1" @if($date_type == 1)selected @endif>Dropoff</option>
                            <option value="pending" @if($date_type == 'pending')selected @endif>Pending</option>
                        </select>
                    </div>
                    <div class="form-group mb-0" style="padding: 1em; text-align: center;">
                        <button type="submit" name="btn_last" value="{{ $c_date['last_date'] }}"
                            class="btn btn-light btn-sm"><i class="icon-arrow-left15"></i></button>
                        <button type="submit" name="btn_next" value="{{ $c_date['next_date'] }}"
                            class="btn btn-light btn-sm"><i class="icon-arrow-right15"></i></button>
                    </div>
                    </div>

                    @if($date_type == 'pending' and isset($pending_shuffle_bookings))
                    <div class="form-group mb-0">
                        <label class="container">All
                        <input class="sub-status-select" type="radio" @if($sub_status == '') checked @endif name="sub_status" value="">
                        <span class="checkmark" style="background-color:#EFEFEF;"></span>
                        </label>
                        <label class="container">Remind me later
                        <input class="sub-status-select" type="radio" @if($sub_status == 'Remind me later') checked @endif name="sub_status" value="Remind me later">
                        <span class="checkmark" style="background-color:#B5E61D;"></span>
                        </label>
                        <label class="container">Save for later
                        <input class="sub-status-select" type="radio" @if($sub_status == 'Save for later') checked @endif name="sub_status" value="Save for later">
                        <span class="checkmark" style="background-color:#99D9EA;"></span>
                        </label>
                        <label class="container">Skip for now
                        <input  class="sub-status-select"type="radio" @if($sub_status == 'Skip for now') checked @endif name="sub_status" value="Skip for now">
                        <span class="checkmark" style="background-color:#C8BFE7;"></span>
                        </label>
                    </div>
                    @endif
                    
                </div>
            </form>
        </div>
    </div>
    @if($date_type == 'pending' and isset($pending_shuffle_bookings))
    <div class="card-body">
        <div class="table-responsive mt-2">
            <table class="table table-bordered">
                <tr>
                    <th id="1" width="20%" class="text-center">Name</th>
                    <th id="2" width="20%" class="text-center">Booking Date</th>
                    <th id="3" width="20%" class="text-center">Zones</th>
                </tr>
                @foreach ($pending_shuffle_bookings as $booking)
                <tr>
                    <td><a href='{{route('admin.booking_detail', [$booking['booking_id'], $full_date, $date_type])}}'>{{ $booking['user_name'] }}</a></td>
                    <td>{{ $booking['booking_date'] }}</td>
                    <td>
                        <div class="text-center ml-3"
                            style="display: flex;flex-direction: column;align-items:center;justify-content: center">
                            <div style="padding-top: 4px;width: 30px;height: 30px;background-color: @if(isset($booking['pickup']['color'])){{$booking['pickup']['color']}} @else#fff @endif"
                                title="Zone From" class="text-dark text-center border border-dark">
                                @if(!isset($booking['pickup']['color'])) ? @endif</div>
                            <div style="padding-top: 4px;width: 30px;height: 30px;background-color: @if(isset($booking['dropoff']['color'])){{$booking['dropoff']['color']}} @else#fff @endif"
                                title="Zone To" class="text-dark text-center border border-dark">
                                @if(!isset($booking['dropoff']['color'])) ? @endif</div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @else
    <div class="card-body">
        <div class="table-responsive mt-2">
            <table class="table table-bordered">
                <tr>
                    <th id="1" width="14%" class="text-center">MON</th>
                    <th id="2" width="14%" class="text-center">TUE</th>
                    <th id="3" width="14%" class="text-center">WED</th>
                    <th id="4" width="14%" class="text-center">THU</th>
                    <th id="5" width="14%" class="text-center">FRI</th>
                    <th id="6" width="14%" class="text-center">SAT</th>
                    <th id="7" width="14%" class="text-center">SUN</th>
                </tr>
                @foreach ($calender[$c_date['now_month']] as $k =>$week)
                <tr>
                    @foreach($week as $day)
                    <td width="14%" height="80px">{{ ($day ? $day : '&nbsp;') }}
                        @if($c_date['now_month'] == intval(date("m")) && $day == date("d")) <span
                            class="today"><i>Today</i></span>@endif
                        <br>
                        @php
                        $year = $c_date['now_year'];
                        $month = (strlen($c_date['now_month']) < 2) ? '0' .$c_date['now_month'] : $c_date['now_month'];
                        $date=(strlen($day) < 2) ? '0' .$day : $day;
                        $full_date=$year . '-' . $month . '-' . $date;
                        @endphp
                        @if (isset($shuffle_bookings[$full_date]))
                        @foreach ($shuffle_bookings[$full_date] as $booking)
                        <a href="{{route('admin.booking_detail', [$booking['booking_id'], $full_date, $date_type])}}">
                            <div style="display: flex;align-items: center;justify-content: center;" class="bg-primary">
                                <div style="display: flex;align-items: center">
                                    <div
                                        class="text-center text-dark text-capitalize ml-1 p-2 border border-dark bg-light">
                                        {{(strlen($booking['user_name']) > 3) ? substr($booking['user_name'], 0, 3) . '...' : $booking['user_name']}}
                                    </div>
                                    <div class="text-center text-dark ml-2 p-1 border border-dark bg-light"><img
                                            src="/dlevel-{{explode('-', $booking['dlevel'])[1]}}.png"
                                            style="height: 10px; width: auto;" />{{explode('-', $booking['dlevel'])[1]}}
                                    </div>
                                    <div class="text-center ml-3"
                                        style="display: flex;flex-direction: column;align-items:center;justify-content: center">
                                        <div style="padding-top: 4px;width: 30px;height: 30px;background-color: @if(isset($booking['pickup']['color'])){{$booking['pickup']['color']}} @else#fff @endif"
                                            title="Zone From" class="text-dark text-center border border-dark">
                                            @if(!isset($booking['pickup']['color'])) ? @endif</div>
                                        <div style="padding-top: 4px;width: 30px;height: 30px;background-color: @if(isset($booking['dropoff']['color'])){{$booking['dropoff']['color']}} @else#fff @endif"
                                            title="Zone To" class="text-dark text-center border border-dark">
                                            @if(!isset($booking['dropoff']['color'])) ? @endif</div>
                                    </div>
                                    <div class="text-center mr-2"
                                        style="display: flex;flex-direction: column;align-items:center;justify-content: space-between">
                                        <div class="text-center text-info col-sm-6 mb-1"><i
                                                class="icon icon-checkmark-circle" style="font-size: 26px"></i></div>
                                        <div class="text-center text-warning col-sm-6"><i class="icon icon-coin-dollar"
                                                style="font-size: 26px"></i></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif
</div>
