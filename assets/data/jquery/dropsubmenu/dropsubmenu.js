// JavaScript Document
function selectrd(id)
{
	var opt=(id==1) ? "yes" : "no";
	var tg = document.getElementById("cat");
	tg.checked=true;
}

$(document).ready(function () {
	$('#nav > li > a').click(function(){
		if ($(this).attr('class') != 'active'){
		  $('#nav li ul').slideUp();
		  $(this).next().slideToggle();
		  $('#nav li a').removeClass('active');
		  $(this).addClass('active');
			/*
			if( $(this).addClass('active') ){				
				 var r = $(this).find('input[type=radio]');
				  if($(r).is(":checked")){
					$(r).attr("checked", "");
				  }else{
					$(r).attr("checked", "checked");
				  }
			} //if
			*/
		} //if
	});
	  
	$('#sub > a').click(function(){
		if ($(this).attr('class') != 'active'){
			$('#sub ul').slideUp();
			$(this).next().slideToggle();
			$('#sub a').removeClass('active');		
			$(this).addClass('active');	  	  
		}
	});
	
	$('#sub1 > a').click(function(){
		if ($(this).attr('class') != 'active'){
			$('#sub1 ul').slideUp();
			$(this).next().slideToggle();
			$('#sub1 a').removeClass('active');		
			$(this).addClass('active');	  	  
		}
	});
	
	$('#sub2 > a').click(function(){
		if ($(this).attr('class') != 'active'){
			$('#sub2 ul').slideUp();
			$(this).next().slideToggle();
			$('#sub2 a').removeClass('active');		
			$(this).addClass('active');	  	  
		}
	});
	
	$('#sub3 > a').click(function(){
		if ($(this).attr('class') != 'active'){
			$('#sub3 ul').slideUp();
			$(this).next().slideToggle();
			$('#sub3 a').removeClass('active');		
			$(this).addClass('active');			  
		}
	});	
	
	
	$('a').click(function(){
		if( $(this).addClass('active') ){				
			 var r = $(this).find('input[type=radio]');
			  if($(r).is(":checked")){
				$(r).attr("checked", "");
			  }else{
				$(r).attr("checked", "checked");
			  }
		} //if
	});
	
});