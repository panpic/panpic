
var NS4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) < 5);


function delOptionJquery(theSel, theIndex){ 
	var selLength = theSel.length;
	if(selLength >0) theSel.options[theIndex] = null;
}

function addOptionJquery(theSelFrom, theSelTo){
	
	var selLength = theSelFrom.length;
	var flag = 0;
	
	var count = $("#"+theSelTo+" option").size();
	if(count >= 3) { alert("Tối đa 3 danh mục"); return; }
			
	var node = $("#tree").dynatree("getActiveNode");
	if( node ){		
	
		for(i=selLength-1; i>=0; i--){
			selectedKey = theSelFrom.options[i].value;
			if(selectedKey == node.data.key){
				flag = 1;
				alert("Danh mục đã được chọn !"); return;
			}				
		}
		
		if(flag == 0){
			node.remove(); //alert(node.data.key);
			$('#'+theSelTo).append('<option value="'+node.data.key+'" selected="selected">'+node.data.title+'</option>');
		}
		
	}else{
		alert("Bạn phải chọn ít nhất một danh mục"); return;
	}   
}


function addNTree(treeId, theSelFrom, theSelTo){
	
	var selLength = theSelFrom.length;
	var flag = 0;
	
	var count = $("#"+theSelTo+" option").size();
	if(count >= 3) { alert("Tối đa 3 danh mục"); return; }
			
	var node = $("#"+treeId).dynatree("getActiveNode");
	if( node ){		
	
		for(i=selLength-1; i>=0; i--){
			selectedKey = theSelFrom.options[i].value;
			if(selectedKey == node.data.key){
				flag = 1;
				alert("Danh mục đã được chọn !"); return;
			}				
		}
		
		if(flag == 0){
			node.remove(); 
			$('#'+theSelTo).append('<option value="'+node.data.key+'" selected="selected">'+node.data.title+'</option>');
		}
		
	}else{
		alert("Bạn phải chọn ít nhất một danh mục"); return;
	}   
}

function moveNTree(treeId,theSelFrom, theSelTo){
	
	var selLength = theSelFrom.length;
	var selectedText = new Array();
	var selectedValues = new Array();
	var selectStatus = false;
	var selectedCount = 0;
		
	// Find the selected Options in reverse order
	// and delete them from the 'from' Select.
	for(i = selLength-1; i >= 0; i--){
		if(theSelFrom.options[i].selected){
			selectedText[selectedCount] = theSelFrom.options[i].text;
			selectedValues[selectedCount] = theSelFrom.options[i].value;
			delOptionJquery(theSelFrom, i);
			
			// Sample: add an hierarchic branch using code.
			// This is how we would add tree nodes programatically
			var rootNode = $("#"+treeId).dynatree("getRoot");
			var childNode = rootNode.addChild({
				title: selectedText[selectedCount],
				key: selectedValues[selectedCount],
				tooltip: "Remove select",
				isFolder: false
			});
							
			selectedCount ++;
		}
	}
  
	//if(NS4) history.go(0);
}

function moveOptionJquery(theSelFrom, theSelTo){
	
	var selLength = theSelFrom.length;
	var selectedText = new Array();
	var selectedValues = new Array();
	var selectStatus = false;
	var selectedCount = 0;
		
	// Find the selected Options in reverse order
	// and delete them from the 'from' Select.
	for(i = selLength-1; i >= 0; i--){
		if(theSelFrom.options[i].selected){
			selectedText[selectedCount] = theSelFrom.options[i].text;
			selectedValues[selectedCount] = theSelFrom.options[i].value;
			delOptionJquery(theSelFrom, i);
			
			// Sample: add an hierarchic branch using code.
			// This is how we would add tree nodes programatically
			var rootNode = $("#tree").dynatree("getRoot");
			var childNode = rootNode.addChild({
				title: selectedText[selectedCount],
				key: selectedValues[selectedCount],
				tooltip: "Remove select",
				isFolder: false
			});
							
			selectedCount ++;
		}
	}
  
	//if(NS4) history.go(0);
}


function selectAllOptionJquery(selId){   
	var selObj = document.getElementById(selId);
	for(var i=0; i < selObj.options.length; i++)
		selObj.options[i].selected = true;
}