@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
<!-- 
    <link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}"> 
    
    
    
        Theme JS files 
    
    
    <script src="{{asset('celender/ui/fullcalendar/fullcalendar.min.js')}}"></script>

    
    <script src="{{asset('celender/demo_pages/fullcalendar_styling.js')}}"></script>
    
        
    <script src="{{asset('assets_admin/js/plugins/pickers/daterangepicker.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/pickers/anytime.min.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('assets_admin/js/plugins/pickers/pickadate/legacy.js')}}"></script>
    
    <script src="{{asset('assets_admin/js/demo_pages/picker_date.js')}}"></script>
-->
<style>
table {
    border-collapse: collapse;
    width: 100%; 
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {background-color: #f9f9f9;}

.c_btn
{
    font-size:12px;
    margin-bottom: 3px;
    text-align: left;
    padding: 2px 5px;
}

.today
{
    background-color: #5cb85c;
    padding: 2px 10px 2px 10px;
    color: white;
    font-size: 12px;
    margin-left: 10px;
}

.clickable-row {    
    cursor: pointer;    
}   
/* The container */ 
.container {    
  display: block;   
  position: relative;   
  padding-left: 35px;   
  margin-bottom: 12px;  
  cursor: pointer;  
  font-size: 22px;  
  -webkit-user-select: none;    
  -moz-user-select: none;   
  -ms-user-select: none;    
  user-select: none;    
}   
/* Hide the browser's default radio button */   
.container input {  
  position: absolute;   
  opacity: 0;   
  cursor: pointer;  
}   
/* Create a custom radio button */  
.checkmark {    
  position: absolute;   
  top: 0;   
  left: 0;  
  height: 25px; 
  width: 25px;  
  background-color: #eee;   
}   
/* On mouse-over, add a grey background color */    
.container:hover input ~ .checkmark {   
  background-color: #ccc;   
}   
/* When the radio button is checked, add a blue background */   
.container input:checked ~ .checkmark { 
  background-color: #2196F3;    
}   
/* Create the indicator (the dot/circle - hidden when not checked) */   
.checkmark:after {  
  content: "";  
  position: absolute;   
  display: none;    
}   
/* Show the indicator (dot/circle) when checked */  
.container input:checked ~ .checkmark:after {   
  display: block;   
}   
/* Style the indicator (dot/circle) */  
.container .checkmark:after {   
    top: 9px;   
    left: 9px;  
    width: 8px; 
    height: 8px;    
    border-radius: 50%; 
    background: white;  
}
</style>    
    
@endsection

@section('content')

@include('admin.dashboard.count')

<!-- Badges -->
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header header-elements-inline">
<h6 class="card-title">Booking</h6>
<div class="header-elements">
    <div class="list-icons">
        <a class="list-icons-item" data-action="collapse"></a>
        <a class="list-icons-item" data-action="reload"></a>
        <a class="list-icons-item" data-action="remove"></a>
    </div>
</div>
</div>

<div class="card-body">
<ul class="nav nav-tabs nav-tabs-highlight">
    
    <li class="nav-item"><a href="#badge-tab1" class="nav-link @if($tab==1) active @endif" data-toggle="tab"><i class="icon icon-calendar52"></i> <span class="badge bg-primary ml-2">calendar</span></a></li>
    <li class="nav-item"><a href="#badge-tab2" class="nav-link @if($tab==2) active @endif " data-toggle="tab"><i class="icon icon-clipboard5"></i> <span class="badge badge-danger mr-2">Booking</span> </a></li>
    <li class="nav-item"><a href="#badge-tab3" class="nav-link " data-toggle="tab"><i class="icon icon-clipboard5"></i> <span class="badge badge-danger mr-2">Storage</span> </a></li>
    <li class="nav-item"><a href="#badge-tab4" class="nav-link @if($tab==4) active @endif " data-toggle="tab"><i class="icon icon-calendar52"></i> <span class="badge badge-primary mr-2">Shuffle Calendar</span> </a></li>
    
</ul>

    <div class="tab-content">
    <div class="tab-pane fade @if($tab==1) show active @endif" id="badge-tab1">
        @include('admin.includes.celender')
    </div>

    <div class="tab-pane fade @if($tab==2) show active @endif" id="badge-tab2">
        
        @include('admin.includes.booking_list')
    </div>

    <div class="tab-pane fade" id="badge-tab3">
        @include('admin.includes.storage')
    </div>

    <div class="tab-pane fade @if($tab==4) show active @endif" id="badge-tab4">
        @include('admin.includes.shuffle_calendar')
    </div>

</div>
</div>
</div>
</div>

</div>
<!-- /badges -->

    

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#date_type').change(function() {
            $('#shuffle_form').submit();
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('.sub-status-select').change(function() {
            $('#shuffle_form').submit();
        })
    })
</script>
@endsection