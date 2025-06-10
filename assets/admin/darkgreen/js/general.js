// include
function add_lang(){		
        var primary = $('#primary').val();
        var lang_value = $('#lang_value').val();			
        if(primary == '') {
                $('#smallModalLabel').html(smallModalLable); $('#smallModalContent').html(requiredName); $('#smallModal').modal('show'); $('#smallModal').on('hidden.bs.modal', function (e) { $('#primary').focus(); }); return false;
        }

        return true;
}

function isnumberic(s) {
        var str="01234556789";
        var i, l, ch;
        l = s.length;

        for(i=0; i<l; i++) 	{
                ch=s.charAt(i);
                if(str.indexOf(ch)== -1) return false;
        }

        return true;
}



function createXMLHttp() {

        if (typeof XMLHttpRequest != "undefined") {
                return new XMLHttpRequest(); //Mozilla Firefox, Safari, and Opera�
        } 
        else if (window.ActiveXObject) {

                var aVersions = [ "MSXML2.XMLHttp.5.0", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0","MSXML2.XMLHttp", "Microsoft.XMLHttp"];
                for (var i = 0; i < aVersions.length; i++) {
                        try {
                                var oXmlHttp = new ActiveXObject(aVersions[i]);
                                return oXmlHttp;
                        } catch (oError) {
                                //Do nothing
                        }
                 }
        } //end else
        throw new Error("XMLHttp object could be created.");
}

var request = createXMLHttp();



$(document).ready(function() { 

        // Users	
        $('#user_state').on('change keyup paste',function(){
                var state_id = $(this).val();
                citySelected(state_id);
        });	


        // Users Vip	
        $('#mem_vip').on('change keyup paste',function(){
                var mem_vip = $(this).val();

                if (mem_vip == 1 && $(this).is(':checked')) {
                        $('#dateofbirth').removeAttr("disabled");
                  } else {
                        $('#dateofbirth').attr("disabled", true);
                  }

        });	


        // Setting/General
        $('.btn_add_general').on('click', function(e) { //add multi general	
                var c_name = $(this).attr('name');

                // add data form
                $('#general_empty').find('#custom_type').val(c_name);		
                var action = $('#general_empty').find('form').attr('action');
                $('form').attr('action',action+"?b="+c_name);

                var my_append= $('#general_empty').html();
                $(this).closest('.widget-body').find('.add-multi').append(my_append);

                // empty form
                var old_url_append = $('#old_url_append').val();
        $('#general_empty').find('form').attr('action',old_url_append);
                $('#general_empty').find('#custom_type').val('');

                /*
                $(this).closest('.companies-multi').find('.company_name_person').val(company_name);		
                $('#id_personal_multi').on('click','.bt_remove_person_multi',function(){
                        $(this).closest('.purchase-product').remove();
                });
                */

        });



});




function delimg(url, type, id){
        param = 'type='+type;
        param += '&id='+id;

        request.open('post', base_url+url, false);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(param);		
        var status = request.responseText;

        if(status == 1) { 	
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
}



function citySelected(id) {
        $.ajax({
                type: "POST",
                url: base_url+"/registration/city/",
                async: false,		
                data: "id="+id,
                success: function(text){
                        $('#user_city').html(text);
                },
        });
}

// my function
function fadeContact(company_id) {			
        $("#cbx_contact").fadeOut();
        $('#cbx_contact').load( base_url_admin+"purchase/ajxcontact/?id="+company_id);	
        $("#cbx_contact").fadeIn();	
};

function fadeAddress(company_id) {
        $("#cbx_delivery").fadeOut();
        $('#cbx_delivery').load( base_url_admin+"purchase/axjdelivery/?id="+company_id);	
        $("#cbx_delivery").fadeIn();	
}

function roundUnitPrice(x){
        var n = parseFloat(x); 
        return Math.round(n * 100)/100;
}
