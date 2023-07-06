@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')

	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}"> 
	
	
	<!-- Core JS files -->
	<script src="{{asset('celender/main/jquery.min.js')}}"></script>
	<script src="{{asset('celender/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('celender/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- 
		Theme JS files 
	-->
	<script src="{{asset('celender/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('celender/ui/fullcalendar/fullcalendar.min.js')}}"></script>

	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('celender/demo_pages/fullcalendar_styling.js')}}"></script>

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
	font-size:10px;
	margin-bottom: 2px;
	text-align: left;
	padding: 0px 2px 0px 2px;
}

.today
{
    background-color: #5cb85c;
    padding: 2px 10px 2px 10px;
    color: white;
    font-size: 12px;
    margin-left: 10px;
}

</style>	
	
@endsection

@section('content')


<!-- Content area -->
	
	<div class="card">
		<div class="card-body">
		
			<div >@include('admin.dashboard.count')</div>
			<div class="panel-group">
					@php $arr = array(-1,0,1); @endphp
					
					@foreach ($arr as $state) 
					@php 
						$month = intval(date('m', strtotime("$state months"))); 
						$month_text = date('F', strtotime("$state months")); 
					@endphp
					<div id="{{$month}}" class="panel panel-default">
						<div class="panel-heading bg-success">
							<div style="float:left;">Celender</div>
							<div style="float:right;">{{date("Y")}}</div>
							<div style="clear:both;"></div>
						</div>
						<div class="panel-heading">
							<div style="float:left;"><h5><strong>{{$month_text}} ({{date("Y")}})</strong></h5></div>
							<div style="float:right;">
							<button type="button"  onclick="last({{$month}})" class="btn btn-success btn-sm"><</button>
							<button type="button"  onclick="next({{$month}})" class="btn btn-success btn-sm">></button>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="panel-body">
						
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
						
						@foreach ($calender[$month] as $k =>$week) 
							
							<tr>
							@foreach($week as $day) 
								<td width="14%" height="80px">{{ ($day ? $day : '&nbsp;') }} 
								@if($month == intval(date("m")) && $day == date("d")) <span class="today"><i>Today</i></span>@endif
								<br>
								@foreach($jobs as $job) 
								@if($month == $job->month)
									
									@if(isset($job->day) && $job->day == $day && $month == $job->month)
									
										@if($day > date("d")) 
											@php $btn_color = 'btn-primary'; @endphp
										@else	
											@php $btn_color = 'btn-success'; @endphp
										@endif
										
										@if($job->step > 0) 
											@php $btn_color = 'btn-default'; @endphp
										@endif
										<a type="button" @if($job->step == 0)  href="/admin/user_request/{{$job->booking_id}}" @endif class="btn {{$btn_color}} btn-sm col-md-12 c_btn">{{$job->start_time}} - ({{$job->first_name}} {{$job->last_name}})
										
										@if($job->truck_id == '')
											<span class="alert text-white bg-danger p-0 ml-1">T</span>
										@endif
										</a>	
									@endif
									
								@endif	
								@endforeach
								</td>
							@endforeach
							</tr>
							
						@endforeach
						</table>
						</div>
					</div>
					@endforeach
						
			  
		  </div>
		
	</div>
</div>	
		

@endsection

<script>
function next(month)
{
	month = month + 1;
	console.log(month);
	//$("#month_"+month).show();
}

function last(month)
{
	month = month - 1;
	console.log(month);
	//$("#month_"+month).show();
}
</script>
