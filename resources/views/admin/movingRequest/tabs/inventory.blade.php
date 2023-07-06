<div class="form-group">
<div class="col-md-12">   

<table class="table table-striped table-bordered dataTable">
<thead>
	<tr>
		<th>Items No</th>
		<th>Name</th>
		<th class="text-center">Volume</th>
		<th class="text-center">Equipment</th>
		<th>Flight </th>
		<th>Flight Types</th>
		<th>Averege Flight Time</th>
		<th>Difficulty level</th>
		<th class="text-center">Total Time</th>
		
	</tr>
</thead>
<tbody>

@foreach($items as $k => $item)

	<tr>
	<td>{{$k+1}}</td>
		<td><p class="form-control-static"> {{ $item->item_name }} </p></td>
		<td class="text-center">
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#vol_{{ $item->id }}">{{  $item->volume }} cm3</button>
			@include('admin.movingRequest.tabs.volume')
		</td> 
		<td class="text-center">
			<?php $equip = explode(',',$item->equipments); ?>
			@foreach($equipments as $k => $e)
				@if(in_array($e->id,$equip))
					
					{{$k+1}}) {{$e->name}}<br>
					
				@endif
			@endforeach
			
		</td> 
		<td>	
			@foreach($location as $loc)
						{{  $loc->flights }} <hr class="m-0"> 
			@endforeach
		</td>
		<td>
			@foreach($location as $loc)
				@if($loc->booking_id == $item->booking_id)
					
					@if(strtolower($loc->stair_type) == 'windy') 
						
						@if($item->stair_windy != null && $item->stair_windy != '' && $item->stair_windy > 0)
							<strong>W : +{{$item->stair_windy}} mins</strong> <br>
							
						@endif
					@endif
					
					@if(strtolower($loc->stair_type) == 'narrow') 
						@if($item->stair_narrow != null && $item->stair_narrow != '' && $item->stair_narrow > 0)
							  <strong>N : +{{$item->stair_narrow}} mins</strong> <br>
							
						@endif
					@endif
				@endif
			@endforeach
		</td>
		<td>
			@foreach($location as $loc)
				@if($loc->booking_id == $item->booking_id)
					@php
				
						$min = 'time_'.$loc->flights.'_min';
						$med = "time_".$loc->flights."_med";
						$max = "time_".$loc->flights."_max";
						
						$min = str_replace(' ', '', $min);
						$med = str_replace(' ', '', $med);
						$max = str_replace(' ', '', $max);
						
					@endphp
					
					( {{$item->$min}} + {{$item->$med}} + {{$item->$max}} ) / 3 = <strong> {{ round(($item->$min + $item->$med + $item->$max ) / 3) }}</strong> mins  <hr class="m-0">
						
				@endif
			@endforeach
		</td>
		
		<td>
		
				@php  
					$rank = $ranking; 
					foreach($rank as $r_k=>$r_v){$ranking[$r_v->ranking_id] = $r_v;}
				@endphp
				
				
				@foreach($location as $loc) 
				
					@if($ranking[$item->ranking]->alphabet == "A")
					
						Pick: {{$item->R_A}} mins
						<br>
						Drop: {{$item->R_A}} mins<br>
					
					@elseif($ranking[$item->ranking]->alphabet == "B")
					
						Pick: {{$item->R_B}} mins
						<br>
						Drop: {{$item->R_B}} mins<br>
					
					@elseif($ranking[$item->ranking]->alphabet == "C")
					
						Pick: {{$item->R_C}} mins
						<br>
						Drop: {{$item->R_C}} mins<br>
					
					@elseif($ranking[$item->ranking]->alphabet == "D")
					
						Pick: {{$item->R_D}} mins
						<br>
						Drop: {{$item->R_D}} mins<br>
						
					
					@elseif($ranking[$item->ranking]->alphabet == "E")
					
						Pick: {{$item->R_E}} mins
						<br>
						Drop: {{$item->R_E}} mins
						<br>
					@endif
				@endforeach
			
		</td>
		
		<td align="center">
			@if(isset($item->total_row_time)) {{$item->total_row_time}} @endif mins
		</td>
		
	</tr>
	
@endforeach

<tr>
<td colspan="8" align="right"><strong>Distance time :{{$booking->minutes}} mins + </strong></td>
<td align="center"><strong>{{$total_time}} mins</strong></td>
</tr>

<tr>
<td colspan="8" align="right"><strong>Total Time</strong></td>
<td align="center"><strong>{{$booking->minutes}} + {{$total_time}} mins</strong></td>
</tr>

</tbody>

</table>

</div>
</div>