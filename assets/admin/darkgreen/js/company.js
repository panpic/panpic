// Company
$(document).ready(function() { 
	
	$('.same_as_above').on('click', function(e) { //same as above				
		if( $('.same_as_above').prop('checked') ) {						
			var address = $('input[name="address"]').val();
			var tel 	= $('input[name="tel"]').val();
			var fax 	= $('input[name="fax"]').val();			
			$('input[name="delivery[delivery_address][]"]').val(address);
			$('input[name="delivery[delivery_tel][]"]').val(tel);
			$('input[name="delivery[delivery_fax][]"]').val(fax);			
		} 		
    });
	
	$('.btn_personal').on('click', function(e) { //add       
	   var my_append= $('#id_personal_empty').html();
        $('#id_personal').append( my_append );
		$('#id_personal').on('click','.bt_remove_person',function(){
			$(this).closest('.purchase-product').remove();
		});
    });
	
	$('.btn_edit_personal').on('click', function(e) { //edit
	   var my_append= $('#id_personal_empty').html();
        $('#id_update_personal').append( my_append );
		$('#id_update_personal').on('click','.bt_remove_person',function(){
			$(this).closest('.purchase-product').remove();
		});
    });
	
	// Delivery	
	$('.btn_add_delivery').on('click', function(e) {
	   var my_append= $('#id_delivery_empty').html();
        $('#id_add_delivery').append( my_append );
		$('#id_add_delivery').on('click','.bt_remove_delivery',function(){
			$(this).closest('.delivery-product').remove();
		});
    });	
	$('.btn_edit_delivery').on('click', function(e) {
	   var my_append= $('#id_delivery_empty').html();
        $('#id_update_delivery').append( my_append );
		$('#id_update_delivery').on('click','.bt_remove_delivery',function(){
			$(this).closest('.delivery-product').remove();
		});
    });
	
	
	$('.btn_add_companies').on('click', function(e) { //add multi companies       
	    var my_append= $('#id_company_empty').html();
        $('#id_add_company').append( my_append );
		
		$('.same_multi_above').on('click', function(e) { //same as above				
			if( $('.same_multi_above').prop('checked') ) {						
				var address = $('input[name="multi[address][]"]').val();
				var tel 	= $('input[name="multi[tel][]"]').val();
				var fax 	= $('input[name="multi[fax][]"]').val();			
				$('input[name="multi[delivery][delivery_address][]"]').val(address);
				$('input[name="multi[delivery][delivery_tel][]"]').val(tel);
				$('input[name="multi[delivery][delivery_fax][]"]').val(fax);			
			} 		
		});
		
		$('#id_add_company').on('click','.bt_remove_companies_multi',function(){
			$(this).closest('.companies-multi').remove();
		});
		
		$('.btn_personal_multi').on('click', function(e) { //add multi personal	
			var my_append= $('#id_company_personal_empty').html();
			$('#id_personal_multi').append( my_append );
			
			// person belong to company
			var company_name = $(this).closest('.companies-multi').find('.company_name').val();
			$(this).closest('.companies-multi').find('.company_name_person').val(company_name);
			
			$('#id_personal_multi').on('click','.bt_remove_person_multi',function(){
				$(this).closest('.purchase-product').remove();
			});
		});
		
		$('.btn_delivery_multi').on('click', function(e) { //add multi delivery	
			var my_append= $('#id_company_delivery_empty').html();
			$('#id_delivery_multi').append( my_append );			
			// delivery belong to company
			var company_name = $(this).closest('.companies-multi').find('.company_name').val();
			$(this).closest('.companies-multi').find('.company_name_delivery').val(company_name);
			
			$('#id_delivery_multi').on('click','.bt_remove_delivery_multi',function(){
				$(this).closest('.delivery-product').remove();
			});
		});		
    });
	
	// person & delivery belong to company
	$('#id_add_company').on('change keyup paste','.company_name',function(){									 
		var company_name = $(this).val();
		$(this).closest('.companies-multi').find('.company_name_person').val(company_name);
		$(this).closest('.companies-multi').find('.company_name_delivery').val(company_name);
	});
	
});


function copyDelivery() {
	var address = '';
}
