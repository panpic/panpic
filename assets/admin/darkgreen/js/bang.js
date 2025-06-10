// bang define


function delimg(url, type, id){
	alert(base_url+url);
	$.ajax({
		type: "POST",
		url: base_url+url,
		async: false,		
		data: 'type='+type+'&id='+id,
		success: function(text){
			
			if(text == 1) { 	
				if(type == 'small'){
					id_file = 'oldFileSmallImg';
					id_content = 'id_small'
				}else {
					id_file = 'oldFileBigImg';
					id_content = 'id_big'
				}		
				
				document.getElementById(id_file).innerHTML = ""; 
				document.getElementById(id_content).innerHTML = "";
			}
			
		},
	});
	
}


