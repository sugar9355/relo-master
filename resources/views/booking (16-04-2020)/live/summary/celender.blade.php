
@php
	$year = date('y');
	$b_date = array(); 
@endphp
@if(isset($booking_dates[0]))

	@foreach($booking_dates as $dates)
		@php $b_date[] = date('Y-m-d',strtotime($dates->booking_date)); @endphp
	@endforeach
	
@endif

@if(isset($booking->primary_date))
	@php 	
		$p_date = 	explode('-',$booking->primary_date);
		$p_date = Intval($p_date[1]).'-'.Intval($p_date[2]);
	@endphp 
@else
	@php	
		$p_date = ''; 
	@endphp 
@endif

@if(isset($booking->secondary_date))
	@php 	
		$s_date = explode('-',$booking->secondary_date);
		$s_date = Intval($s_date[1]).'-'.Intval($s_date[2]);
	@endphp 
@else
	@php	
		$s_date = ''; 
	@endphp 
@endif
@php 
	$month = Intval(date('m'));
@endphp
<div class="col-md-6">
<div class="card">
<div class="card-header bg-dark text-white">
<div class="row">
<div class="col-2"><img src="/pricing.png" class="w-100" alt=""></div>
<div class="col pl-0"><h5 class="m-0 font-weight-normal"> Selecting your move on any of the following dates will lower your pricing</h5></div>
</div>
</div>
<div class="card-body">
<h5 class="m-0 w-100 d-block">Feburary <a href="#" class="btn btn-dark btn-sm float-right"><i class="fa fa-angle-right"></i></a></h5>
<table class="table table-bordered w-100 mt-3">
<thead>
  <tr class="bg-warning text-white">
	<th>MON</th>
	<th>TUE</th>
	<th>WED</th>
	<th>THU</th>
	<th>FRI</th>
	<th>SAT</th>
	<th>SUN</th>
  </tr>
</thead>
<tbody class="text-center">
@foreach ($calender[$month] as $k =>$week) 

<tr>
@foreach($week as $day) 
	@php 
		$date = $year.'-'.$month.'-'.$day[0];
		$date = date('Y-m-d',strtotime($date));
	@endphp
	<td id="td_{{$date}}" 
		onclick="select_date('{{$date}}');" 
		class=" @if(in_array($date,$b_date)) bg-dark text-white @endif">
			<div class="{{$day[1]}}">
			@if($day[0] > 0)
				@if(in_array($date,$b_date)) 
					
					<button type="button" class="btn btn-link text-white btn-block p-0 position-relative" data-toggle="modal" data-target="#open_{{$day[0]}}">{{$day[0]}}</button>

						<!-- Modal -->
						<div id="open_{{$day[0]}}" class="modal fade" role="dialog">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
							  <h5 class="modal-title" id="staticBackdropLabel">Confirm Date & Time</h5>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							  </button>
							</div>
							<div class="modal-body text-center text-dark">

							  <div class="card w-25 text-center m-auto mb-4 shadow">
								<div class="card-header bg-warning p-2">
								  <h6 class="m-0">{{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
								</div>
								<div class="card-body">
								  <h2>{{$day[0]}}</h2>
								</div>
							  </div>

							  <h5 class="mt-4"><span class="bg-success px-3 py-0 rounded d-inline smaller mr-3"></span> Full Day Availablity</h5>

							  
							  <div class="form-group mt-5">
							  <label class="font-weight-bold" for="customRange3">
							  <p> Time Range: 
								<span id="start_span_time_{{$k}}">
									@if(isset($booking_dates[$k]->start_time)) {{$booking_dates[$k]->start_time}} @else 6:00 AM @endif
								</span> - 
								<span id="end_span_time_{{$k}}">
									@if(isset($booking_dates[$k]->end_time)) {{$booking_dates[$k]->end_time}} @else 6:00 AM @endif
								</span></p>
							  </label>
								<input type="range" class="custom-range" min="0" max="5" step="0.5" id="customRange3">
							  </div>

							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
							  <button type="button" class="btn btn-dark">Save</button>
							</div>
							</div>
							</div>
						</div>
					
				@else
					{{$day[0]}}
				@endif	
			@endif
			</div>
			
	</td>
@endforeach
</tr>
@endforeach

</tbody>
</table>

</div>
</div>
</div>