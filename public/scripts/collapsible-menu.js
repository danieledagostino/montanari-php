$(document).ready(
	function() {
		$( "#messageCollapsible" ).collapsible({
		  expand: function( event, ui ) {
			  $.getJSON('/message/count?' + new Date().getTime(), 
			  	function(data){
			  		$("#messageCollapsible li[data-icon=mail] span").text(data.inbox);
			  		$("#messageCollapsible li[data-icon=phone] span").text(data.sent);
			  		$("#messageCollapsible li[data-icon=forbidden] span").text(data.deleted);
			  	});
		  }
		});
		
		$( "#eventCollapsible" ).collapsible({
		  expand: function( event, ui ) {
			  $.getJSON('/event/count?' + new Date().getTime(), 
			  	function(data){
			  		$("#eventCollapsible li.corso span").text(data.otherEvents);
			  		$("#eventCollapsible li.partecipi span").text(data.joinEvents);
			  	});
		  }
		});
		
		$( "#orgCarCollapsible" ).collapsible({
		  expand: function( event, ui ) {
			  $.getJSON('/passenger/count?' + new Date().getTime(),
			  	function(data){
			  		$("#orgCarCollapsible li.passenger span").text(data.passenger);
			  	});
			  $.getJSON('/driver/count?' + new Date().getTime(), 
			  	function(data){
			  		$("#orgCarCollapsible li.driver span").text(data.driver);
			  	});
		  }
		});
		
		$( "#notifyCollapsible" ).collapsible({
		  expand: function( event, ui ) {
			  $.getJSON('/notification/count?' + new Date().getTime(), 
			  	function(data){
			  		$("#notifyCollapsible li[data-icon=mail] span").text();
			  		$("#notifyCollapsible li[data-icon=mail] span").text();
			  		$("#notifyCollapsible li[data-icon=mail] span").text();
			  	});
		  }
		});
});