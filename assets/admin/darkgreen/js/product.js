$(document).ready(function() { 

	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){ $(".alert").slideUp(500);}); 
    }, 2000);
	
	$('#btnAddBlog').click(function (e) { 
		var flag = 0;
		var errors = '';
		var id_title = $('#id_title').val();
		
		if(id_title == '') {
			flag = 1; errors = please_input+' '+lable_title +'<br />';
		}
		
		if(flag == 1) {
			$('#content-danger').html(errors);
			$('#modal-danger').modal('show');
		} else {
			$('#frm_data').submit();
		}
	});
		
	$("#deleteMulti").on('click', function(){
	   var frm_action = base_url_admin+'/'+current_control+'/deletemulti/'
	   $('#frm-data').attr('action', frm_action);
	   $('#frm-data').submit();	       
	});
	
	// Empty recycle bin
	$("#emptyRecycleBin").on('click', function(){
	   var frm_action = base_url_admin+'/'+current_control+'/removemulti/'
	   $('#frm-data').attr('action', frm_action);
	   $('#frm-data').submit();	       
	});

    $('.avail').on('click', function(e) {     
        var blog_id = $(this).attr('id');
        var status_id = $(this).val();
		$.ajax({
            url: base_url_admin +'/products/update_status/',
            type: 'POST',
            data: "id="+blog_id+"&s="+status_id,
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
	
	$('.hot_status').on('click', function(e) {     
        var blog_id = $(this).attr('id');
        var status_id = $(this).val();
		
        $.ajax({
            url: base_url_admin +'/products/update_hot_status/',
            type: 'POST',
            data: "id="+blog_id+"&s="+status_id,
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

    $('.display-home').on('click', function(e) {     
        var blog_id = $(this).attr('rel');
		var display_home;
		var name_field = 'display_home-'+blog_id;
		
		if ( $('input[name='+name_field+']').get(0).checked == true ) { //Checked
			display_home = 1
		} else { // No checked
			display_home = 0
		} 

        $.ajax({
            url: base_url_admin +'/products/updateVerify',
            type: 'POST',
            data: "id="+blog_id+"&d="+display_home,
            success: function(data){
				if(data == 1) { }
            }
        });
    });
	
	
	$('.show-home').on('click', function(e) {     
        var blog_id = $(this).attr('rel');
        var display_home;
		var name_field = 'shows_home-'+blog_id;
		var lang = $(this).data('lang');
		
		if ( $('input[name='+name_field+']').get(0).checked == true ) { //Checked
			display_home = 1
		} else { // No checked
			display_home = 0
		} 
		
		$.ajax({
            url: base_url_admin +'/products/show_home',
            type: 'POST',
            data: "id="+blog_id+"&d="+display_home+"&l="+lang,
            success: function(data){
				if(data == 1) {}
            }
        });
    });
	
});