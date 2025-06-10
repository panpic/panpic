$(document).ready(function() { 

	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
	
	$('#btnAddBanner').click(function (e) { 
		var flag = 0;
		var errors = '';
		var id_title = $('#id_title').val();
		/*
		if(id_title == '') {
			flag = 1; errors = please_input+' '+lable_title +'<br />';
		}
		*/
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
        var status_id;
		
		if( $(this).is(':checked') ) {
			status_id = 1;
		} else {
			status_id = 0;
		}
		
        $.ajax({
            url: base_url_admin +'/banner/update_status/',
            type: 'POST',
            data: "id="+blog_id+"&s="+status_id,
            success: function(data){ 
                if(data == 1) {
                    if(status_id == 1) {
                        $(this).val(1);
                        $(this).attr('checked', 'checked');
                    } else {
                        $(this).val(0);
                        $(this).removeAttr('checked');
                    }
                }
            }
        });
    });

	
});