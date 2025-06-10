$(function(){
	 $('input[type=radio][name=reply]').change(function() {
        if (this.value == 'admin') {
    		$('.contractor-reply').removeClass('show'); 
           	$('.admin-reply').addClass('show'); 

           	$('#btn_button').removeClass('con-show'); 
           	$('#btn_button').addClass('add-show'); 

           	$('.box-generic').removeClass('con-show'); 
           	$('.box-generic').addClass('add-show'); 

           	$('#form_blog').attr('action',action_url); 


        }
        else if (this.value == 'contractor') {
        	$('.admin-reply').removeClass('show');
            $('.contractor-reply').addClass('show');

            $('#btn_button').addClass('con-show'); 
           	$('#btn_button').removeClass('add-show'); 

           	$('.box-generic').addClass('con-show'); 
           	$('.box-generic').removeClass('add-show'); 
           	$('#form_blog').attr('action', action_url1); 
           	
        }
    });
}); 