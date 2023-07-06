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

</style>	
	
@endsection

@section('content')

<!-- Switchery and card controls -->
						<div class="card">
							<div class="card-header bg-indigo-800 header-elements-sm-inline">
								<h6 class="card-title">Peak Factor</h6>
								<div class="header-elements">
									<div class="d-flex justify-content-between">
										
										<div class="list-icons ml-3">
											<form action="{{ route('admin.PeakFactor') }}" method="post" enctype="multipart/form-data" class="w-100">
											{{ csrf_field() }}
												<button type="submit" name="btn_last" value="{{ $c_date['last_date'] }}"  class="btn btn-light btn-sm"><i class="icon-arrow-left15"></i></button>
												<button type="submit" name="btn_next" value="{{ $c_date['next_date'] }}"  class="btn btn-light btn-sm"><i class="icon-arrow-right15"></i></button>
											</form>
											
					                	</div>
				                	</div>
								</div>
							</div>
							
							<div class="card-body">
									<div class="table-responsive mt-2">
									
									<h6>{{$c_date['now_month_text']}} {{$c_date['now_year']}}</h6>
									
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
												@if($day > 0)
													<input name="peak[{{$c_date['now_month']}}][{{$day}}]" value="" class="form-control">
												@endif
												</td>
											@endforeach
											</tr>
											
										@endforeach
										</table>
									</div>
							</div>
						</div>
						<!-- /switchery and card controls -->

	
	

@endsection
