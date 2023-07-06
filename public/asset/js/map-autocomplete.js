try {
    $(".datepicker").datepicker().on('changeDate', function (ev) {
        let newDate = moment(ev.date).format('YYYY-MM-DD');
        $("#booking_date").val(newDate);
    });
	
    let sourceLat = null;
    let sourceLng = null;
    let destLat = null;
    let destLng = null;
    let source = null;
    let markers = [];
    let destination = null;
    let distance = document.getElementById('distance');
    let overAllDistance = document.getElementById('over_all_distance');
    let s_lat = document.getElementById('s_lat');
    let s_lng = document.getElementById('s_lng');
    let s_zipcode = document.getElementById('s_zipcode');
    let d_lat = document.getElementById('d_lat');
    let d_lng = document.getElementById('d_lng');
    let d_zipcode = document.getElementById('d_zipcode');
    let s_input = document.getElementById('start');
    let minutes = document.getElementById('minutes');
    let overAllMinutes = document.getElementById('over_all_minutes');
    let d_input = document.getElementById('end');
    let directionsService = new google.maps.DirectionsService;
    let autocomplete_source = new google.maps.places.Autocomplete(s_input);
    let autocomplete_destination = new google.maps.places.Autocomplete(d_input);

    let geocoder = new google.maps.Geocoder();
    autocomplete_source.addListener('place_changed', function(event) {
        let place = autocomplete_source.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        }
        sourceLat = place.geometry.location.lat();
        sourceLng = place.geometry.location.lng();
        updateSourceForm(sourceLat, sourceLng);
        updateRoute();

        geocoder.geocode({
            'latLng': new google.maps.LatLng(sourceLat, sourceLng)
        }, async function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if(results[0]){
                    for (let i=0; i<results[0].address_components.length; i++) {
                        let types = results[0].address_components[i].types;
                        for (let typeIdx = 0; typeIdx < types.length; typeIdx++) {
                            if (types[typeIdx] == 'postal_code') {
                                s_zipcode.value = results[0].address_components[i].short_name;
                            }
                        }
                    }
                }
            }
        })
    });
    autocomplete_destination.addListener('place_changed', function(event) {
        let place = autocomplete_destination.getPlace();
        destLat = place.geometry.location.lat();
        destLng = place.geometry.location.lng();
        updateDestinationForm(destLat, destLng);
        updateRoute();

        geocoder.geocode({
            'latLng': new google.maps.LatLng(destLat, destLng)
        }, async function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if(results[0]){
                    for (let i=0; i<results[0].address_components.length; i++) {
                        let types = results[0].address_components[i].types;
                        for (let typeIdx = 0; typeIdx < types.length; typeIdx++) {
                            if (types[typeIdx] == 'postal_code') {
                                d_zipcode.value = results[0].address_components[i].short_name;
                            }
                        }
                    }
                }
            }
        })
    });

    function updateSourceForm(lat, lng) {
        s_lat.value = lat;
        s_lng.value = lng;
        source = new google.maps.LatLng(lat, lng);
    }

    function updateDestinationForm(lat, lng) {
        d_lat.value = lat;
        d_lng.value = lng;
        destination = new google.maps.LatLng(lat, lng);
    }


    function updateRoute(){
        if (source == null || destination == null){
            return;
        }
        let waypts = [];

        removeMarkers();
        let originMarker = new google.maps.Marker({
            icon: '/asset/img/marker-plus.png',
            map: map,
            position: new google.maps.LatLng(s_lat.value, s_lng.value),
        });
        markers.push(originMarker);
        let destinatinMarker = new google.maps.Marker({
            icon: '/asset/img/marker-home.png',
            map,
            position: new google.maps.LatLng(d_lat.value, d_lng.value)
        })
        markers.push(destinatinMarker);
        let hubMarker = new google.maps.Marker({
            icon: '/asset/img/marker-car.png',
            map,
            position: new google.maps.LatLng("42.334900", "-71.056340")
        })
        markers.push(hubMarker);

        let allWayPoints = document.getElementsByClassName("way_points");
        for (let i = 0; i < allWayPoints.length; i++) {
            if (allWayPoints[i].value != ""){
                let address = allWayPoints[i].value.replace(" ", "+");
                geocoder.geocode({'address': address}, function(results, status) {
                    markers.push(new google.maps.Marker({
                        icon: '/asset/img/marker-user.png',
                        map,
                        position: results[0].geometry.location
                    }))
                })
                waypts.push({
                    'location': address,
                    'stopover': true
                });
                let key = "AIzaSyBIUaBvvlXdLIxkhAVVqQJC7jhSg98g7NE";
                let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${key}`;
                let http = new XMLHttpRequest();
                http.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let data = JSON.parse(this.response);
                        let locationObject = data.results[0].geometry.location;
                        let myLat = locationObject.lat;
                        let myLng = locationObject.lng;
                        document.getElementById("way_point_lat" + i).value = myLat;
                        document.getElementById("way_point_lng" + i).value = myLng;
                    }
                };
                http.open("GET", url, true);
                http.send();
            }
        }
        directionsService.route({
            origin: source,
            destination: destination,
            waypoints: waypts,
            travelMode: google.maps.TravelMode.DRIVING,
            }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                let distanceTimeArrays = result.routes[0].legs;
                let myDistance = 0;
                let time = 0;
                distanceTimeArrays.forEach(distanceTimeArray => {
                    myDistance += distanceTimeArray.distance.value / 1609.344;
                    time += parseInt(distanceTimeArray.duration.value) / 60;
                });
                myDistance = myDistance.toFixed(0).replace(/\.(\d\d)\d?$/, '.$1');
                time = Math.round(time);
                let distanceMinutes = document.getElementById("distanceMinutes");
                let distanceShow = document.getElementById("distanceShow");
                distanceMinutes.innerText = time;
                distanceShow.innerText = myDistance;
                distance.value = myDistance;
                minutes.value = time;
				
				$("#present_text").show();
				$("#distance_text").html(myDistance);
				$("#time_text").html(time);
                directionsDisplay1.setDirections(result);
                updateRouteHubToHub();
            }
        });
        function removeMarkers() {
            for (let i in markers) {
                if(typeof markers[i] !== 'undefined') markers[i].setMap(null);
            }
        }
        function updateRouteHubToHub() {
            let lat = "42.334900";
            let lng = "-71.056340";
            let customSource = {
                "location": source,
                "stopover": true
            };
            let customWaypts = waypts;
            customWaypts = insert(customWaypts, 0, customSource);
            let customDestination = {
                "location": destination,
                "stopover": true
            };
            customWaypts = insert(customWaypts, customWaypts.length, customDestination);
            customSource = new google.maps.LatLng(lat, lng);
            customDestination = new google.maps.LatLng(lat, lng);
            directionsService.route({
                origin: customSource,
                destination: customDestination,
                waypoints: customWaypts,
                travelMode: google.maps.TravelMode.DRIVING,
            }, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    let distanceTimeArrays = result.routes[0].legs;
                    let myDistance = 0;
                    let time = 0;
                    distanceTimeArrays.forEach((distanceTimeArray, index) => {
                        myDistance += distanceTimeArray.distance.value / 1609.344;
                        time += parseInt(distanceTimeArray.duration.value) / 60;
                    });
                    myDistance = myDistance.toFixed(0).replace(/\.(\d\d)\d?$/, '.$1');
                    time = Math.round(time);
                    let distanceMinutes = document.getElementById("overallDistanceMinutes");
                    let distanceShow = document.getElementById("overallDistanceShow");
                    distanceMinutes.innerText = time;
                    distanceShow.innerText = myDistance;
                    overAllDistance.value = myDistance;
                    overAllMinutes.value = time;
                    directionsDisplay2.setDirections(result);
                }
            });
        }

        const insert = (arr, index, newItem) => [
          // part of the array before the specified index
          ...arr.slice(0, index),
          // inserted item
          newItem,
          // part of the array after the specified index
          ...arr.slice(index)
        ]

    }

}catch (e) {
    console.log(e);
}
