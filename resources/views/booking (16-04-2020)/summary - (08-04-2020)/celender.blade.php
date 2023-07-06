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

<div class="col-md-6">

@foreach ($calender as $month => $value) 
@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))

<div id="month_{{$month}}" class="card shadow rounded-lg w-100" style="@if($month == date('m')) @else display:none; @endif">

<div class="card-header bg-dark text-white ">
<div class="row">
<div class="col-2"><img src="/pricing.png" class="w-100" alt=""></div>
<div class="col pl-0"><h5 class="m-0 font-weight-normal"> Selecting your move on any of the following dates will lower your pricing</h5></div>
</div>
</div>


<div class="card-body">

	<div class="row col-md-12 pb-1">
		
			<div class="col-md-10">
				<h6 id="h{{date('m', mktime(0, 0, 0, $month, 10))}}">{{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
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
	
	<table id="{{date('m', mktime(0, 0, 0, $month, 10))}}" class="table table-bordered text-center">	
		<tr class="bg-warning text-dark">
			<th   class="text-center">MON</th>
			<th   class="text-center">TUE</th>
			<th   class="text-center">WED</th>
			<th   class="text-center">THU</th>
			<th   class="text-center">FRI</th>
			<th   class="text-center">SAT</th>
			<th   class="text-center">SUN</th>
		</tr>
		
			@foreach ($value as $k =>$week) 

			<tr>
			@foreach($week as $day) 
				@php 
					$date = $year.'-'.$month.'-'.$day[0];
					$date = date('Y-m-d',strtotime($date));
				@endphp
				<td id="td_{{$date}}" class=" @if(in_array($date,$b_date)) bg-dark text-white @endif {{$day[1]}}">
				@if($day[0] > 0)
					<button type="button" class="calendar btn btn-link @if(in_array($date,$b_date)) text-white @else text-dark @endif btn-block p-0 position-relative" data-toggle="modal" data-target="#celender">{{$day[0]}}</button>
				@endif
				</td>
				
				
				
			@endforeach
			</tr>

			@endforeach
		
	</table>
	
	
	
	<div class="row">

		<div class="col-md-4 p-2 text-center">
			<span class="badge badge-danger p-2 hvr-shadow">High Demand</span> 
		</div>
		<div class="col-md-4 p-2 text-center">
			<span class="badge badge-warning p-2 hvr-shadow">Medrate Demand</span> 
		</div>
		<div class="col-md-4 p-2 text-center" >
			<span class="badge bg-success text-white p-2 hvr-shadow">Low Demand</span> 
		</div>
			
	</div>
	</div>
</div>
@endif
@endforeach
</div>

@include('booking.summary.model_celender')	
