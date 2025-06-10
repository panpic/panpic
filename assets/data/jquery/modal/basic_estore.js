jQuery(function ($) {
	$('#basic-modal .basic').click(function (e) { 
		
		var prId = $(this).attr('href'); 		
		var table_no = $(this).attr("name");

		
		$('#basic-modal-content').modal();
		var prImage = $(this).attr("primg");
		var prName = $(this).attr("title");		
		$("#prId").val(prId); $("#qtt").val(prName); $("#t_n").val(table_no);
		
		if(typeof prImage !== 'undefined' && prImage != '') { $("#prImage").attr("src", prImage); }
		
		return false;
	});	
	
});
