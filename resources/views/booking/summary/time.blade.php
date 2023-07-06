@if(!empty($booking->booking_date))
@if($booking->flexible == 0)
@if(!$slot || ($booking->crew != null && $booking->exist_hours == false))
<div class="specific-time">
    <div>
        <span style="padding-left:76px;">Specific time</span>
    </div>
    <div>
        <input type="number" class="js-range-slider">
    </div>
</div>

<script>
    var $range = $(".js-range-slider");
    var start_time = '6:00 AM';
    var end_time = '6:00 PM';

    var values = ['6:00 AM', '8:00 AM', '10:00 AM', '12:00 PM', '2:00 PM', '4:00 PM', '6:00 PM'];
    var values_p = ['6:00 AM', '8:00 AM', '10:00 AM', '12:00 PM', '2:00 PM', '4:00 PM', '6:00 PM'];

    $range.ionRangeSlider({
        type: "double",
        grid: true,
        values: values,
        prettify: function (n) {
            var ind = values.indexOf(n);
            return values_p[ind];
        },
        onStart: function (data) {
            start_time = data.from_value;
            end_time = data.to_value;
            $.ajax({
                url : "/save_time/"+booking_id+"/"+start_time+"/"+end_time,
                type: "Get",
                success:function(data, textStatus, jqXHR) 
                {
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                }
            });
        },
        onChange: function (data) {
            start_time = data.from_value;
            end_time = data.to_value;
            $.ajax({
                url : "/save_time/"+booking_id+"/"+start_time+"/"+end_time,
                type: "Get",
                success:function(data, textStatus, jqXHR) 
                {
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                }
            });
        }
    });
</script>
@elseif($booking->exist_hours == 'hours_not_available')
    
    <div class="row col-md-12 mt-3">
        <div class="alert alert-danger col-md-12 shadow">
          <strong>Oops!</strong> Hours not available.
        </div>
    </div>

{{-- @elseif($booking->crew == null)

    <div class="card hvr-shadow w-100 card-body mt-3">
        
        <div class="row">
            <div class="alert alert-danger col-md-12">
                  <strong>Oops!</strong> Workers not available.
            </div>
        </div>

        <p class="font-weight-normal lead mt-3"><a href="#" class="text-info"  data-toggle="modal" data-target="#staticBackdrop"><u>I need a specific start time</u></a></p>

    </div>    
 --}}
@elseif ($slot)
<div class="time-show" style="height: 310px">
    <div class="icon-time pl-3">
        <i class="fas fa-stopwatch pl-3" style="margin-right:10px;"></i>
        <span style="font-size: 23px;color: #6B6B6B;">Time</span>
    </div>
    <div class="middle" style="margin-top:110px;">
        @foreach(explode(',',$booking->exist_hours) as $k => $exist_hours)
        @php
        $selected = false;
        $seg = explode('-',$exist_hours);
        $first_seg = current($seg);
        $end_seg = end($seg);
        if ($first_seg == $booking->start_time && $end_seg == $booking->end_time) {
            $selected = true;
        }
        @endphp
        <button href="#" class="btn-4preview btn1 slot" style="@if ($selected) background-color: #9e9e9e @endif" data-start="{{$first_seg}}" data-end="{{$end_seg}}">
            <div id="booking_time_{{$k}}" class="circle"></div> {{$first_seg}} - {{$end_seg}}
        </button>
        @endforeach
    </div>
</div>

@endif
@endif
@endif
<script>
    $(".slot").click(function() {
        event.stopPropagation();
        event.preventDefault();
        $(".slot").css({
            backgroundColor: '#fff',
            color: '#000'
        })

        $(this).css({
            backgroundColor: '#9e9e9e',
        })
        var start = $(this).data('start');
        var end = $(this).data('end');
        save_time(start, end);
    })
</script>