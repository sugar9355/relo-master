
	<div class="progress">
		<div style="width:{{$booking->minutes}}%" class="progress-bar progress-bar-info " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			{{$booking->start_time }}
		</div>
		
		<div style="width:{{$item_load_time}}%" class="progress-bar progress-bar-danger " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			<?php 
			
				$load_end_time = new DateTime($booking->primary_date . ' ' . $booking->start_time); 
				$load_end_time->modify("+{$item_load_time} minutes");
				echo date_format($load_end_time,"g:i A");
			?>
		</div>
		
		<div style="width:{{$booking->minutes + $total_time}}%" class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			
			<?php 
			
				$start_time = new DateTime($booking->primary_date . ' ' . $booking->start_time); 
				$travel_end_time = $item_load_time + $booking->minutes;
				$start_time->modify("+{$travel_end_time} minutes");
				echo date_format($start_time,"g:i A");
			?>
			
		</div>
		
		<div style="width:{{$item_Unload_time}}%" class="progress-bar progress-bar-danger " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
			<?php 
			
				$end_time = new DateTime($booking->primary_date . ' ' . $booking->start_time); 
				$job_end_time = $item_load_time + $item_Unload_time + $booking->minutes;
				$end_time->modify("+{$job_end_time} minutes");
				echo date_format($end_time,"g:i A");
			?>
		</div>
		
	</div>