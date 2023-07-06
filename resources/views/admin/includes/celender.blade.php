<div class="card border-blue">          
<div class="card-header bg-primary-800 header-elements-sm-inline">
<h6 class="card-title h3">Calendar {{date("Y")}}</h6>
<div class="header-elements w-50 justify-content-end">
<form action="/admin/dashboard" method="post" enctype="multipart/form-data" class="w-100">
{{ csrf_field() }}
    <div class="form-row">
        <div class="form-group mb-0 col text-right pt-1">
            <h5><strong>{{$c_date['now_month_text']}} {{$c_date['now_year']}}</strong></h5>
        </div>
        <div class="form-group mb-0 col">
            <select name="truck" class="form-control form-control-sm">
                @if(isset($trucks))
                    @foreach($trucks as $truck)
                        <option value="{{$truck->id}}">{{$truck->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group mb-0 col">
            <button type="submit" name="btn_search" value="true" class="btn bg-success mr-1 btn-sm"><i class="fa fa-search"></i> Search</button>
            <a href="/admin/dashboard" class="btn btn-outline-light btn-sm">Reset</a>
        </div>
        <div class="form-group mb-0">
            <button type="submit" name="btn_last" value="{{ $c_date['last_date'] }}"  class="btn btn-light btn-sm"><i class="icon-arrow-left15"></i></button>
            <button type="submit" name="btn_next" value="{{ $c_date['next_date'] }}"  class="btn btn-light btn-sm"><i class="icon-arrow-right15"></i></button>
        </div>
        
    </div>
</form>
</div>
</div>

<div class="card-body">
    <span class="p-1 mr-2"><span class="badge badge-danger align-top">T</span> Truck Not Assigned Yet</span>
    <span class="p-1 mr-2"><span class="badge badge-danger align-top">C</span> Captain Not Assigned Yet</span>


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
    @if($c_date['now_month'] == intval(date("m")) && $day == date("d")) <span class="today"><i>Today</i></span>@endif
    <br>
    @php
        $year = $c_date['now_year'];
        $month = (strlen($c_date['now_month']) < 2) ? '0'.$c_date['now_month'] : $c_date['now_month'];
        $date = (strlen($day) < 2) ? '0'.$day : $day;
        $full_date = $year . '-' . $month . '-' . $date;
    @endphp
    @if (isset($bookings[$full_date]))
    @foreach ($bookings[$full_date] as $booking)
    <a href="{{route('admin.booking_detail', [$booking['booking_id'], $full_date, 3])}}">
        <div style="display: flex;align-items: center;justify-content: center;" class="bg-primary">
            <div class="text-center bg-white text-primary border border-primary" style="width:90px"><span>{{isset($booking['start_time']) ? $booking['start_time'] : '?'}}<br>to<br>{{isset($booking['end_time']) ? $booking['end_time'] : '?'}}</span></div>
            <div style="display: flex;align-items: center">
                <div class="text-center text-dark text-capitalize ml-1 p-2 border border-dark bg-light">{{(strlen($booking['user_name']) > 3) ? substr($booking['user_name'], 0, 3) . '...' : $booking['user_name']}}</div>
                <div class="text-center text-dark ml-2 p-1 border border-dark bg-light"><img src="/dlevel-{{explode('-', $booking['dlevel'])[1]}}.png" style="height: 10px; width: auto;" />{{explode('-', $booking['dlevel'])[1]}}</div>
                <div class="text-center ml-3" style="display: flex;flex-direction: column;align-items:center;justify-content: center">
                    <div style="padding-top: 4px;width: 30px;height: 30px;background-color: @if(isset($booking['pickup']['color'])){{$booking['pickup']['color']}} @else#fff @endif" title="Zone From" class="text-dark text-center border border-dark">@if(!isset($booking['pickup']['color'])) ? @endif</div>
                    <div style="padding-top: 4px;width: 30px;height: 30px;background-color: @if(isset($booking['dropoff']['color'])){{$booking['dropoff']['color']}} @else#fff @endif" title="Zone To" class="text-dark text-center border border-dark">@if(!isset($booking['dropoff']['color'])) ? @endif</div>
                </div>
                <div class="text-center mr-2" style="display: flex;flex-direction: column;align-items:center;justify-content: space-between">
                    <div class="text-center text-info col-sm-6 mb-1"><i class="icon icon-checkmark-circle" style="font-size: 26px"></i></div>
                    <div class="text-center text-warning col-sm-6"><i class="icon icon-coin-dollar" style="font-size: 26px"></i></div>
                </div>
            </div>
        </div>
        {{-- <table class="mt-3 table table-bordered">
            <tr>
                <td colspan="2" class="text-center text-primary">{{isset($booking['start_time']) ? $booking['start_time'] : '?'}} to {{isset($booking['end_time']) ? $booking['end_time'] : '?'}}</td>
            </tr>
            <tr class="bg-primary">
                <td class="text-center text-white text-capitalize">{{$booking['user_name']}}</td>
                <td class="text-center text-white text-capitalize"><img src="/dlevel-{{explode('-', $booking['dlevel'])[1]}}.png" style="height: 20px; width: auto;" />{{explode('-', $booking['dlevel'])[1]}}</td>
            </tr>
            <tr class="bg-primary">
                <td colspan="2">
                    <div class="row">
                        <div style="background-color: @if(isset($booking['pickup']['color'])){{$booking['pickup']['color']}} @else#fff @endif" title="Zone From" class="text-dark text-center border border-warning col-6">@if(!isset($booking['pickup']['color'])) ? @endif</div>
                        <div style="background-color: @if(isset($booking['dropoff']['color'])){{$booking['dropoff']['color']}} @else#fff @endif" title="Zone To" class="text-dark text-center border border-warning col-6">@if(!isset($booking['dropoff']['color'])) ? @endif</div>
                    </div>
                </td>
            </tr>
            <tr class="bg-primary">
                <td colspan="2">
                    <div class="row">
                        <span class="text-center text-info col-sm-6"><i class="icon icon-checkmark-circle"></i></span>
                        <span class="text-center text-warning col-sm-6"><i class="icon icon-coin-dollar"></i></span>
                    </div>
                </td>
            </tr>
        </table> --}}
    </a>
    @endforeach
    @endif
    {{-- @foreach($jobs as $job) 
    @if($c_date['now_month'] == $job->month)
        
        @if(isset($job->day) && $job->day == $day && $c_date['now_month'] == $job->month)
        
            @if($job->primary_date > now()) 
                @php $btn_color = 'btn-primary'; @endphp
            @else    
                @php $btn_color = 'btn-success'; @endphp
            @endif
            
            @if($job->step > 0) 
                @php $btn_color = 'btn-outline-secondary'; @endphp
            @endif
            <a type="button" @if($job->step == 0)  href="/admin/user_request/{{$job->booking_id}}" @endif class="btn {{$btn_color}} btn-sm col-md-12 c_btn">{{$job->start_time}} - ({{$job->first_name}} {{$job->last_name}})
            
            @if($job->truck_id == '')
                <span class="badge badge-danger">T</span>
            @endif
            @if($job->captain_id == '')
                <span class="badge badge-danger">C</span>
            @endif
            </a>    
        @endif
        
    @endif    
    @endforeach --}}
    </td>
@endforeach
</tr>

@endforeach
</table>
</div>


</div>
</div> 