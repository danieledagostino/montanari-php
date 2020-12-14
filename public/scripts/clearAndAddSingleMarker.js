function placeMarker(position, map) {
	if (markersArray[0] != null){
		markersArray[0].setMap(null);
		origins[0] = null;
		markersArray.length = 0;
	}
	
	origins[0] = position;
	var marker = new google.maps.Marker({
		position : position,
		map : map,
		title : 'Casa mia'
	});
	markersArray[0] = marker;
	
}