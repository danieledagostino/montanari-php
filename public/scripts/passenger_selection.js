var usersPoint = [];

$(document).on("pagecreate", function () {
	
	$("form input[type='checkbox']").bind( "change", function(event, ui) {
	  	var associato = $(this).is('[confermato]');
	  	var infoPopup = $("#infoBlankPopup");
	  	
	  	if (associato){
			$(this).prop('checked',true);
	  		infoPopup.html("Non puoi rimuovere un passeggero confermato. Prova a contattarlo e metterti d'accordo diversamente.");
			infoPopup.popup("open");
	  	}else{
		  	var numSelezionati = $("form input[type=checkbox]:checked").length;
			
			if (numSelezionati > posti){
				$(this).prop('checked', false);
				infoPopup.html("Hai selezionato troppi passeggeri. Togline almeno uno prima.");
				infoPopup.popup("open");
			}else{
				latLngStr = $(this).attr('latlng');
				
				if (this.checked) {
					latLng = latLngFromString(latLngStr);
			    	marker = placeMarker(latLng, map, 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png');
			    	usersPoint[latLngStr] = marker;
			    } else {
			    	marker = usersPoint[latLngStr];
			    	marker.setMap(null);
			    	usersPoint[latLngStr] = null;
			    }
			}
		}
	});
});