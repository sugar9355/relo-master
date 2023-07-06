<style>
   div.checkbox.switcher label, div.radio.switcher label {
  padding: 0;
}
div.checkbox.switcher label *, div.radio.switcher label * {
  vertical-align: middle;
}
div.checkbox.switcher label input, div.radio.switcher label input {
  display: none;
}
div.checkbox.switcher label input + span, div.radio.switcher label input + span {
  position: relative;
  display: inline-block;
  margin-right: 10px;
  width: 56px;
  height: 28px;
  background: #f2f2f2;
  border: 1px solid #eee;
  border-radius: 50px;
  transition: all 0.3s ease-in-out;
}
div.checkbox.switcher label input + span small, div.radio.switcher label input + span small {
  position: absolute;
  display: block;
  width: 50%;
  height: 100%;
  background: #fff;
  border-radius: 50%;
  transition: all 0.3s ease-in-out;
  left: 0;
}
div.checkbox.switcher label input:checked + span, div.radio.switcher label input:checked + span {
  background: #269bff;
  border-color: #269bff;
}
div.checkbox.switcher label input:checked + span small, div.radio.switcher label input:checked + span small {
  left: 50%;
} 
    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 10px;
    }
    
    .table td,
.table th {
   
    font-size: 12px;
    padding: 2px;
    vertical-align: middle;
    
    height: 53px;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #f1f1f1;
}
    </style>
    
@php $year = date('y'); @endphp

@if (isset($booking->primary_date))
    @php
        $p_date = explode('-',$booking->primary_date);
        $p_date = Intval($p_date[1]).'-'.Intval($p_date[2]);
    @endphp
@else
    @php $p_date = ''; @endphp
@endif

@if (isset($booking->secondary_date))
    @php
        $s_date = explode('-',$booking->secondary_date);
        $s_date = Intval($s_date[1]).'-'.Intval($s_date[2]);
    @endphp
@else
    @php $s_date = ''; @endphp
@endif

<div class="contain-calendar">
    <div style="" class="calendar-title ">
        <i style="" class="far fa-calendar-alt "></i> Dropoff Date
    </div>
    @foreach ($calender2 as $month => $value)
    @if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))

    <div id="month_{{$month}}_right" class="card hvr-shadow w-100 card-body  text-muted"
        style="@if($month == date('m')) @else display:none; @endif">

        <div class="row col-md-12 pb-1">
            <div class="col-md-12 text-center">
                <h6 id="h{{date('m', mktime(0, 0, 0, $month, 10))}}"><i class="far fa-calendar-alt mr-2"></i>
                    {{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
            </div>

        </div>
        <div class="row col-md-12 mt-1 mb-1">
            <div class="col-md-10"></div>
            <div class="col-md-1">
                @if($month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
                <button type="button" onclick="show_month_right('<','{{$month}}');"
                    class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-left hvr-icon"></i></button>
                @endif
            </div>
            <div class="col-md-1">
                @if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1))
                <button type="button" onclick="show_month_right('>','{{$month}}');"
                    class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-right hvr-icon"></i></button>
                @endif
            </div>
        </div>

        <div class="days ">
            <div class=" text-dark"><span>S</span></div>
            <div class=" text-dark"><span>M</span></div>
            <div class=" text-dark"><span>T</span></div>
            <div class=" text-dark"><span>W</span></div>
            <div class=" text-dark"><span>T</span></div>
            <div class=" text-dark"><span>F</span></div>
            <div class=" text-dark"><span>S</span></div>
        </div>

        <table class="table table-bordered w-100 ">
            <tbody class="text-center">
                @foreach ($value as $k =>$week)
                <tr>
                    @foreach($week as $day)
                        @php
                        $date_string = $year.'-'.$month.'-'.$day[0];
                        $date = date('Y-m-d',strtotime($date_string));
                        $dropoff_date ='';
                        if(count($booking_dates) > 0) {
                            foreach ($booking_dates as $b_data) {
                                if ($b_data->type == 1 && $b_data->date == $date) {
                                    $dropoff_date = $b_data->date;
                                }
                            }
                        }
                        @endphp
                        @if($date > now())
                        <td id="td_dropoff_{{$date}}" onclick="open_modal('{{$date}}', 1)"
                            class=" cursor dropoff_dates @if ($date == $dropoff_date)shadow-date  @endif"
                            style="background-color: {{$day[1]}};">
                        @else
                        <td class="zxc text-muted not-allowed">
                        @endif
                        @if($day[0] > 0)
                            @php
                            $d_charge = 0;
                            if (isset($charges['peak_factor'][strtotime($date)])) {
                                $d_charge = $charges['shuffle_price'][1] * $charges['peak_factor'][strtotime($date)]['dropoff'] + $charges['dropoff_items'] + ($charges['storage'] / 2);
                            }
                            @endphp
                            {{$day[0]}}
                            <span class="dropoff_charge" style="display: none">{{number_format($d_charge, 2)}}</span>
                        @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endforeach
</div>

<div class="modal fade " id="modalPoll-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
    <div class=" modal-dialog modal-full-height modal-right modal-notify modal-info drop" role="document">
        <div class="modal-content ">
            <!--Header-->
            <div class="modal-header bg-warning">
                <span style="    position: relative;
                left: 190px;" id="date_1" class="font-weight-bold">Time</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <hr>
                    <!-- Radio -->
                    <p class="text-center">
                    </p>
                    <div class="form-check col-8 mb-4 div-color1 m-auto mb-3">
                        <label class="form-check-label ml-2 col-12" for="radio-179">
                            Do you have any time constraints on the move in time?
                        </label>
                        {{-- <label class="form-check-label ml-2 col-12" for="radio-179">
                            <button style="outline:none; border:none; " class="btn-sm btn-warning slideup" onclick="show_time(1)">Yes</button>
                            <button style="outline:none; border:none;  close" data-dismiss="modal" aria-label="Close"
                            class="btn-sm btn-warning" onclick="update_date_only(1)">No</button>
                        </label> --}}
                        <div class="checkbox switcher mt-3">
                            <label for="test2">
                                <small>Flexible</small>
                                <span><small></small></span>
                              <input type="checkbox" id="test2" value="">
                              <span style="background-color:#007BFF;"><small></small></span>
                              <small>Non Flexible</small>
                            </label>
                        </div>
                        <hr>
                        <label class="form-check-label ml-2 col-12" id="text_flexible_1" style="font-size: {{$font_info_flexible->font_size}}px;color: {{$font_info_flexible->color}}">
                            {{$font_info_flexible->name}}
                        </label>
                        <label class="form-check-label ml-2 col-12" id="text_unflexible_1" style="font-size: {{$font_info_unflexible->font_size}}px;color: {{$font_info_unflexible->color}};display: none">
                            {{$font_info_unflexible->name}}
                        </label>
                    </div>
                    <div id="panel1" class="form-check mb-4 div-color1 col-8 m-auto pt-3" style="display: none;">
                        <div id="time-range-1">
                            <p>Time Range: <span class="slider-time-1 font-weight-bold">06:00 AM</span> - <span class="slider-time2-1 font-weight-bold">09:00 PM</span>
                            </p>
                            <div class="sliders_step1">
                                <div id="slider-range-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Radio -->
            </div>
            <!--Footer-->
            <div style="border-top: 1px solid #dee2e6; " class="modal-footer justify-content-center">
                <a type="button" style="background-color:#28a745;" class="btn btn-outline-success  dvvv drop-btn" onclick="update_date_time(1)">Continue</a>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="chosen_date_1" />
<input type="hidden" id="chosen_start_time_1" />
<input type="hidden" id="chosen_end_time_1" />