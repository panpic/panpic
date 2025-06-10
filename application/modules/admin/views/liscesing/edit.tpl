{include file="header.tpl"}
{include file="sidebar.tpl"}
<link rel="stylesheet" type="text/css" href="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.css" />
<script src="{$base_url}/ckeditor/ckeditor.js" charset="utf-8"></script>
<script src="{$base_url}/ckfinder/ckfinder.js" charset="utf-8"></script>

<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}

    <div class="innerLR">
        <form class="margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/add/" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="data[lang]" id="lang" value="{$data.lang}" />
            <input type="hidden" name="option" id="option" value="{$option}" />
            <input type="hidden" name="primary" id="primary" value="{$data.blog_id}" />
            <input type="hidden" name="old[path_image]" value="{$data.path_image}">
            <input type="hidden" name="old[image_id]" value="{$data.image_id}" />
            <div class="widget">
                <div class="widget-head">
                    <h4 class="heading">{$task}</h4>
                </div>
                <div class="widget-body">
                    <div class="row">
                    	<div class="col-md-9">
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
                            {include file="{$control}/form-post.tpl" k=$current_lang}
                        </div>
                        <div class="col-md-3">
                        	{include file="{$control}/right.tpl"}
                        </div>
                    </div><!-- // Row END -->
                    </div>
                    <div class="separator"></div>                    
                </div>
            </div><!-- // Widget END -->
        </form>
    </div>    
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"}

<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>
<script>
{literal}
$(document).ready (function(){ 
    var editor = CKEDITOR.replace('full_content_'+current_lang);
    CKFinder.setupCKEditor( editor, '/ckfinder/');

	$('#date_add').datetimepicker({format:'Y-m-d H:i'});
	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){ $(".alert").slideUp(500); }); 
    }, 2000);
	
	$('#btnAddBlog').click(function(e){ 
		var flag = 0;
		var errors = '';
		var id_title = $('#id_title').val();
		
		if(id_title == '') {
			flag = 1; errors = please_input+' '+lable_title +'<br />';
		}
		
		if(flag == 1) {
			$('#content-danger').html(errors);
			$('#modal-danger').modal('show');
		} else {
			$('#frm_data').submit();
		}
	});
});
{/literal}
</script>