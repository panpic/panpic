/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();

	// Load dialog on click
	$('#basic-modal .basic').click(function (e) {
				
		var prId = $(this).attr("href");
		var table_no = $(this).attr("name");
		var strCat= '';
		
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/cat/',
			 async: false,
			 data: "prId="+prId+"&table_no="+table_no,
			 success: function(text){ strCat = text; }
		});

		$("#prId").val(prId);
		$("#table_no").val(table_no);
		
		var addUrl = '';
		var current_page = $("#current_page").val();
				
		if(current_page == '' || current_page == 'undefined') current_page = 1;
		
		var esname = $("#esName").val();
		var esid = $("#esid").val();
		
		if(esid) addUrl += '/esid/'+esid;
		if(esname) addUrl += '/esname/'+esname;
		
		var ecat = $("#cmbMainCat").val();		
		if(ecat) addUrl += '/ecat/'+ecat;
		
		var verify = $("#cbxVerify").val();
		if(verify) addUrl += '/verify/'+verify;
		
		var discount = $("#cbxDiscount").val();
		if(discount) addUrl += '/discount/'+discount;
		
		var sday = $("#cbxDate").val();
		if(sday) addUrl += '/sday/'+sday;
		
		var noItems = $("#cbxItems").val();
		if(noItems) addUrl += '/c/'+noItems;
		
		$('#basic-modal-content').modal(
			{onClose: function (dialog) {
					var replaceURL = base_url_admin+'product/view/page/'+current_page+addUrl+'/';
					$('#test').val(current_page);
					window.location.replace(replaceURL);
					$.modal.close();  
				} 
			}			
		);
				
		if(strCat != ''){
			$("#msg").css("background-color","white");
			$("#msg").html(strCat);
		}
		
		return false;
	});
		
	// Load dialog 2 on click
	$('#basic-modal .basic_2').click(function (e) {
				
		var prId = $(this).attr("href");
		var table_no = $(this).attr("name");
		var strCat = '';
				
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/cat/',
			 async: false,
			  data: "prId="+prId+"&table_no="+table_no,
			 success: function(text){ strCat = text; }
		});

		var esPrdDetail = $(this).attr("id");
		$("a.productDetail").attr("href", esPrdDetail);
		$("#verify_product_id").val(prId);
		$("#verify_table_no").val(table_no);
		
		current_page = $("#current_page").val();
		if(current_page == '' || current_page == 'undefined') current_page = 1;
		
		var addUrl = '';
		var esname = $("#esName").val();
		var esid = $("#esid").val();		
		if(esid) addUrl += '/esid/'+esid;					
		if(esname) addUrl += '/esname/'+esname;
		
		var ecat = $("#cmbMainCat").val();		
		if(ecat) addUrl += '/ecat/'+ecat;
				
		var verify = $("#cbxVerify").val();
		if(verify) addUrl += '/verify/'+verify;
		
		var discount = $("#cbxDiscount").val();
		if(discount) addUrl += '/discount/'+discount;
		
		var sday = $("#cbxDate").val();
		if(sday) addUrl += '/sday/'+sday;
		
		var noItems = $("#cbxItems").val();
		if(noItems) addUrl += '/c/'+noItems;
		
		$('#basic_2-modal-content').modal(
			{onClose: function (dialog) {					
					var replaceURL = base_url_admin+'product/view/page/'+current_page+addUrl+'/';
					window.location.replace(replaceURL);
					$.modal.close();  
				} 
			}			
		);
		
		if(strCat != ''){
			$("#msg_verify").css("background-color","white");
			$("#msg_verify").html(strCat);
		}
		
		return false;
	});
	
});


function hiddenMap() {
$('#basic-modal .basic').click(function (e) {

	var prId = $(this).attr("href");
	var strCat= '';
	
	$.ajax({ type: "POST",   
		 url: base_url_admin+'productajx/cat/',
		 async: false,
		 data: "prId="+prId,
		 success: function(text){ strCat = text; }
	});

	$('#basic-modal-content').modal();		
	//$("#hiddenMap").hide();
	$("#prId").val(prId);
	
	if(strCat != ''){
		$("#msg").css("background-color","white");
		$("#msg").html(strCat);
	}
	
	return false;
});
}


function setPrdHome(mmId) {	
	var mmStatus;
	var mmId = mmId;
	
	if ($('#mmId_'+mmId).is(':checked')) mmStatus = 1;
	else mmStatus = 0;
		
	if(mmId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/setproducthome/',
			 async: false,
			 data: "mmId="+mmId+"&mmStatus="+mmStatus,
			 success: function(text){ $("#updateStatus").html(text); }
		});
	}
		
	//if(document.jpop.mmId.checked) mmStatus = 1;
	//else mmStatus = 0;
	//$("#ajxvip").find('input:radio').each(function(){ $(this).attr('disabled', false); });
}

function verifyMap(mmId) {	
	var mmVerify;
	var mmId = mmId;
	
	if ($('#verify_'+mmId).is(':checked')) mmVerify = 1;
	else mmVerify = 0;
		
	if(mmId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/verifymap/',
			 async: false,
			 data: "mmId="+mmId+"&mmVerify="+mmVerify,
			 success: function(text){ $("#updateStatus").html(text); }
		});
	}
}


function verifyProduct() {	
	var prVerify;
	var prId = $('#verify_product_id').val();
	var t_n = $('#verify_table_no').val();
	
	if ($('#verify_product').is(':checked')) prVerify = 5;
	else prVerify = 0;
	
	if(prId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/verifyproduct/',
			 async: false,
			 data: "prId="+prId+"&prVerify="+prVerify+'&t_n='+t_n,
			 success: function(text){ $("#verify_product_status").html(text); }
		});
	}
}

function removeMap(mmId) {	
var mmId = mmId;
	
	if(mmId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/removemap/',
			 async: false,
			 data: "mmId="+mmId,
			 success: function(text){				
				if(text == 2){ $("#updateStatus").html('Remove fail!'); }
				else { $("#msg").css("background-color","white"); $("#msg").html(text); }
			 }
		});
	}
}

