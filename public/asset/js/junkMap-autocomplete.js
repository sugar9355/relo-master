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
    let s_lat = document.getElementById('s_lat');
    let s_lng = document.getElementById('s_lng');
    let d_lat = document.getElementById('d_lat');
    let d_lng = document.getElementById('d_lng');
    let s_input = document.getElementById('start');
    let minutes = document.getElementById('minutes');
    let d_input = document.getElementById('end');
    let directionsService = new google.maps.DirectionsService;
    let autocomplete_source = new google.maps.places.Autocomplete(s_input);
    let autocomplete_destination = new google.maps.places.Autocomplete(d_input);
    autocomplete_source.addListener('place_changed', function(event) {
        let place = autocomplete_source.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        }
        sourceLat = place.geometry.location.lat();
        sourceLng = place.geometry.location.lng();
        updateSourceForm(sourceLat, sourceLng);
        updateRoute();
    });
    autocomplete_destination.addListener('place_changed', function(event) {
        let place = autocomplete_destination.getPlace();
        destLat = place.geometry.location.lat();
        destLng = place.geometry.location.lng();
        updateDestinationForm(destLat, destLng);
        updateRoute();
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

    /*function updateRoute(){
        if (source == null){
            return;
        }
        let waypts = [];

        removeMarkers();
        let marker = new google.maps.Marker({
            icon: '/asset/img/marker-end.png',
            map: map,
            position: new google.maps.LatLng(s_lat.value, s_lng.value)
        });
        markers.push(marker);
        console.log(s_lat);
        console.log(s_lng);
        let customSource = source;
        let allWayPoints = document.getElementsByClassName("way_points");
        for (let i = 0; i < allWayPoints.length; i++) {
            console.log("comming");
            if (allWayPoints[i].value != ""){
                let address = allWayPoints[i].value.replace(" ", "+");
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
                        console.log(myLat);
                        console.log(myLng);
                        document.getElementById("way_point_lat"+i).value = myLat;
                        document.getElementById("way_point_lng"+i).value = myLng;
                        d_lat.value = myLat;
                        d_lng.value = myLng;
                        destination = new google.maps.LatLng(myLat, myLng);
                        let marker = new google.maps.Marker({
                            icon: '/asset/img/marker-end.png',
                            map: map,
                            position: new google.maps.LatLng(myLat, myLng)
                        });
                        markers.push(marker);
                        directionsService.route({
                            origin: customSource,
                            destination: destination,
                            travelMode: google.maps.TravelMode.DRIVING,
                        }, function(result, status) {
                            if (status == google.maps.DirectionsStatus.OK) {
                                let formerDistanceVal = 0;
                                let formerDistanceMin = 0;
                                let distanceMinutes = document.getElementById("distanceMinutes");
                                if (i != 0){
                                    formerDistanceVal = parseFloat(distance.value);
                                    formerDistanceMin = parseInt(distanceMinutes.innerHTML);
                                }
                                let distanceShow = document.getElementById("distanceShow");
                                let durationVal = parseInt(result.routes[0].legs[0].duration.value) / 60;
                                distanceMinutes.innerHTML = formerDistanceMin + Math.round(durationVal);
                                minutes.value = distanceMinutes.innerText;
                                let newDistanceVal = formerDistanceVal + result.routes[0].legs[0].distance.value / 1609.344; //1609.344
                                newDistanceVal = newDistanceVal.toFixed(0).replace(/\.(\d\d)\d?$/, '.$1');
                                distance.value = newDistanceVal;
                                distanceShow.innerHTML = distance.value;
                            }
                        });
                        customSource = new google.maps.LatLng(myLat, myLng);
                    }
                };
                http.open("GET", url, true);
                http.send();
            }
        }
        waypts.pop();
        console.log(source);
        updateDestinationForm(d_lat.value, d_lng.value);
        console.log(destination);
        source = new google.maps.LatLng(s_lat.value, s_lng.value);
        directionsService.route({
            origin: source,
            destination: destination,
            waypoints: waypts,
            travelMode: google.maps.TravelMode.DRIVING,
        }, function(result, status) {
            console.log(result);
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
            }
        });
        function removeMarkers() {
            for (let i in markers) {
                if(typeof markers[i] !== 'undefined') markers[i].setMap(null);
            }
        }

    }*/

    function updateRoute(){
        if (source == null){
            return;
        }

        let waypts = [];

        const insert = (arr, index, newItem) => [
            // part of the array before the specified index
            ...arr.slice(0, index),
            // inserted item
            newItem,
            // part of the array after the specified index
            ...arr.slice(index)
        ];

        removeMarkers();

        updateRouteHubToHub();

        function removeMarkers() {
            for (let i in markers) {
                if(typeof markers[i] !== 'undefined') markers[i].setMap(null);
            }
        }

        function updateRouteHubToHub() {
            let allWayPoints = document.getElementsByClassName("way_points");
            for (let i = 0; i < allWayPoints.length; i++) {
                if (allWayPoints[i].value != ""){
                    let address = allWayPoints[i].value.replace(" ", "+");
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
            let lat = "42.334900";
            let lng = "-71.056340";
            let customSource = {
                "location": source,
                "stopover": true
            };
            let customWaypts = waypts;
            customWaypts = insert(customWaypts, 0, customSource);
            customSource = new google.maps.LatLng(lat, lng);
            let customDestination = new google.maps.LatLng(lat, lng);
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
                    let distanceMinutes = document.getElementById("distanceMinutes");
                    let distanceShow = document.getElementById("distanceShow");
                    distanceMinutes.innerText = time;
                    distanceShow.innerText = myDistance;
                    distance.value = myDistance;
                    minutes.value = time;
                    directionsDisplay.setDirections(result);
                }
            });
        }

    }

}catch (e) {
    console.log(e);
}
