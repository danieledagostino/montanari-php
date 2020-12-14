function checkMessages(){
	$.getJSON('/ajax/messages?' + new Date().getTime(), function(data){
		if (data == 0){
			$('#bubble_message').hide();
		}else{
			$('#bubble_message').show();
			$('#bubble_message').text(data);
		}
	})
	.fail(function(){ console.log('/ajax/messages fallito')});
}

function checkNotifications(){
	$.getJSON('/ajax/notifications?' + new Date().getTime(), function(data){
		if (data == 0){
			$('#bubble_notification').hide();
		}else{
			$('#bubble_notification').show();
			$('#bubble_notification').text(data);
		}
	})
	.fail(function(){ console.log('/ajax/notifications fallito')});
}


$(document).ready(function(){
	
	checkMessages();
	
	checkNotifications();
	
	setInterval(checkMessages, 5 * 60 * 1000);
	
	setInterval(checkNotifications, 5 * 60 * 1000);
	
});