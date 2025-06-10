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
			 url: base_url_user+'productajx/cat/',
			 async: false,
			 data: "prId="+prId+"&table_no="+table_no,
			 success: function(text){ strCat = text; }
		});

		current_page = $("#current_page").val();
		if(current_page == '' || current_page == 'undefined') current_page = 1;
		
		var addUrl = '';
		var ecat = $("#userCat").val();		
		if(ecat) addUrl += '/ecat/'+ecat;
		
		$('#basic-modal-content').modal(
			{onClose: function (dialog) { 
					var replaceURL = base_url_user+'product/view/page/'+current_page+addUrl+'/';
					window.location.replace(replaceURL);
					$.modal.close();  
				} 
			}			
		);
		
		$("#prId").val(prId);
		$("#table_no").val(table_no);
		
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
			 url: base_url_user+'productajx/cat/',
			 async: false,
			 data: "prId="+prId,
			 success: function(text){
				 strCat = text;
			 }
		});

		$('#basic-modal-content').modal();		
		$("#hiddenMap").hide();
		$("#prId").val(prId);
		
		if(strCat != ''){
			$("#msg").css("background-color","white");
			$("#msg").html(strCat);
		}
		
		return false;
	});
}


function removeMap(mmId)
{	
	var mmId = mmId;
		
	if(mmId != ''){
		$.ajax({ type: "POST",   
			 url: base_url_user+'productajx/removemap/',
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

