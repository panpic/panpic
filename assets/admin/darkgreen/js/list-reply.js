$(function() {
	
	$('.text-cmt').each(function(index, el) {
		$(this).click(function(event) {
			event.preventDefault(); 
			var comments = $(this).parent().next(); 

			comments.slideToggle(500); 

			var parent = $(this).parent().parent().offset().top; 

			$('body, html').animate({scrollTop: parent - 46},400,"easeInExpo");

			return false; 
			
		});		
	});

	



})