var map;
var zoomLevel = 20;

 function initMaps() {
        var locationRio = {lat: -22.915, lng: -43.197};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 18,
          center: locationRio,
          gestureHandling: 'cooperative'
        });
        var marker = new google.maps.Marker({
          position: locationRio,
          map: map,
          title: 'Hello World!'
        });
      }

function initMap() 
{
	map = new google.maps.Map(document.getElementById('map'));

	let marker = new google.maps.Marker({
		zoom: 23,
		map: map,
		
		title: 'Hello World!',
		anchorPoint: new google.maps.Point(0, -29)
	});

	let markerSecond = new google.maps.Marker({
		zoom: 23,
		map: map,
		
		title: 'END World!',
		anchorPoint: new google.maps.Point(0, -29)
	});

	let bounds = new google.maps.LatLngBounds();
	let waypts = [];

	waypts.push({
		'location': "Jinnah International Airport, Airport Road, Karachi, Pakistan",
		'stopover': true
	});
	
	waypts.push({
		'location': "PAF Base Faisal, Shahrah-e-Faisal Road, Karachi, Pakistan",
		'stopover': true
	});

	source = new google.maps.LatLng(s_lat, s_lng);
	destination = new google.maps.LatLng(d_lat, d_lng);

	marker.setPosition(source);
	markerSecond.setPosition(destination);

	let directionsService = new google.maps.DirectionsService;
	let directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
	directionsDisplay.setMap(map);

	directionsService.route({
		origin: source,
		destination: destination,
		waypoints: waypts,
		travelMode: google.maps.TravelMode.DRIVING
	}, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});

	bounds.extend(marker.getPosition());
	bounds.extend(markerSecond.getPosition());

	map.fitBounds(bounds);
}

