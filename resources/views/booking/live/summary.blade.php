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

function update_insurance(amount)
{
	$( "div[id^='insurance_type_']" ).removeClass('bg-warning');
	$( "i[id^='icon_']" ).removeClass('text-dark');
	
	$( "div[id^='amount_']" ).empty();
	$( "div[id^='amount_']" ).append('$'+amount);
	$( "input[id^='item_']" ).val(amount);
	
	//$("#insurance_type_"+amount).removeClass('bg-white');
	$("#insurance_type_"+amount).addClass('bg-warning');
	
	//$("#icon_"+amount).removeClass('text-white');
	$("#icon_"+amount).addClass('text-dark');
	
	$.ajax(
	{
		url : "/update_insurance/"+{{$booking->booking_id}}+"/"+amount,
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

function update_item_insurance(id)
{
	
	var amount = $("#item_"+id).val();
	$("#amount_"+id).empty();
	$("#amount_"+id).append('$'+amount);
	
	$.ajax(
	{
		url : "/update_item_insurance/"+{{$booking->booking_id}}+"/"+id+"/"+amount,
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
	
	function getVals()
	{
	  // Get slider values
	  var parent = this.parentNode;
	  var slides = parent.getElementsByTagName("input");
		var slide1 = parseFloat( slides[0].value );
		var slide2 = parseFloat( slides[1].value );
	  // Neither slider will clip the other, so make sure we determine which is larger
	  if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }
	  
	  var displayElement = parent.getElementsByClassName("rangeValues")[0];
		  displayElement.innerHTML = slide1 + " - " + slide2;
	}

	window.onload = function()
	{
	  // Initialize Sliders
	  var sliderSections = document.getElementsByClassName("range-slider");
		  for( var x = 0; x < sliderSections.length; x++ ){
			var sliders = sliderSections[x].getElementsByTagName("input");
			for( var y = 0; y < sliders.length; y++ ){
			  if( sliders[y].type ==="range" ){
				sliders[y].oninput = getVals;
				// Manually trigger event first time to display values
				sliders[y].oninput();
			  }
			}
		  }
	}
	
	$(".slider").slider({
		tooltip: 'always',
		range: true,
		min: 0,
		max: 12,
		step: 1,
		//values: [360, 360],
		slide: function (e, ui) 
		{
			if(ui.values[0] == 10 || ui.values[0] == 11)
			{
				console.log(ui.values[0]);	
				return false;
			}
			
			$("#time_"+e.target.id).empty();
			$("#time_"+e.target.id).append(range[ui.values[0]] +' - '+ range[ui.values[1]]);
			
			$("#start_"+e.target.id).val(range[ui.values[0]]);
			$("#end_"+e.target.id).val(range[ui.values[1]]);
			
			//console.log("id: "+e.target.id+" value1 : "+ui.values[0]+" value2 : "+ui.values[1]);
			
			//$( ".slider" ).css({'background':'linear-gradient(to right, white 50%, red 50% 75%, white 75%)'});
		}
	});

	var range = ["6:00 AM", "7:00 AM", "8:00 AM", "9:00 AM", "10:00 AM", "11:00 AM", "12:00 AM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM", "5:00 PM", "6:00 PM"];
	
	
</script>
<script src="{{asset('assets_admin/js/main/date_time.js')}}"></script> 
@endsection