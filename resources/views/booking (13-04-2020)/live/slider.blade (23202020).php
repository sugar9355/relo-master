@for($i=0; $i<=10; $i++) 

	<div id="slider_{{$i}}" class="card card-body " @if(isset($booking_dates[$i]->booking_date)) @else style="display:none;" @endif>
	<div class="row">
		<div class="col-md-2">
		
			<div id="m_{{$i}}" class="bg-info text-center text-white rounded-top" style="width:60px;height:20px;">@if(isset($booking_dates[$i]->booking_date)) {{date('F',strtotime($booking_dates[$i]->booking_date))}} @endif</div>	
			<div class="border border-info text-center rounded-bottom" style="width:60px;height:40px;">
				<h4 class="pt-1" id="c{{$i}}">@if(isset($booking_dates[$i]->booking_date)) {{date('d',strtotime($booking_dates[$i]->booking_date))}} @endif</h4>
			</div>	
			
		</div>
		
		<div class="col-md-8">
			<div id="time-range">
			
				<p> Time Range: <span id="start_time{{$i}}">6:00 AM</span> - <span id="end_time{{$i}}">6:00 AM <font color="red">$$$$</font></span></p>
				<div class="sliders_step{{$i}}">
					<div name="time[]" id="time{{$i}}" class="slider-range"></div>
					<input type="hidden" name="input_slider[]" id="input_slider_{{$i}}" value="">
					
					
				</div>
			</div>
		</div>
	</div>
	</div>
@endfor
