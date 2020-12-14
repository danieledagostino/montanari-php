$(document).on("pagecreate", function () {
		
	$('[name=ruolo]').change(function(){
		var sel = $(this).find(':selected').val();
		
		if (sel == '/driver/'){
			$("#mapRoute").show();
			$("[name='posti']").selectmenu("enable");
			$("#map_buttons").show();
			$("#meetingPoint").hide();
		}else{
			$("#mapRoute").hide();
			$("[name='posti']").selectmenu("disable");
			$("#map_buttons").hide();
			$("#meetingPoint").show();
		}
    });
	
	$("#mapRoute").hide();
	$("[name='posti']").selectmenu("disable");
	$("#map_buttons").hide();
	$("#meetingPoint").hide();
	
	//$("input[name=abitazione]").characterCounter(30);
    //$("input[name=puntoIncontro]").characterCounter(30);
    //$("input[name=email]").characterCounter(30);
});