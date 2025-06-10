$(document).ready(function() {
	if(step==1){
		$('#title').blur(function(event) {
			var slug = $('#slug').val(); 
			var url = base_url_admin + '/tour/checkSlugExist';

			$.ajax({
				url: url,
				type: 'POST',
				data: {slug: slug},
				// dataType: 'json', 
				success: function(data){
				// ok = data.ok; 
				$('#valid_slug').html('<span>'+data+'</span>');
				}
			});
			
		});
	}

	
	
	//var stepp = step ; 
	$('.btn_next').on('click',  function(event) {
		event.preventDefault();
		var ok = 1;

		if(step == 1){

			var title                 = $('#title').val(); 
			var price                 = $('#price').val(); 
			var price_promotion       = $('#price_promotion').val(); 
			var background_url        = $('#background_url').val(); 
			var status_background_url = $('.check-file .background').attr('data-state');


			
			if(title == '' || title == 0){
				$("#valid_title").html('<span>' + requireMsg + '</span>');
				ok = 0; 
			}

			if(price == '' ){
				$('#valid_price').html('<span>'+requireMsg+'</span>');
				ok = 0; 
			}

			if(price_promotion == ''){
				$('#valid_price_promotion').html('<span>'+requireMsg+'</span>');
				ok = 0;
			}

			if(!isnumberic(price)){
				$('#valid_price').html('<span>'+requireNum+'</span>');
				ok = 0; 
			}

			if(!isnumberic(price_promotion)){
				$('#valid_price_promotion').html('<span>'+requireNum+'</span>');
				ok = 0;
			}

			if(background_url == '' && status_background_url == 'empty'){
				$("#valid_background_url").html('<span>' + requireMsg + '</span>');
				ok = 0 ; 
			}

		} else if(step ==3){
			var image = countImage(); 
			var count = image.length; 

			//console.log(image);
			var arr = [];;
			$('.parent input[type=hidden]').each(function(index, el) {
				var id = $(this).val(); 
				arr.push(id); 
			});

			$.each(image, function(index, el) {
				var dex = index + 1; 
				var image = $('#'+el+' .image_url').val();
				var status_image = $('#'+el+' .image').attr('data-state');
				if(image == '' && status_image == 'empty' ){
					$('#'+el+' .valid_image').html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

				if(count < 3){
					$('#'+el+' .valid_image').html(requiredImg);
					ok = 0;  
				}
				
				var image_id = $('#'+el).find('.image').attr('data-meta-id'); 
				
				if(image_id && jQuery.inArray( image_id, arr ) == -1){
					var html = '<input type="hidden" name="image_id[]" value="'+image_id+'" >';
					$('.parent').append(html); 
				}
				
				

			});

			//return false; 



		}  
		else if(step == 4){
			var point = countPoint(); 

			$.each(point, function(index, el) {
				var dex     = index + 1; 

				var address = $('#'+el+' .add').val() 
				var lat     = $('#'+el+' .lat').val(); 
				var long    = $('#'+el+' .long').val(); 
				 

				if(address == ''){
					$('#valid_address-'+dex).html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

				if(lat == ''){
					$('#valid_latitude-'+dex).html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

				if(long == ''){
					$('#valid_longtitude-'+dex).html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

			});
		} 
		else if(step == 5){
			var hotel = countHotel(); 
			

			$.each(hotel, function(index, el) {
				var dex     = index + 1;
				var name    = $('#'+el+' .name').val(); 
				var address = $('#'+el+' .add').val() 
				var lat     = $('#'+el+' .lat').val(); 
				var long    = $('#'+el+' .long').val(); 

				if(name == ''){
					$('#'+el+' .valid_name').html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

				if(address == ''){
					$('#'+el+' .valid_add').html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

				if(lat == ''){
					$('#'+el+' .valid_lat').html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

				if(long == ''){
					$('#'+el+' .valid_long').html('<span>'+requireMsg+'</span>');
					ok = 0;
				}

			});
		} else if(step ==6){
			var numberOfChecked = $('input:checkbox:checked').length;
			if(numberOfChecked == 0) {
				$('.valid_service').html(requiredField);
				ok = 0;
			} 
		}
		if (ok == 0) return ; 
		$('#tourForm').submit(); 
	});

	 
	

	
	
	
	





	/************************************************************************/
	/*                                                                       */
	/************************************************************************/

	/*
	$('.tour-tabs').on('click', '.plus', function(event) {
		 
	
		event.preventDefault(); 
		
		var n_title   = $('.tour-tabs .tabs').length;
		var n_titles  = n_title + 1;

		var n_content  = $('.tour_schedule .tab-pane').length; 
		var n_contents = n_content + 1; 

		$('.hidden .title .tabs').attr('href','#tab'+n_titles);
		$('.hidden .title .tabs').text(tour_day+' '+n_titles);

		$('.hidden .content .tab-pane').attr('id', 'tab'+n_contents);

		var my_tab = $('.hidden .title').html(); 

		var my_content = $('.hidden .content').html(); 

		// setInterval(deleteSchedule, 1000);

		if(n_titles < 7){
			$('.tour-tabs').append(my_tab);
			$('.tour_schedule').append(my_content); 
			$('.tour_schedule #tab'+n_content).load(base_url_admin+'/tour/empty_tab', function(){
				
				$('#tab'+n_titles+' .title').text(tour_day+' '+n_titles); 
			});
		}

		$('.tour-tabs .plus').remove(); 
		$('.tour-tabs li:last-child').after('<li class="plus"><a href="#"><i class="fa fa-plus"></i></a></li>'); 

		
	});

	*/

	/*

	$('.tour_schedule').on('click', '.btn-del', function(event) {
		event.preventDefault();
		var count = $('.btn-del').length; 

		if(count > 1) {
			$(this).closest('.tour_schedule').prev().children('.active').remove(); 
			$(this).closest('.tab-pane.active').remove(); 
			$('.tour-tabs .tabs').each(function(index, el) {
				var num = index + 1; 
				$(this).attr('href','#tab'+num); 
				$(this).text(tour_day+' '+num); 	
			});
 			
 			$('.tour_schedule .tab-pane').each(function(index, el) {
 				var index = index + 1; 
 				$(this).attr('id', 'tab'+index); 

 				$(this).find('.title').text(tour_day+' '+index); 
 			});
		}


	});

	*/


	

	/********************************************************************************/
	if (step ==1){
		
	}
	else if(step == 2){
		
		$('._1day').mousedown(function(event) {
			if(!$(this).is(':checked')){

				var $parent = $(this).closest('.schedule');
				$parent.children('input').attr('checked', true); 
				$(this).trigger('change'); 
				$('.started_day input[type=text]').attr('disabled','disabled');
			}		
		});

		$('.input').each(function(index, el) {
			var value = $(this).val(); 
			var $parent = $(this).closest('.schedule');
			if(value){
				$parent.children('input').attr('checked', true); 
			}

			$(this).click(function(event) {
				$parent.children('input').attr('checked', true); 
			});

		});
		

		$('.started_day').on('click, change', 'input[type=radio]', function(event) {
			var my_val = $(this).val();
			
			if(my_val == 'day_date' || my_val == 'is_other' || my_val == 'is_daily') {
				$( "._1day" ).prop( "checked", false );
			}

			$('.started_day input[type=text]').attr('disabled','disabled');
			$(this).next('input[type=text]').removeAttr('disabled');

		});	
	} 
	else if(step==3){
		$('.btn_add_image').click(function(event) {

			var count = $('.container-custom .row-image').length; 

			var url = base_url_admin + '/tour/empty_upload';
			var c = count + 1; 
			var tour_id = $('input[name=tour_id]').val(); 

			//$('.hidden .row-image').addClass('row-image-'+c);
			$('.hidden .row-image').attr('id', 'row-image-'+c); 
			var my_append = $('.hidden').html();
			//$('.hidden .row-image').removeClass('row-image-'+c);
			$('.hidden .row-image').attr('id', ''); 



			if(count <=20){
				$('.container-custom .row').append(my_append);
				$.post(url,{tour_id: tour_id}, function(data){

					$('.container-custom #row-image-'+count).html(data).promise().done(function(){
						var url = base_tlp_admin + "/js/slim.kickstart.min.js";
						$.getScript(url);
					});
				})
				

			}

		});

		
		setInterval(function(){ hideFileImage() },1000); 




	} 
	else if(step==4){

		$('.btn_add_pickup').click(function(event) {

			var count = $('.pickup-point .pickup').length; 

			var count = count + 1;  

			$('.hidden .pickup .title').text(pickup_point +' '+ count);

			$('.hidden .pickup ').attr('id','pickup-'+count); 


			$('.hidden .pickup .red.valid_add').attr('id','valid_address-'+count);

			$('.hidden .pickup .red.valid_lat').attr('id','valid_latitude-'+count);

			$('.hidden .pickup .red.valid_long').attr('id','valid_longtitude-'+count);

			var my_append = $('.hidden').html(); 

			if(count < 10){
				$('.pickup-point').append(my_append); 
			}

		});
		setInterval(function(){ hideFile('point') },1000); 

		$('.pickup-point').on('click', '.pick-more .close', function(event) {
			event.preventDefault();
			var thisRemove = $(this); 
			$(thisRemove).closest('.pick-more').remove();

			$('.pickup-point .pickup').each(function(index, el) {
				var index = index + 1; 
				$(this).children('.title').text(pickup_point+' '+index); 			
			});
		});


	}

	else if(step ==5){

		$('.btn_add_hotel').click(function(event) {
			var count = $('.tour-hotel .hotel').length; 

			var count = count + 1; 

			$('.hidden .hotel .title').text(tour_hotel +' '+ count); 
			$('.hidden .hotel').attr('id', 'hotel-'+count); 

			var my_append = $('.hidden').html(); 

			if(count<6){
				$('.tour-hotel').append(my_append); 
			}
		});

		setInterval(function(){ hideFile('hotel') },1000); 

		$('.tour-hotel').on('click', '.hotel-more .close', function(event) {
			event.preventDefault();
			var thisRemove = $(this); 
			$(thisRemove).closest('.hotel-more').remove();

			$('.tour-hotel .hotel').each(function(index, el) {
				var index = index + 1; 
				$(this).children('.title').text(tour_hotel+' '+index); 			
			});
		});

		
	}
	else if(step==7){
		$('.schedule-morning textarea').attr('placeholder', placeholder_morning);
		$('.schedule-afternoon textarea').attr('placeholder', placeholder_afternoon);
		$('.schedule-evening textarea').attr('placeholder', placeholder_evening);

		//$('.tour-tabs li:last-child').after('<li class="plus"><a href="#"><i class="fa fa-plus"></i></a></li>'); 

		$('.btn-save').click(function(event) {
			event.preventDefault(); 
			$('#btn_save').val(1);
			$('#tourForm').submit();

		});
	} else if(step==8){
		$('.save-tour').click(function(event) {
			var avail = $('#avail').val(0); 
			$('#tourForm').submit();
		});

		$('.show-tour').click(function(event) {
			var avail = $('#avail').val(1);
			 
			$('#tourForm').submit();
		});



		
	}


	/********************************************************************/
	/*                        LIST TOUR                                 */
	/********************************************************************/

	$('.parent-status').on('click', '.tour_check', function(event) {
		
		var tour_id = $(this).attr('id');
        var status_id = $(this).val();

        if(status_id == 1){
        	var last = 0; 
        } else {
        	var last = 1; 
        }

        $.ajax({
            url: base_url_admin + '/tour/update_status/',
            type: 'POST',
            data: "id="+tour_id+"&s="+status_id+"&t="+last,
            success: function(data){
                
                if(data == 1) {
                    if(status_id == 1) {
                        $(this).val(0);
                        $(this).removeAttr('checked');
                    } else {
                        $(this).val(1);
                        $(this).attr('checked', 'checked');
                    }
                    
                    event.preventDefault(); 
                }
            }
        });
	});

	$('.tour-remove, .agency-remove').click(function(event) {
		//var open = $(this).closest('.btn-action').addClass('open'); 
		return false; 

	});

	





});
// 


/*function deleteSchedule(){
	$('.btn-del').each(function(index, el) {
		var index = index + 1; 
		console.log(index); 
		// if(index > 1){
			$('.tour_schedule').on('click', '#btn-del-'+index, function(event) {
				// event.preventDefault();
				alert(index); 
			});
		// }
				
	});
}*/


function hideFile(flag){
    if(flag == 'point'){
            var point = countPoint();
    } else if(flag == 'hotel'){
            var point = countHotel(); 
    }

    $.each(point, function(index, el) {
        $('.tab-pane').on('change', '#'+el+' input', function(event) {
                event.preventDefault();
                $(this).closest('.form-group').children('.red').html(''); 
        });
    });
}

function hideFileImage(){


	var image = countImage();
	
	$.each(image, function(index, el) {
		$('.container-custom').on('change', '#'+el+' input.image_url', function(event) { 
			event.preventDefault();
			$(this).closest('.row-image').children('.red').html(''); 
		});
	});
}
	

function isnumberic(s) {
	var str="01234556789";
	var i, l, ch;
	l = s.length;
	
	for(i=0; i<l; i++) 	{
		ch=s.charAt(i);
		if(str.indexOf(ch)== -1) return false;
	}
	
	return true;
}

function validEmail(email) { 
	invalidChars = " /:,;*#%~?="
	for(i=0; i<invalidChars.length; i++ ) {
		badChar = invalidChars.charAt(i)
		if(email.indexOf(badChar,0)>-1 ) return false
	}

	atPos = email.indexOf("@",1)
	if( atPos == -1 ) return false
	if( email.indexOf("@",atPos+1)>-1 ) return false
	periodPos = email.indexOf(".",atPos)
	if( periodPos == -1 ) return false
	if( periodPos+3>email.length )	return false
	return true
}


function countPoint(){
	var arr = [];
	$('.pickup-point .pickup').each(function(index, el) {
		var id = $(this).attr('id');
		arr.push(id);  	
	});
	return (arr); 
}

function countHotel(){
	var arr = [];
	$('.tour-hotel .hotel').each(function(index, el) {
		var id = $(this).attr('id');
		arr.push(id);  	
	});
	return (arr); 
}

function countImage(){
	var arr = []; 
	$('.container-custom .row-image').each(function(index, el) {
		var id = $(this).attr('id');
		arr.push(id);  
	});

	return (arr); 

}



function appendPlus(){
	$('.tour-tabs .plus').remove(); 
	$('.tour-tabs li:last-child').after('<li class="plus"><a href="#"><i class="fa fa-plus"></i></a></li>'); 
}



