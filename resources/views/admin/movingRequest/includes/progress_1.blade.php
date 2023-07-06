	<div class="progress">
	
		<div style="width:{{$booking->minutes}}%" class="progress-bar progress-bar-info " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
		
			<?php 
			
				// $hub_start_time = new DateTime($booking->primary_date . ' ' . $booking->start_time); 
				// $hub_start_time->modify("-15 minutes");
				// echo date_format($hub_start_time,"g:i A");
			?>
		
		</div>
		
		<div style="width:{{$item_load_time}}%" class="progress-bar progress-bar-danger " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			{{$booking->start_time }}
		</div>
		
		<div style="width:{{$booking->minutes + $total_time}}%" class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			<?php 
			
				// $hub_start_time = new DateTime($booking->primary_date . ' ' . $booking->start_time); 
				// $hub_start_time->modify("+{$item_load_time} minutes");
				// echo date_format($hub_start_time,"g:i A");
			?>
		</div>
		
		<div style="width:{{$item_Unload_time}}%" class="progress-bar progress-bar-danger " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			<?php 
			
				// $start_time = new DateTime($booking->primary_date . ' ' . $booking->start_time); 
				// $travel_end_time = $item_load_time + $booking->minutes;
				// $start_time->modify("+{$travel_end_time} minutes");
				// echo date_format($start_time,"g:i A");
			?>
		</div>
		
	</div>