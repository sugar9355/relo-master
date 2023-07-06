@php $year = date('y'); $b_date = array(); @endphp
@if(isset($booking_dates[0]))

@foreach($booking_dates as $dates)
@php $b_date[] = date('Y-m-d',strtotime($dates->booking_date)); @endphp
@endforeach

@endif

@if(isset($booking->primary_date))
@php
$p_date = explode('-',$booking->primary_date);
$p_date = Intval($p_date[1]).'-'.Intval($p_date[2]);
@endphp
@else
@php $p_date = ''; @endphp
@endif

@if(isset($booking->secondary_date))
@php
$s_date = explode('-',$booking->secondary_date);
$s_date = Intval($s_date[1]).'-'.Intval($s_date[2]);
@endphp
@else
@php $s_date = ''; @endphp
@endif

<style>
    .not-allowed {
        cursor: not-allowed !important;
    }
       .active32 {
    border-radius: 0px 0px 0px 0px;
    -moz-border-radius: 0px 0px 0px 0px;
    -webkit-border-radius: 0px 0px 0px 0px;
    background-color:none;
    transition: 0.3s;
    z-index: 1;
    -webkit-box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
    -moz-box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
    box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
}

.drop{
  background-color: grey;
}
.modal-backdrop {
   background-color: yellow;
}
[type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
    cursor: pointer;
    color: black!important;
}
li{
  font-size: 12px;

  margin: 0 auto;
}
#time-range p {
    font-family:"Arial", sans-serif;
    font-size:14px;
    color:#333;
}
.ui-slider-horizontal {
    height: 8px;
    background: #D7D7D7;
    border: 1px solid #BABABA;
    box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset;
    clear: both;
    margin: 8px 0;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    -ms-border-radius: 6px;
    -o-border-radius: 6px;
    border-radius: 6px;
}
.ui-slider {
    position: relative;
    text-align: left;
}
.ui-slider-horizontal .ui-slider-range {
    top: -1px;
    height: 100%;
}
.ui-slider .ui-slider-range {
    position: absolute;
    z-index: 1;
    height: 8px;
    font-size: .7em;
    display: block;
    border: 1px solid #5BA8E1;
    box-shadow: 0 1px 0 #AAD6F6 inset;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    -khtml-border-radius: 6px;
    border-radius: 6px;
    background: #81B8F3;
    background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
    background-size: 100%;
    background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #A0D4F5), color-stop(100%, #81B8F3));
    background-image: -webkit-linear-gradient(top, #A0D4F5, #81B8F3);
    background-image: -moz-linear-gradient(top, #A0D4F5, #81B8F3);
    background-image: -o-linear-gradient(top, #A0D4F5, #81B8F3);
    background-image: linear-gradient(top, #A0D4F5, #81B8F3);
}
.ui-slider .ui-slider-handle {
    border-radius: 50%;
    background: #F9FBFA;
    background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
    background-size: 100%;
    background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #C7CED6), color-stop(100%, #F9FBFA));
    background-image: -webkit-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: linear-gradient(top, #C7CED6, #F9FBFA);
    width: 22px;
    height: 22px;
    -webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    -moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    -webkit-transition: box-shadow .3s;
    -moz-transition: box-shadow .3s;
    -o-transition: box-shadow .3s;
    transition: box-shadow .3s;
}
.ui-slider .ui-slider-handle {
    position: absolute;
    z-index: 2;
    width: 22px;
    height: 22px;
    cursor: default;
    border: none;
    cursor: pointer;
}
.ui-slider .ui-slider-handle:after {
    content:"";
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    top: 50%;
    margin-top: -4px;
    left: 50%;
    margin-left: -4px;
    background: #30A2D2;
    -webkit-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
    -moz-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 white;
    box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
}
.ui-slider-horizontal .ui-slider-handle {
    top: -.5em;
    margin-left: -.6em;
}
.ui-slider a:focus {
    outline:none;
}

#panel {

  display: none;
}
.div-color1 {
    border:none;
}
</style>

<div class="contain-calendar">
    <div style="" class="calendar-title ">
        <i style="" class="far fa-calendar-alt "></i> Calendar
    </div>
    @foreach ($calender as $month => $value)
    @if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))

    <div id="month_{{$month}}" class="card hvr-shadow w-100 card-body  text-muted"
        style="@if($month == date('m')) @else display:none; @endif">

        <h5 class="m-0"><a href="#" class=" text-dark btn btn-link float-right">Price Low to High</a></h5>

        <div class="row col-md-12 pb-1">

            <div class="col-md-10">
                <h6 id="h{{date('m', mktime(0, 0, 0, $month, 10))}}"><i class="far fa-calendar-alt mr-2"></i>
                    {{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
            </div>

            <div class="col-md-1">
                @if($month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
                <button type="button" onclick="show_month('<','{{$month}}');"
                    class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-left hvr-icon"></i></button>
                @endif
            </div>
            <div class="col-md-1">
                @if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1))
                <button type="button" onclick="show_month('>','{{$month}}');"
                    class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-right hvr-icon"></i></button>
                @endif
            </div>

        </div>
        <div class="days ">
            <div class=" text-dark"><span>Sun</span><span>day</span></div>
            <div class=" text-dark"><span>Mon</span><span>day</span></div>
            <div class=" text-dark"><span>Tue</span><span>sday</span></div>
            <div class=" text-dark"><span>Wed</span><span>nesday</span></div>
            <div class=" text-dark"><span>Thu</span><span>rsday</span></div>
            <div class=" text-dark"><span>Fri</span><span>day</span></div>
            <div class=" text-dark"><span>Sat</span><span>urday</span></div>
        </div>

        <table class="table table-bordered w-100 mt-3">
            {{-- <thead>
                <tr class="bg-light text-dark text-center">
                    <th width="14%">MON</th>
                    <th width="14%">TUE</th>
                    <th width="14%">WED</th>
                    <th width="14%">THU</th>
                    <th width="14%">FRI</th>
                    <th width="14%">SAT</th>
                    <th width="14%">SUN</th>
                </tr>
            </thead> --}}
            <tbody class="text-center">
                @foreach ($value as $k =>$week)

                <tr>
                    @foreach($week as $day)
                    @php
                    $date_string = $year.'-'.$month.'-'.$day[0];
                    $date = date('Y-m-d',strtotime($date_string));
                    @endphp
                    @if($date > now())
                    <td id="td_{{$date}}" onclick="update_date_time('{{$date}}')"
                        class="cursor @if(in_array($date,$b_date)) bg-secondary text-white @endif "
                        style="background-color: {{$day[1]}}; position: relative" >
                    @else
                    <td class="text-muted not-allowed">
                    @endif
                        @if ($date_recommending && ($date == $recommended_data['booking_date']))
                        <span class="text-white bg-warning p-1" style="border-radius: 10%;position: absolute;right: 8px;top: 3px">R</span>
                        @endif
                        @if($day[0] > 0)
                        @php
                        $d_charge = 0;
                        if ($day[4] == 'N') {
                        $d_charge = $charges['basic_crew_charges'] + $charges['total_distance'] *
                        $charges['org_vehicle_mileage'];
                        } else {
                        foreach ($charges['vehicle_data'] as $data) {
                        if ($data->demand_id == $day[5]) {
                        $d_charge = $charges['basic_crew_charges'] * $day[4] + $charges['total_distance'] * $data->rate
                        + $data->reservation_fee;
                        }
                        }
                        }
                        @endphp
                        {{$day[0]}}
                        <br>
                        ${{floor($d_charge)}}+
                        @endif
                    </td>



                    @endforeach
                </tr>

                @endforeach
            </tbody>
        </table>

        {{-- <div class="row mt-1">

            @foreach ($demands as $d)
            <div class="col-md-4 p-2 text-center">
                <span class="badge badge-danger p-2 hvr-shadow"
                    style="background-color: {{$d->color}};">{{$d->demand_name}}</span>
            </div>
            @endforeach

        </div> --}}
        <div class="color-select">
            <div class="avail">
                <h4>Crew Availability</h4>
            </div>
            <div style="border-bottom:solid 1px #DCDCDC;padding-bottom: 10px; width: 100%; float:left; margin-bottom: 10px"></div>
            <div class="circle-cell">
                @foreach ($demands as $d)
                <div class="cir-con">
                    <div class="cir-yellow" style="background-color: {{$d->color}};"></div>
                    <span>{{$d->demand_name}}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- <p class="mt-3  font-weight-bold"><span class="badge bg-warning p-2 mr-2"> </span> Limited Availablity</p> --}}
    </div>

    @endif
    @endforeach
    
</div>

<script>
    var rec_date = '123';
    var start_time = '';
    var end_time = '';
    @if ($date_recommending)
    rec_date = '{{$recommended_data['booking_date']}}';
    start_time = '{{$recommended_data['start_time']}}';
    end_time = '{{$recommended_data['end_time']}}';
    @endif

    function update_date_time(date) {
        if (date == rec_date) {
            $.ajax({
                url: '/save_recommended_date/' + '{{$booking->booking_id}}',
                type: 'GET',
                data: {
                    date: rec_date,
                    start_time: start_time,
                    end_time: end_time
                },
                success: function(data, textStatus, jqXHR) {
                    if (textStatus == 'success') {
                        Notiflix.Loading.Hourglass('Loading...');
                        window.location.reload();
                    }
                }
            })
        } else {
            update_date(date);
        }
    }
</script>