/*
 destination = new google.maps.LatLng(41.9435004,12.6274643);
 destinationMarker = new google.maps.Marker({
 position: destination,
 map: map,
 title: 'Punto di raccolta macchine e partenza',
 icon: destinationIcon
 });
 */

function calculateDistances() {
	if (origins.length > 0){
		var service = new google.maps.DirectionsService;
		var wp = [];
		wp.push({
			location : home,
			stopover : false
		});
		for (var i = 0; i < origins.length; i++) {
			wp.push({
				location : origins[i],
				stopover : false
			});
		}
		wp.push({
			location : destination,
			stopover : false
		});
	
		service.route({
			origin : home,
			destination : destination,
			waypoints : wp,
			optimizeWaypoints : true,
			travelMode : 'DRIVING'
		}, callback);
	}else{
		$("#popupBasic").popup("open");
	}
}

function callback(response, status) {
	if (status == "ZERO_RESULTS"){
		console.log(response);
	}
	
	directionsDisplay = new google.maps.DirectionsRenderer;
	directionsDisplay.setDirections(response);
	directionsDisplay.setMap(map);

	google.maps.event.clearListeners(map, 'click');
}

function getStreetName(latlng) {
	var address = 'Indirizzo: ';
	geocoder.geocode({
		'location' : latlng
	}, function(results, status) {
		if (status === 'OK') {
			if (results[0]) {
				address = results[0].formatted_address;
			}
		}
	});
	return address;
}

function clearMarkers() {
	if (origins.length > 0){
		for (var i = 2; i < markersArray.length; i++) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
		
		if (directionsDisplay != null){
			directionsDisplay.setMap(null);
		}
		
		for (var i = 0; i < origins.length; i++) {
			origins[i] = null;
		}
		origins.length = 0;
		
		google.maps.event.addListener(map, 'click', function(e) {
			placeMarker(e.latLng, map);
		});
	}else{
		$("#popupBasic").popup("open");
	}
}
