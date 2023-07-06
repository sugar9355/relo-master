    <style type="text/css">
        #map {
            height: 450px;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <div >
			<div class="row">
					<div class="col-md-12">
						<div id="map"></div>
					</div>
			</div>
			</div>
		</div>
	</div>

<div class="form-group">
<div class="col-md-12">   

@foreach($location as $key => $loc)
<table class="table table-striped table-bordered">
<thead>
	<tr>
		<th colspan="2" class="bg-primary"> Location: {{ $loc->location }}</th>
	</tr>
</thead>
<tbody>


	
 
</tbody>
</table>	
@endforeach



</div>
</div>

<!-- ---------------------------------------------------------------->
<!-- ---------------------------------------------------------------->


<script type="text/javascript">

	var s_lat = {{ $booking->s_lat }};
	var s_lng = {{ $booking->s_lng }};

	var d_lat = {{ $booking->d_lat }};
	var d_lng = {{ $booking->d_lng }};

</script>

<script src="{{asset('asset/js/location.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places&callback=initMap" async defer></script>

	
