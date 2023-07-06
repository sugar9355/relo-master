@extends('user.layout.app')

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
<script src="{{asset('assets_admin/js/demo_pages/components_collapsible.js')}}"></script>

@section('content')

  @include('booking.summary.script')
  
  @include('booking.summary.location')

	<section class="content py-3 px-md-3" id="summary">
	
	<div class="container-fluid">
		<div class="row">

			@include('booking.summary.leftSide')	

			<div class="col-md-9"> 
				<div class="row">
					<div class="col-md-6" id="div_graph">
						@include('booking.summary.graph')
					</div>
					
					
					
					@include('booking.summary.celender')
				</div>
				
				@include('booking.summary.inventory')
				
			</div>
		</div>
	</div>
           
  </section>
    
  <section class="content" id="summary">
    
	  <div class="col-md-12 text-center">
		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

			{{ csrf_field() }}

			<hr>
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal animated slideInLeft" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
				<button name="btn_submit" type="submit" value="checkout" class="btn btn-warning m-auto hvr-icon-wobble-horizontal px-5 animated slideInRight">Finish <i class="far fa-smile-wink hvr-icon"></i></button>
			
		</form>
	</div>

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