@extends('admin.layout.base')

@section('title', 'Vehicle Schedule ')

@section('styles')
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/core/main.css')}}" />
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/daygrid/main.css')}}" />
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/timegrid/main.css')}}" />
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/list/main.css')}}" />
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title text-capitalize">vehilce schedule</h5>
    </div>

    <div class="card-body">
        <div class="container-fluid row">
            <div id='calendar' class='calendar col-md-12' style="display: block"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('fullcalendar-4.4.0/packages/core/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/interaction/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/daygrid/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/timegrid/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/list/main.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            defaultView: 'timeGridWeek',
            minTime: "00:00",
            maxTime: "24:00",
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            slotEventOverlap: false,
            @php
            echo "events: ". $booked_times . "\n";
            @endphp
        });

        calendar.render();
    });

</script>
@endsection
