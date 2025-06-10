//validate pricekage
$(document).ready(function(){


	

	$("#btn-update-package").on('click', function(){
		
		if ( validPackage() == 1) {
			$('form#frm-data').submit();	
		} 
	});


	function validPackage() {

		var flag = 1;

		$('.validate .my-control').each(function() {

			// check price
		    var my_price = $(this).find('.my-price').val();
		    var current_price_id = $(this).find('.my-price').attr('rel');
		    if(my_price == '') {
		    	flag = 0;
		    	$(this).find('#'+current_price_id).html( require_price );
		    }

		    // post toi da
		    var my_maximum_post = $(this).find('.my-maximum_post').val();
		    var current_maximum_post = $(this).find('.my-maximum_post').attr('rel');
		    if(my_maximum_post == '') {
		    	flag = 0;
		    	$(this).find('#'+current_maximum_post).html( require_maximum_post );
		    }

		    /*
		    //check price_promotion
		    var my_price_promotion = $(this).find('.my-price_promotion').val();
		    var current_price_promotion = $(this).find('.my-price_promotion').attr('rel');
		    if(my_price_promotion == '') {
		    	$(this).find('#'+current_price_promotion).html( require_price_promotion);
		    	flag = 0;
		    }
		    //promotion_maximum_posts
		    var my_promotion_maximum_posts = $(this).find('.my-promotion_maximum_posts').val();
		    var current_promotion_maximum_posts = $(this).find('.my-promotion_maximum_posts').attr('rel');
		    if(my_promotion_maximum_posts == '') {
		    	$(this).find('#'+current_promotion_maximum_posts).html(require_maximum_post);
		    	flag = 0;
		    }
		    */
		   
		});

		return flag;
	}
	
	

});