@extends('user.layout.app')

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
<style>.cursor{ cursor: pointer;}</style>

@section('content')

	@include('booking.summary.style.summary')
	@include('booking.summary.style.slider')

	<section class="content" id="summary">

	@include('booking.summary.location')

	<div class="container-fluid">

		@include('booking.summary.crew')

		<div class="row">

			@include('booking.summary.calendar')

			<div id="pricing_date_time" class="col-md-6 mt-3">
			
				@include('booking.summary.pricing_date_time')
			
			</div>
			
			<div class="col-md-12">
			
				@include('booking.summary.inventory')
				
			</div>
		
		</div>

	</div>
	
	@include('booking.summary.modal.modal_time')

	</section>

@endsection

@section("scripts")
<script> 
	var working_hours = @json($working_hours);
	var booking_id = {{$booking->booking_id}};
</script> 

<script src="{{asset('assets_admin/js/main/date_time.js')}}"></script> 
<script src="{{asset('assets_admin/js/main/summary.js')}}"></script> 
@endsection