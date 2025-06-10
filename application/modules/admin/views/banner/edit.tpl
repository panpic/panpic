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
           <input type="hidden" name="primary" id="primary" value="{$data.banner_id}" />
           <input type="hidden" name="old[path_image]" value="{$data.banner_file}" />
           
            <div class="widget">
                <div class="widget-head">
                    <h4 class="heading">{$task}</h4>
                </div>
                
                <div class="widget-body">
                    <div class="row">
                    	        
                    	<div class="col-md-9">
                            
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
                            <div class="col-md-12">
                            <label class="control-label" for="id_title">{$lable.title}</label>
                                <input type="text" name="data[{$current_lang}][title]" id="id_title" class="form-control" value="{$data.title|stripslashes}" required="required" />
                                <p class="help-block">{$valid.title}</p>
                            </div>
                            <div class="col-md-12"> 
                               	<label class="control-label" for="short">{$lable.short_description}</label>
                                <textarea class="form-control" id="short" name="data[{$current_lang}][short]">{$data.short|stripslashes}</textarea>
                             </div>
                            <div class="col-md-12">
                                <label class="control-label" for="content">{$lable.content}</label>
                                <textarea class="form-control" name="data[{$current_lang}][content]">{$data.content|stripslashes}</textarea>
                            </div>
                            <div class="col-md-12">  
                                <label class="control-label" for="link_click">Link click</label>
                                <input type="text" name="data[{$current_lang}][link_click]" id="link_click" class="form-control" value="{$data.link_click}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                        	{include file="banner/right.tpl"}
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
	$('#date_add').datetimepicker({format:'Y-m-d H:i'});
});
{/literal}

</script>
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/banner.js?ver=1.0.1"></script>
