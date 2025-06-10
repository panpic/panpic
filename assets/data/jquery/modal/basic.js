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
		var strCat= '';
		
			$.ajax({ type: "POST",   
				 url: base_url_admin+'productajx/cat/',
				 async: false,
				 data: "prId="+prId,
				 success: function(text){
					 strCat = text;
				 }
			});

		$("#prId").val(prId);
		
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
		
				
		$('#basic-modal-content').modal(
			{onClose: function (dialog) {					
					var replaceURL = base_url_admin+'product/view/page/'+current_page+addUrl+'/';
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
	
});


function hiddenMap()
{
	$('#basic-modal .basic').click(function (e) {

		var prId = $(this).attr("href");
		var strCat= '';
		
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/cat/',
			 async: false,
			 data: "prId="+prId,
			 success: function(text){
				 strCat = text;
			 }
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


function setPrdHome(mmId)
{	
	var mmStatus;
	var mmId = mmId;
	
	if(document.jpop.mmId.checked) mmStatus = 1;
	else mmStatus = 0;
	
	if(mmId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/setproducthome/',
			 async: false,
			 data: "mmId="+mmId+"&mmStatus="+mmStatus,
			 success: function(text){
				$("#updateStatus").html(text);				
			 }
		});
	}
}


function removeMap(mmId)
{	
	var mmId = mmId;
		
	if(mmId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_admin+'productajx/removemap/',
			 async: false,
			 data: "mmId="+mmId,
			 success: function(text){				
				if(text == 2){
					$("#updateStatus").html('Remove fail!');
				}else {					
					$("#msg").css("background-color","white");
					$("#msg").html(text);
				}								
			 }
		});
	}
}

