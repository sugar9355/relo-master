@php $year = date('y'); $b_date = array();  @endphp
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

<div class="col-md-6 mt-3">

@foreach ($calender as $month => $value) 
@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))

<div id="month_{{$month}}" class="card hvr-shadow w-100 card-body  text-muted" style="@if($month == date('m')) @else display:none; @endif">

<h5 class="m-0"><a href="#" class=" text-dark btn btn-link float-right">Price Low to High</a></h5>
	
		<div class="row col-md-12 pb-1">
		
			<div class="col-md-10">
				<h6 id="h{{date('m', mktime(0, 0, 0, $month, 10))}}"><i class="far fa-calendar-alt mr-2"></i> {{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
			</div>
			
			<div class="col-md-1">
			@if($month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
				<button type="button" onclick="show_month('<','{{$month}}');" class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-left hvr-icon"></i></button>
			@endif	
			</div>	
			<div class="col-md-1">
			@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1))
				<button type="button" onclick="show_month('>','{{$month}}');" class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-right hvr-icon"></i></button>
			@endif
			</div>
		
	</div>
	
<table class="table table-bordered w-100 mt-3">
<thead>
  <tr class="bg-light text-dark text-center">
	<th width="14%">MON</th>
	<th width="14%">TUE</th>
	<th width="14%">WED</th>
	<th width="14%">THU</th>
	<th width="14%">FRI</th>
	<th width="14%">SAT</th>
	<th width="14%">SUN</th>
  </tr>
</thead>
<tbody class="text-center">
@foreach ($value as $k =>$week) 

<tr>
@foreach($week as $day) 
	@php 
		$date = $year.'-'.$month.'-'.$day[0];
		$date = date('Y-m-d',strtotime($date));
	@endphp
	<td id="td_{{$date}}" onclick="update_date('{{$date}}')"class="cursor @if(in_array($date,$b_date)) bg-secondary text-white @else {{$day[1]}} @endif ">
	@if($day[0] > 0)
		{{$day[0]}}
	@endif
	</td>
	
	
	
@endforeach
</tr>

@endforeach
</tbody>
</table>

<div class="row mt-1">

<div class="col-md-4 p-2 text-center">
  <span class="badge badge-danger p-2 hvr-shadow">High Demand</span> 
</div>
<div class="col-md-4 p-2 text-center">
  <span class="badge badge-warning p-2 hvr-shadow">Medrate Demand</span> 
</div>
<div class="col-md-4 p-2 text-center">
  <span class="badge bg-success text-white p-2 hvr-shadow">Low Demand</span> 
</div>
  
</div>

<p class="mt-3  font-weight-bold"><span class="badge bg-warning p-2 mr-2"> </span> Limited Availablity</p>
</div>

@endif
@endforeach

</div>