$(function() { $('#side-menu').metisMenu();	});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) { $('div.sidebar-collapse').addClass('collapse'); } 
		else { $('div.sidebar-collapse').removeClass('collapse'); }
    })
})


function isnumberic(s) {
	var str="01234556789";
	var i, l, ch;
	l = s.length;
	
	for(i=0; i<l; i++) { ch=s.charAt(i); if(str.indexOf(ch)== -1) { return false; } }
	
	return true;
}


function category(){	
	var cat_root = $('#cat_root').val();
	var cat_name = $('#cat_name').val();
	
	/*
	if(cat_root == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredCatRoot); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#cat_root').focus(); });
		return false;
	}
	*/
	
	if(cat_name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredCatName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#cat_name').focus(); }); return false;
	}
	
	return true;
}


function news(){	
	var cat_id 	= $('#cat_id').val();
	var name 	= $('#name').val();
		
	if(cat_id == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredCatName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#cat_id').focus(); }); return false;
	}
		
	if(name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#name').focus(); }); return false;
	}
	
	return true;
}

function seo_trigger(txt_id) { $("#seo_title").val( $('#'+txt_id).val() ); }

function newsVerify(){ 
	var checked = $('#group_verify input:checked').val(); $('#box_refusal').hide()
	$("#group_verify").find("input").each(function(){ if( $(this).val() == checked && $(this).val() == 2) { $('#box_refusal').show(); } }); 
}

function calendarDelay(){ 
	var checked = $('#group_delay input:checked').val(); $('#box_delay').hide();
	var type;
	
	$("#group_delay").find("input").each(function(){ 
		type = $(this).val();
		if( type == checked && (type == 'B' || type == 'D')) { $('#box_delay').show(); } 
	}); 
}

function delImg(pair_id, image_id){
	if(pair_id == '' || image_id == '') return;
		
	var btn = $('#loading-btn');
	btn.button('loading');
	
	$.ajax({
		type: "POST",
		url: base_url_admin+"deleteimage/",
		async: false,		
		data: "pair_id="+pair_id+"&image_id="+image_id,
		success: function(text){ if(text == 1){ $('#image_detail').hide(); } },		
	});
	
	btn.button('reset');
}


function delAttach(pair_id, image_id){
	if(pair_id == '' || image_id == '') return;
		
	var btn = $('#loading-btn');
	btn.button('loading');
	
	$.ajax({
		type: "POST",
		url: base_url_admin+"deleteimage/",
		async: false,		
		data: "pair_id="+pair_id+"&image_id="+image_id,
		success: function(text){ if(text == 1){ $('#id_attach').hide(); } },		
	});
	
	btn.button('reset');
}


function pageUrl(page_url){
	var flag = 0;
	$.ajax({
		type: "POST",
		url: base_url_admin+"aboutus/pageurl/",
		async: false,		
		data: "page_url="+page_url,
		success: function(text){ if(text == 1) { flag = 1; } },		
	});
		
	if(flag == 1) { return true }
	
	return false;
}

function page(){	
	var page_url = $('#page_url').val();
	var name 	= $('#name').val();
		
	if(page_url == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredPageUrl); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#page_url').focus(); }); return false;
	}
	
	if(option == 'add') {
		if(pageUrl(page_url)) {
			$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredPageExist); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#page_url').focus(); }); return false;
		}
	}
	
	if(name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#name').focus(); }); return false;
	}
	
	return true;
}


function events(){	
	
	var name 	= $('#name').val();
	var location = $('#location').val();
	var date_event = $('#date_event').val();
	var fee_joined = $('#fee_joined').val();
	
	if(name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#name').focus(); }); return false;
	}
	
	if(location == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredLocation); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#location').focus(); }); return false;
	}
	
	if(date_event == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredDate); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#date_event').focus(); }); return false;
	}
	
	/*
	if(! dateCompare(date_event)) {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredDate); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#date_event').focus(); }); return false;
	}
	*/
	
	if(fee_joined == '' || !isnumberic(fee_joined)) {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(invalidFee); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#fee_joined').focus(); }); return false;
	}
		
	return true;
}


function gallery(){		
	var file_img = $('#file_img').val();		
	if(file_img == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredImage); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#name').focus(); }); return false;
	}	
	return true;
}


function documents(){		
	var cat_id 	= $('#cat_id').val();
	var name 	= $('#name').val();
	var location= $('#location').val();
		
	if(cat_id == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredCatName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#cat_id').focus(); }); return false;
	}
	
	if(location == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredSign); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#location').focus(); }); return false;
	}
	
	if(name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#name').focus(); }); return false;
	}
		
	return true;
}


function advertising(){		
	var cat_id 	= $('#cat_id').val();
	var name 	= $('#name').val();
	var file_img= $('#file_img').val();
		
	if(cat_id == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredCat); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#cat_id').focus(); }); return false;
	}
		
	if(name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#name').focus(); }); return false;
	}
	
	if(option == 'add') {
		if(file_img == '') {
			$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredFile); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#location').focus(); }); return false;
		}
	}
	return true;
}

function calendar(){
	
	var cc_id 		= $('#cat_id').val();
	var chairman 	= $('#chairman').val();
	var location 	= $('#location').val();
	var joined 		= $('#txtjoined').val();
	var content 	= $('#txtcontent').val();
		
	/*
	var instContent = FCKeditorAPI.GetInstance("txtcontent");
    var content = instContent.GetHTML();	
	var instJoined = FCKeditorAPI.GetInstance("txtjoined");
    var joined = instJoined.GetHTML();
	*/
	
	if(content == '' || content == '&nbsp;') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredContent); $('#smallModal').modal('show'); 		
		$('#smallModal').on('hidden.bs.modal', function (e) { instContent.Focus(); }); 		
		return false;
	}
	
	if(cc_id == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredDept); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#cc_id').focus(); }); return false;
	}
	
	if(chairman == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredChairman); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#chairman').focus(); }); return false;
	}
	
	if(location == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredLocation); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#location').focus(); }); return false;
	}
	
	if(joined == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredJoned); $('#smallModal').modal('show'); 
		$('#smallModal').on('hidden.bs.modal', function (e) {  
			instJoined.Focus(); 
		}); 
		return false;
	}
		
	return true;
}


function add_member(){		
	var name 	= $('#name').val();
			
	if(name == '') {
		$('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#company').focus(); }); return false;
	}
	
	return true;
}

$(document).ready(function() { 
	// Admin login
	$('#btnLogin').click( function() { $('#frmLogin').submit(); });	
	
	// Category
	$('#add_category').click( function() { if(category()){ $('#frm_add').submit(); } });
	
	// News
	$('#add_news').click( function() { if(news()){ $('#frm_add').submit(); } });
	
	// Page
	$('#add_page').click( function() { if(page()){ $('#frm_add').submit(); } });
	
	// Events
	$('#add_events').click( function() { if(events()){ $('#frm_add').submit(); } });
	
	// Events - normal
	$('#edit_events').click( function() { $('#frm_add').submit(); });
	
	// Add image gallery
	$('#add_image').click( function() { 
		if(option == 'add') { if(gallery()){ $('#frm_add').submit(); } 
		} else { $('#frm_add').submit(); }
	});
	
	// Documents
	$('#add_document').click( function() { if(documents()){ $('#frm_add').submit(); } });
	
	// Advertising
	$('#add_advertising').click( function() { if(advertising()){ $('#frm_add').submit(); } });
	
	// Calendar
	$('#add_calendar').click( function() { if(calendar()){ $('#frm_add').submit(); } });
	
	// Member
	$('#add_member').click( function() { if(add_member()){ $('#frm_add').submit(); } });
	
});