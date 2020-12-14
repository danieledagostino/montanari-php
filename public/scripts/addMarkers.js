function placeMarkerOutOrigins(position, map, icon) {
	var marker = new google.maps.Marker({
		position : position,
		map : map,
		title : getStreetName(position)
	});
	
	if (icon){
		marker.setIcon(icon);
	}
	
	markersArray.push(marker);
}

function placeMarker(position, map, icon) {
	origins.push(position);
	var marker = new google.maps.Marker({
		position : position,
		map : map,
		title : getStreetName(position)
	});
	
	if (icon){
		marker.setIcon(icon);
	}
	
	markersArray.push(marker);
	
	return marker;
}