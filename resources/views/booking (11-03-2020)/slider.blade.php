
@for($i=0; $i<=10; $i++) 
	
	<div id="slider_{{$i}}" class="card card-body " @if(isset($booking_dates[$i]->booking_date)) @else style="display:none;" @endif>	
	<div class="row">
		<div class="col-md-2">
		
			<div id="m_{{$i}}" class="bg-info text-center text-white rounded-top pt-1" style="width:60px;height:20px;font-size:10px;">
			
			@if(isset($booking_dates[$i]->booking_date)) {{date('F',strtotime($booking_dates[$i]->booking_date))}} @endif
			</div>	
			<div class="border border-info text-center rounded-bottom" style="width:60px;height:40px;">
				<h4 class="pt-1" id="c{{$i}}">
				@if(isset($booking_dates[$i]->booking_date)) {{date('d',strtotime($booking_dates[$i]->booking_date))}} @endif
				</h4>
			</div>	
			
		</div>
		
		<div class="col-md-8">
			<div id="time-range">
			
				<p> Time Range: 
				<span id="start_span_time_{{$i}}">
					@if(isset($booking_dates[$i]->start_time)) {{$booking_dates[$i]->start_time}} @else 6:00 AM @endif
				</span> - 
				<span id="end_span_time_{{$i}}">
					@if(isset($booking_dates[$i]->end_time)) {{$booking_dates[$i]->end_time}} @else 6:00 AM @endif
				</span></p>
				<div class="sliders_step{{$i}}">
				
					<div id="time_{{$i}}" class="slider-range"></div>
					
					<input type="hidden" name="booking_date[{{$i}}][date]" 		 id="date_{{$i}}" 		value="@if(isset($booking_dates[$i]->booking_date)){{date('Y-m-d',strtotime($booking_dates[$i]->booking_date))}}@endif">
					<input type="hidden" name="booking_date[{{$i}}][start_time]" id="start_time_{{$i}}" value="@if(isset($booking_dates[$i]->start_time)){{$booking_dates[$i]->start_time}}@endif">
					<input type="hidden" name="booking_date[{{$i}}][end_time]" 	 id="end_time_{{$i}}" 	value="@if(isset($booking_dates[$i]->end_time)){{$booking_dates[$i]->end_time}}@endif">
					
					
				</div>
			</div>
		</div>
		
	</div>
	</div>
	
@endfor
