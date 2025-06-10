

	
	var colorList = ['CC3333', 'ff9933', '99cc33', '3366ff', '66ccff', 'ffff66', '999999', 'ff99cc','cc66ff', '993300', 'ffffff', '000000'];

	
		
	
	imageId.map(function(image_id){ //foreach 
		var picker = $('#color-picker-'+image_id);
		var color = $('.call-picker-'+image_id).val();
		
		if(color){
			$('.color-holder-'+image_id).css('background-color', color); 
		}
		
		$('#btn-'+image_id).click(function(){
			var data = 'image_id=' + image_id; 
			$.post(url,data);
			$('#single-image-'+image_id).fadeOut(1000); 
			return false; 
			
		});

		
		
		
	
		for(var i=0; i< colorList.length; i++)
		{
			picker.append('<li class="color-item" data-hex="'+
			'#' + colorList[i] + '" style="background-color:' +
			'#' + colorList[i] + ';"></li>');
		}
		// khi click vao bang mau, no se tu mat
		$('body').click(function(){
			picker.fadeOut();
		});
	 
		// click de xuat hien bang mau
		
		$('.call-picker-'+image_id).click(function(event){
			
			event.stopPropagation();
			picker.fadeIn();
			picker.children('li').hover(function(){
				var codeHex = $(this).data('hex');
				
				$('.color-holder-'+image_id).css('background-color',codeHex);
				$('#pickcolor-'+image_id).val(codeHex);
				
			});
		}); 
	}); 
	
    
	
	
