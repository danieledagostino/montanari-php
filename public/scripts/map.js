var map;
var geocoder;
var bounds;
var markersArray = [];
var origins = [];
var destinationMarker;
var destination;
var destinationIcon = '/images/parking.png';
var home;
var directionsDisplay;

function initMap() {
			
	var latlng = new google.maps.LatLng(41.8904498,12.4914645);
	var myOptions = {
		zoom: 12,
	    center: latlng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP,
	    clickableIcons: false,
	    disableDoubleClickZoom: true,
	    mapTypeControl: false,
	    streetViewControl: false
	};
	
	map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
	bounds = new google.maps.LatLngBounds();
	
	geocoder = new google.maps.Geocoder();
	
	google.maps.event.addListener(map, 'click', function(e) {
		placeMarker(e.latLng, map);
	});
}

function latLngFromString(locationToStringed){
	var input = locationToStringed.replace('(', '');
	var latlngStr = input.split(",", 2);
	var lat = parseFloat(latlngStr[0]);
	var lng = parseFloat(latlngStr[1]);
	var parsedPosition = new google.maps.LatLng(lat, lng);
	return parsedPosition;
}

function latLngFromArray(latlng){
	var lat = parseFloat(latlng['lat']);
	var lng = parseFloat(latlng['lng']);
	var parsedPosition = new google.maps.LatLng(lat, lng);
	return parsedPosition;
}