$(document).ready(
	function() {
	$("#deleteButton").click(function(e) {
		var url = $(this).attr('url');
		$.get(url).done(function(data) {
			$("#modalMapRoad").html(data);

			$("#modalMapRoad").popup("open", {
				transition : "slideup",
				positionTo : "window"
			});
		});
	});
	
	var popUp;

	$("#openButton").click(function(e) {
		var url = $(this).attr('url');
		var messageId = $(this).attr('messageId');
		$.get(url).done(function(data) {
			$('#contextMenu').popup("close");
			$('table tbody tr').unbind('click');
			popUp = $(data).popup({
				transition : "slideup"
			});

			popUp.appendTo($('[data-role="page"]'));
			popUp.popup("open").trigger("create");
			
			$('tr[messageId='+messageId+']').css('font-weight', '')
			
			$('#detailPopupCloseBtn').click(function(e){
				popUp.popup('close');
				popUp.remove();
				$('table tbody tr').click(trTouchEvent);
			});
			
			$('#msgDeleteBtn').click(function(e){
				e.preventDefault();
				var msgId = $(this).attr('messageId');
				$.get($(this).attr('href')).done(function(data) {
					if (data.deleted == 1){
						$('table tbody tr[messageId='+msgId+']').remove();
						$('table tbody tr').click(trTouchEvent);
						popUp.popup('close');
						popUp.remove();
					}
				});
			});
		});
	});
	
	$('table tbody tr')
		.click(trTouchEvent);
	
	
});


function trTouchEvent(){
	$('#contextMenu').popup("open", {
		transition : "pop",
		positionTo : $(this)
	});
	$('#contextMenu a#openButton').attr(
			'url',
			'/message/detail/'
					+ $(this).attr('messageId'));
	
	$('#contextMenu a#openButton').attr('messageId', $(this).attr('messageId'));
	$('#contextMenu a#deleteButton').attr(
			'url',
			'/message/delete/'
					+ $(this).attr('messageId'));
	$('#contextMenu a#deleteButton').attr('messageId', $(this).attr('messageId'));
}