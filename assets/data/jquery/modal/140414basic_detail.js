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
		//var prId = $(this).attr("href");
		var qty = $("#partridge").val();
		
		$('#basic-modal-content').modal();
		var prImage = $(this).attr("primg");
		//$("#prId").val(prId);
		$("#qtt").val(qty);
		$("#prImage").attr("src", prImage);
		return false;
	});	
	
	$('#baoloi-modal').click(function (e) {
		var qty = $("#partridge").val();		
		$('#baoloi-modal-content').modal();
		$("#qtt").val(qty);
		return false;
	});	
	
	$('#support-modal .basic').click(function (e) {
		$('#support-modal-content').modal();
		$('#imgRandom').attr('src', testImgRandom());
	});
	
	$('#support-modal .support').click(function (e) {
		$('#support-modal-content').modal();
		$('#imgRandom').attr('src', testImgRandom());
	});
	
	// Load dialog order at solr search page
	$('#basic-modal .estore').click(function (e) {

		var eEmail;
		var prId = $(this).attr("name");
		$('#basic-modal-content').modal();
		var prImage = $(this).attr("primg");		
		var esId = $(this).attr("title");
		
		if( esId == '') { return false; }
		
		var url = '/tools/timkiemorder/';
		
		$.ajax({ type: "POST",   
			 url: base_url+url,
			 async: false,
			 data: 'esid='+esId,
			 dataType: "json",
			 success: function(text){ eEmail = text.eEmail; },
			 error: function (text) { return false }
		});
				
		$("#prId").val(prId);
		$("#mEmail").val(eEmail);
		$("#esid").val(esId);		
				
		if(typeof prImage !== 'undefined' && prImage != '') {
			$("#prImage").attr("src", prImage);
		}
		
		return false;		
	});
		
});


function testImgRandom() {	
	return base_url+"/login/random/";
}