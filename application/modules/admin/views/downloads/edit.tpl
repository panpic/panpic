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
                            <div class="col-md-12">
                            <label class="control-label" for="primary">{$lable.title} <span class="red">(*)</span></label>
                                <input type="text" name="data[{$current_lang}][title]" id="id_title" class="form-control" value="{$data.title|stripslashes}" onkeyup="ChangeToSlug('id_title');" required="required" />
                                <p class="help-block">{$valid.title}</p>
                            </div>
                            <div class="col-md-12">
                            	<label class="control-label" for="slug">Slug</label>
                                <input type="text" name="data[{$current_lang}][slug]" id="slug" class="form-control" value="{$data.slug}" />
                                <p class="help-block">{$valid.slug}</p>
                            </div>
                         	<div class="col-md-12"> 
                               	<label class="control-label" for="short">{$lable.short_description}</label>
                                <textarea class="form-control" id="short" name="data[{$current_lang}][short]" onChange="hideFieldRequire('#valid_short)">{$data.short|stripslashes}</textarea>
                             </div>
                             <div class="col-md-12">  
                                 <label class="control-label" for="full_content">{$lable.content}</label>
                                 <textarea class="form-control" id="full_content" name="data[{$current_lang}][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>		
                             </div>
                             <div class="col-md-12">
                                <label class="control-label" >{$lable.seo_title}</label>
                                <input name="data[{$current_lang}][seo_title]" id="seo_title" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
                                <p class="help-block italic font_12"></p>
                             </div>
    						 <div class="col-md-12">
                                <label class="control-label">{$lable.seo_desc}</label>
                                <textarea name="data[{$current_lang}][seo_description]" id="seo_description" class="col-md-6 form-control">{$data.seo_description}</textarea>
                                <p class="help-block"></p>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                        	{include file="events/right.tpl"}
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

<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>
<script type="text/javascript">
{literal}
$(document).ready (function(){
    var editor = CKEDITOR.replace('full_content');
    CKFinder.setupCKEditor( editor, '/ckfinder/');

	$('#date_add').datetimepicker({format:'Y-m-d H:i'});
});
{/literal}
</script>
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script src="{$base_tlp_admin}/js/blog.js"></script>
