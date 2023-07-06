@extends('admin.layout.base')

@section('title', 'Update Provider ')

@section('styles')
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/core/main.css')}}" />
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/daygrid/main.css')}}" />
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/timegrid/main.css')}}" />
<link rel="stylesheet" href="{{asset('fullcalendar-4.4.0/packages/list/main.css')}}" />
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>
@endsection

@section('content')

<!-- Vertical tabs -->
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header bg-white header-elements-sm-inline">
                <h6 class="card-title"> Employee</h6>
                <div class="header-elements">
                    <button type="button" class="btn alpha-primary border-primary text-primary-800 btn-icon ml-2"
                        data-toggle="modal" data-target="#bonus"><i class="icon-coins"></i></button>
                    <button type="button" class="btn alpha-primary border-primary text-primary-800 btn-icon ml-2"
                        data-toggle="modal" data-target="#badges"><i class="icon-medal-star"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="d-md-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0">
                        <li class="nav-item"><a href="#vertical-left-tab1" class="nav-link" data-toggle="tab"><i
                                    class="icon-user text-info mr-2"></i> Employee Details</a></li>
                        <li class="nav-item"><a href="#vertical-left-tab2" class="nav-link" data-toggle="tab"><i
                                    class="icon-cash text-primary mr-2"></i> Banking Details</a></li>
                        <li class="nav-item"><a href="#vertical-left-tab3" class="nav-link" data-toggle="tab"><i
                                    class="icon-alarm  text-teal  mr-2"></i> Working Hours</a></li>
                        <li class="nav-item"><a href="#vertical-left-tab4" class="nav-link active" data-toggle="tab"><i
                                    class="icon-calendar52  text-purple  mr-2"></i> Captain Schedule</a></li>
                        <li class="nav-item"><a href="#vertical-left-tab5" class="nav-link" data-toggle="tab"><i
                                    class="icon-medal text-dark   mr-2"></i> My Bages</a></li>
                        <li class="nav-item"><a href="#vertical-left-tab6" class="nav-link" data-toggle="tab"><i
                                    class="icon-users2 text-dark   mr-2"></i> Referal Details</a></li>

                    </ul>

                    <div class="tab-content w-100">
                        <div class="tab-pane fade show" id="vertical-left-tab1">
                            @include('admin.providers.employee_details')
                        </div>

                        <div class="tab-pane fade" id="vertical-left-tab2">
                            @include('admin.providers.payment_info')
                        </div>

                        <div class="tab-pane fade" id="vertical-left-tab3">
                            @include('admin.providers.working_hours')
                        </div>

                        <div class="tab-pane fade show active" id="vertical-left-tab4">
                            @include('admin.providers.captain_schedule')
                        </div>

                        <div class="tab-pane fade" id="vertical-left-tab5">

                            @include('admin.providers.my_badges')
                        </div>
                        <div class="tab-pane fade" id="vertical-left-tab6">

                            @include('admin.providers.referal_details')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /vertical tabs -->


@endsection
@section('scripts')
<script src="{{asset('fullcalendar-4.4.0/packages/core/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/interaction/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/daygrid/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/timegrid/main.js')}}"></script>
<script src="{{asset('fullcalendar-4.4.0/packages/list/main.js')}}"></script>
<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<!-- /theme JS files -->

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
            businessHours: {
                daysOfWeek: {{json_encode($available_days)}},
                startTime: '{{$available_start_time}}',
                endTime: '{{$available_end_time}}',
            },
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