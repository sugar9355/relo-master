@extends('user.layout.app')

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstat/1.7.0/jstat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
<link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">  

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
  
  
  
    <div class="container my-5">
    <h2 class="pb-2 border-bottom mb-3">Summary</h2> 
  
	  
	  <div class="col-md-12 text-center">
		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">

			{{ csrf_field() }}

			<hr>
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/6" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal animated slideInLeft" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
				<button name="btn_submit" type="submit" value="checkout" class="btn btn-warning m-auto hvr-icon-wobble-horizontal px-5 animated slideInRight">Finish <i class="far fa-smile-wink hvr-icon"></i></button>
			</div>
		</form>
    </div>

  </section>

@endsection


<script>

function update_location()
{
	$("#btn_edit_location").hide();
	$("#btn_save_location").show();
	$("#btn_cancel_location").show();
	
	$("#loc_1").hide();
	$("#loc_2").hide();
	$("#loc_1_edit").fadeIn();
	$("#loc_2_edit").fadeIn();
}

function cancel_location()
{
	
	$("#btn_save_location").hide();
	$("#btn_cancel_location").hide();
	$("#btn_edit_location").show();
	
	$("#loc_1_edit").hide();
	$("#loc_2_edit").hide();
	$("#loc_1").fadeIn();
	$("#loc_2").fadeIn();
	
}

function update_crew(crew)
{
	$("#div_crew_1").removeClass('bg-warning');
	$("#div_crew_2").removeClass('bg-warning');
	$("#div_crew_3").removeClass('bg-warning');
	$("#div_crew_4").removeClass('bg-warning');
	
	$("#div_crew_1").removeClass('bg-light');
	$("#div_crew_2").removeClass('bg-light');
	$("#div_crew_3").removeClass('bg-light');
	$("#div_crew_4").removeClass('bg-light');
	
	$("#div_crew_"+crew).removeClass('bg-light');
	$("#div_crew_"+crew).addClass('bg-warning');
	
	
	$.ajax(
	{
		url : "/update_crew/"+{{$booking->booking_id}}+"/"+crew,
		type: "Get",
		success:function(data, textStatus, jqXHR) 
		{
			if(textStatus === 'success')
			{
				$("#div_graph").empty();
				$("#div_graph").append(data);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) 
		{
			//console.log(textStatus)
		}
	});
	
	 return false;
}

function update_insurance(id)
{
	$.ajax(
	{
		url : "/update_insurance/"+{{$booking->booking_id}}+"/"+id,
		type: "Get",
		success:function(data, textStatus, jqXHR) 
		{
			if(textStatus === 'success')
			{
				$("#accordion-insurance").empty();
				$("#accordion-insurance").append(data);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) 
		{
			//console.log(textStatus)
		}
	});
	
	 return false;
}
</script>
@section("scripts")
<script>

    let s_input = document.getElementById('start');
    let d_input = document.getElementById('end');
	
    let autocomplete_source = new google.maps.places.Autocomplete(s_input);
    let autocomplete_destination = new google.maps.places.Autocomplete(d_input);
	
    autocomplete_source.addListener('place_changed', function(event) 
	{
        let place = autocomplete_source.getPlace();
        $("#lat_1").val(place.geometry.location.lat());
        $("#lng_1").val(place.geometry.location.lng());
    });
	
    autocomplete_destination.addListener('place_changed', function(event) 
	{
        let place = autocomplete_destination.getPlace();
        $("#lat_2").val(place.geometry.location.lat());
        $("#lng_2").val(place.geometry.location.lng());
		
		getDistanceTime();
		
    });
	
	// function getDistanceTime()
	// {
		// var service = new google.maps.DistanceMatrixService();
		// service.getDistanceMatrix(
		// {
			// origins: [$("#lat_1").val(), $("#lng_1").val()],
			// destinations: [$("#lat_2").val(),  $("#lng_2").val()],
			// travelMode: 'DRIVING',
		// }, callback);

		// function callback(response, status) 
		// {
			// console.log(response);
		// }
	// }

</script>
@endsection