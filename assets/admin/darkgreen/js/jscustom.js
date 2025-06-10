$(function() {
	
	$("#modal-language").on('shown.bs.modal', function() {
		//alert('===');
	 });
	
	$('.lang_values').click(function (e) {
        $('.variables-list label').css({'display': 'block'});
        $('.variables-list input').css({'display': 'none'});
		
        var id = $(this).data('id');
        $('.lab-' + id).css({'display': 'none'});
        $('#' + id).css({'display': 'block'});
    });
	
	//fAddLang
	// validate signup form on keyup and submit
	/*
	$("#fAddLang").validate({
		rules: {
			name: {
				required: true
			},
			value: {
				required: true
			}
		},
		messages: {
			name: {
				required: $("#fAddLang").data('namerequired')
			},
			value: {
				required: $("#fAddLang").data('valuerequired')
			}
		},
		submitHandler: function(form) {
			var $form = $(form);
    		$form.submit();
		}
	});
	*/
	
	$("#fAddLang #name").keyup(function(){
		var v = $(this).val().replace(" ", "_").toLocaleLowerCase(),		
       		vr = v.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a").replace(/\ /g, '_').replace(/đ/g, "d").replace(/đ/g, "d").replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ.+/g,"o").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ.+/g, "e").replace(/ì|í|ị|ỉ|ĩ/g,"i");       
		$(this).val(vr)
	});	
    //End fAddLang
	
	
	$('#btn_submit').click(function(event) {
        var test = $('.check-file').html();
        validEgency(); 
	});
	$('#btn_cancel').click(function(event) {
		window.location.replace(base_url_admin+'/agency/'); 
	});
	$('#btnSaveAminUser').click(function(event) {
		validAdmin(); 
	});
	$('#frmAdminUser').on('change', 'input', function(event) {
		event.preventDefault();
		$(this).next('.red').html(''); 
	});
	$('#btn-brand').click(function(event) {
		validBrand(); 
	});
	$("[data-id]").click(function(event) {
		event.preventDefault(); 
		//location.reload();
		var agency_id = $(this).data('id'); 
		var avail = $(this).data('avail'); 
		$.ajax({
			url: base_url_admin + '/agency/update',
			type: 'POST',
			data: {agency_id: agency_id, avail : avail},
			success: function(data){
				location.reload();
			}
		});
		
	});
	$('input[name="data[email]"]').blur(function(event) {
		//var email = $('#login_email').val();
		var email = $(this).val();  
		var login_email = $(this).data('email'); 
		if(email == login_email ) return false; 
		var test = !validateEmail(email) ? 0 : 1; 
		var _this = $(this); 
		
		_this.closest('.form-password').find('.modal-footer').children('button').removeAttr('disabled');//('disabled','disabled');
		
		if (email == '') return ; 
		
		$.ajax({
			url: base_url_admin + '/agency/checkEmailExist',
			type: 'POST',
			data: {
				'email' : email, 
				'test'  : test,
			},/*'email='+email+'test='+test,*/
			success: function(data){
				var result = jQuery.parseJSON(data);
				var flag = result.flag; 
				if(flag == 0){
					_this.closest('.form-password').find('.modal-footer').children('button').attr('disabled','disabled'); 
				}
				_this.next('span').html('<span>'+result.message+'</span>');
			}
		});
	});
	
	// using
	$('#checkAll').click(function(event) {
		if( $(this).is(':checked') ){
			$('.list-items input[name="checkAll[]"]').prop('checked', true);
		}else{
			$('.list-items input[name="checkAll[]"]').removeAttr('checked'); 
		}
	});
	
	$('#keyword').keypress(function(e) {
		var keyword = $(this).val(); 
		var enter = e.keyCode || e.which; 
		if(enter == 13 && keyword == ''){
			//$('#form-search').submit(); 
			return false; 
		}
	});
	
	$('.form-password').each(function(index, el) {
		$('#btn-pass-'+index).click(function(event) {
			var ok              = 1 ;
			var old_email       = $('#old_email-'+index).val();
			var email           = $('#email-'+index).val(); 
			var password        = $('#password-'+index).val(); 
			var password_retype = $('#password_retype-'+index).val(); 
			if(old_email != email){
				if(!validateEmail(email)){
					$('#valid_email-'+index).html('<span>'+emailNotMath+'</span>');
					ok = 0 
				}
				if(email == ''){
					$("#valid_email-"+index).html('<span>'+requireMsg+'</span>'); 
					ok = 0; 
				}
			}
			if(password.length < 6){
				$('#valid_password-'+index).html('<span>'+ requirePass +'</span>'); 
				ok = 0 ;
			}
			if(password != password_retype){
				$("#valid_password_retype-"+index).html('<span>' + passNotMath + '</span>');
				ok = 0; 
			}
			if(password_retype == '' ){
				$("#valid_password_retype-"+index).html('<span>' + requireMsg + '</span>');
				ok = 0 ; 
			}
			if( ok == 0 ) return false; 
			$('#form-password-'+index).submit();  
			
		});
	});
	
});


function update(obj, e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        var id = $(obj).attr('id');
        var value = $(obj).val();
        $('.lab-' + id).css({'display': 'block'}).text(value);
        $('#' + id).css({'display': 'none'});

        $.ajax({
            url: base_url_admin + '/setup/update',
            type: 'POST',
            data: {'value': value, 'obj': id},
            //this is the dataType    
            dataType: 'json',
            success: function (results) {
                //document.location.reload( true );
            }
        });

    }
}




function validBrand(){
	var ok = 1;
	var brand_name = $('#brand_name').val(); 
	if(brand_name == '' || brand_name == 0){
		$('#valid_brand_name').html('<span>'+ requireMsg +'</span>'); 
		ok = 0 
	}
	if(ok==0){
		$('#btn-brand').removeAttr('data-dismiss');
		return false; 
	} else {
		$('#btn-brand').attr('data-dismiss', 'modal'); 
	}	
	var data = $('#form_brand').serialize(); 
	//console.log(data); return false; 
	url = base_url_admin + '/agency/add_brand/';
	 $.ajax({
	 	url: url,
	 	type: 'POST',
	 	cache: false, 
	 	data: data,
	 	success: function(data){
	 		$('.list_brands').html(data); 
	 	},
	 });
}

function validAdmin(){
	var username = $('#adminLogin').val(); 
	var pass     = $('#adminPass').val(); 
	var re_pass  = $('#re-adminPass').val(); 
	var name     = $('#adminName').val(); 
	var ok = 1; 
	if(pass.length < 6){
			if(id !== ''){
				ok = 1;
			}
			else{
				$('#valid_adminPass').html('<span>'+ requirePass +'</span>'); 
            	ok = 0
			}
             
    }
    if(pass != re_pass){
            $("#valid_re-adminPass").html('<span>' + passNotMath + '</span>');
            ok = 0
    }
    if(re_pass == ''){
    		if(id !== ''){
    			ok = 1;
    		}
    		else{
    			$("#valid_re-adminPass").html('<span>' + requireMsg + '</span>');
            	ok = 0 ;
    		}
             
    }
    if(re_pass == '' && pass !==''){
    		
			$("#valid_re-adminPass").html('<span>' + requireMsg + '</span>');
        	ok = 0 ;
    
    }
    if(username == '' || username == 0){
    	$('#valid_adminLogin').html('<span>' + requireMsg + '</span>');
    	ok  = 0; 
    }
    if(name == '' || name == 0){
    	$('#valid_adminName').html('<span>' + requireMsg + '</span>');
    	ok  = 0; 
    }
    if(ok == 0 ) return false; 
    $('#frmAdminUser').submit(); 
}

function hideFieldRequire(field){
	$(field).html(''); 
}

function validPackage(){
	var package_id = $('#package_id').val(); 
	if(package_id == 1){
		$('#expired_date').attr('disabled', 'disabled'); 
	} else{
		$('#expired_date').removeAttr('disabled'); 
	}
}

function validateEmail($email) {
  	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  	return emailReg.test( $email );
}