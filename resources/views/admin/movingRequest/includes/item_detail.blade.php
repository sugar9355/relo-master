<div class="form-group">
<div class="col-md-12">   

<table class="table table-striped table-bordered dataTable">
<thead>
	<tr>
		<th>Items No</th>
		<th>Name</th>
		<th>width * height * breadth = volume</th>
		<th>Flight </th>
		<th>Flight Types</th>
		<th>Averege Flight Time</th>
		<th>Disassemble Difficulty level</th>
		<th align="center">Total Time</th>
		
	</tr>
</thead>
<tbody>



@foreach($items as $k => $item)

	@foreach($inventory as $inventory)
	
	@if($inventory->id == $item->item_id)
	
	<tr>
	<td>{{$k+1}}</td>
		<td><p class="form-control-static"> {{ $inventory->name }} </p></td>
		<td><p class="form-control-static">  {{ $inventory->width }} * {{  $inventory->height }} * {{  $inventory->breadth }}  = {{  $inventory->volume }} <strong>cm3</strong></p></td>
		<td>	
			@foreach($location as $loc)
						{{  $loc->flights }} <hr class="m-0"> 
			@endforeach
		</td>
		<td>
			@foreach($location as $loc)
				@if($loc->user_moving_request_id == $item->user_moving_request_id)
					
					@if(strtolower($loc->stair_type) == 'windy') 
						
						@if($inventory->stair_windy != null && $inventory->stair_windy != '' && $inventory->stair_windy > 0)
							<strong>W : +{{$inventory->stair_windy}} mins</strong> <br>
							
						@endif
					@endif
					
					@if(strtolower($loc->stair_type) == 'narrow') 
						@if($inventory->stair_narrow != null && $inventory->stair_narrow != '' && $inventory->stair_narrow > 0)
							  <strong>N : +{{$inventory->stair_narrow}} mins</strong> <br>
							
						@endif
					@endif
				@endif
			@endforeach
		</td>
		<td>
			@foreach($location as $loc)
					@if($loc->user_moving_request_id == $item->user_moving_request_id)
							@php
						
								$flight = explode('to',$loc->flight)[1]; 
								$min = 'time_'.$flight.'_min';
								$med = "time_".$flight."_med";
								$max = "time_".$flight."_max";
								
								$min = str_replace(' ', '', $min);
								$med = str_replace(' ', '', $med);
								$max = str_replace(' ', '', $max);
								
							@endphp
							
							( {{$inventory->$min}} + {{$inventory->$med}} + {{$inventory->$max}} ) / 3 = <strong> {{ round(($inventory->$min + $inventory->$med + $inventory->$max ) / 3) }}</strong> mins  <hr class="m-0">
							
					@endif
				@endforeach
		</td>
		<td>
			@foreach($ranking as $rank)
				
						@if($rank->ranking_id == $item->ranking_id)
							
							@php $prop = 'R_'.$rank->alphabet @endphp
					
							Pick: {{$inventory->$prop}} mins
							<br>
							Drop: {{$inventory->$prop}} mins
						
						@endif
						
				@endforeach
		</td>
		<td align="center">
			{{$item->total_row_time}} mins
		</td>
		
	</tr>
		@endif
	<!--/span-->
	@endforeach	
@endforeach

<tr>
<td colspan="7" align="right"><strong>Distance time :{{$request->minutes}} mins + </strong></td>
<td align="center"><strong>{{$total_time}} mins</strong></td>
</tr>

<tr>
<td colspan="7" align="right"><strong>Total Time</strong></td>
<td align="center"><strong>{{$request->minutes + $total_time}} mins</strong></td>
</tr>

</tbody>

</table>

</div>
</div>