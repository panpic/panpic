{include file="header.tpl"}
{include file="sidebar.tpl"}
<link rel="stylesheet" type="text/css" href="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.css" />
<script src="{$base_url}/ckeditor/ckeditor.js" charset="utf-8"></script>
<script src="{$base_url}/ckfinder/ckfinder.js" charset="utf-8"></script>

<div id="content">
{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}
<div class="innerLR">
<div class="relativeWrap">
    <form class="margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/add/" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="option" id="option" value="{$option}" />
           
        <div class="col-md-9 l-r-0">
            <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
                <div class="widget-head">
                    <ul>
                        <li class="active">
                        	<a href="#tab1-2" class="glyphicons circle_plus" data-toggle="tab"><i></i><span>{$lable.promotion}</span></a>
                        </li>
                        {**
                        <li><a href="#tab2-2" class="glyphicons circle_plus" data-toggle="tab"><i></i><span><img src="{$base_url}/images/flag/gb.png" /></span><span>English</span></a>
                        </li>**}
                    </ul>
                </div><!-- // Tabs Heading END -->
                
                <div class="widget-body">
                    <div class="tab-content">
                    
                        <!-- Tab content -->
                        <div class="tab-pane active" id="tab1-2">
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
                            <div>
                            	<label class="control-label" for="primary">{$lable.title} <span class="red">(*)</span></label>
                                <input type="text" name="data[vi][title]" id="id_title" class="form-control" value="" onkeyup="ChangeToSlug('id_title');" required="required" />
                                <p class="help-block">{$valid.title}</p>
                            </div>
                            <div>
                            	<input type="text" name="data[vi][slug]" id="slug" class="form-control" value="{$data.slug}" placeholder="Slug" />
                                <p class="help-block">{$valid.slug}</p>
                            </div>
                         	<div> 
                            	<label class="control-label" for="short">{$lable.short_description}</label>
                                <textarea class="form-control" id="short" name="data[vi][short]" onChange="hideFieldRequire('#valid_short)">{$data.short|stripslashes}</textarea>
                             </div>
                             <div>  
                               <label class="control-label" for="full_content">{$lable.content}</label>
                               <textarea class="form-control" id="full_content" name="data[vi][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>		
                             </div>
                             <div>
                               <label class="control-label" >{$lable.seo_title}</label>
                               <input name="data[vi][seo_title]" id="seo_title" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
                               <p class="help-block italic font_12"></p>
                             </div>
    						 <div>
                               <label class="control-label">{$lable.seo_desc}</label>
                               <textarea name="data[vi][seo_description]" id="seo_description" class="col-md-6 form-control">{$data.seo_description}</textarea>
                               <p class="help-block"></p>
                            </div>
                        </div>
                        <!-- // Tab content END -->
                        {**
                        <div class="tab-pane" id="tab2-2">
                            <div>
                            	<label class="control-label" for="primary">{$lable.title} <span class="red">(*)</span></label>
                                <input type="text" name="data[en][title]" id="id_title_en" class="form-control" value="" maxlength="255" onkeyup="ChangeToSlugCustomer('id_title_en', 'slug_en');" />
                                <p class="help-block">{$valid.title}</p>
                            </div>
                            <div>
                            	<input type="text" name="data[en][slug]" id="slug_en" class="form-control" value="{$data.slug}" placeholder="Slug" />
                                <p class="help-block">{$valid.slug}</p>
                            </div>
                         	<div> 
                            	<label class="control-label" for="short">{$lable.short_description}</label>
                                <textarea class="form-control" id="short" name="data[en][short]" onChange="hideFieldRequire('#valid_short)">{$data.short|stripslashes}</textarea>
                             </div>
                             <div>  
                               <label class="control-label" for="full_content_en">{$lable.content}</label>
                               <textarea class="form-control" id="full_content_en" name="data[en][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>		
                             </div>
                             <div>
                               <label class="control-label" >{$lable.seo_title}</label>
                               <input name="data[en][seo_title]" id="seo_title" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
                               <p class="help-block italic font_12"></p>
                             </div>
    						 <div>
                               <label class="control-label">{$lable.seo_desc}</label>
                               <textarea name="data[en][seo_description]" id="seo_description" class="col-md-6 form-control">{$data.seo_description}</textarea>
                               <p class="help-block"></p>
                            </div>
                        </div>**}
                        
                    <div class="separator"></div> 
                    <div class="separator"></div>     
                    </div><!--.tab-content-->
                </div><!--.widget-body-->
            </div><!--.widget-->
            
        </div><!--.col-md-9-->
        <div class="col-md-3 widget">
        	{include file="events/right.tpl"}
        </div><!--.col-md-3-->
        
   </form>     
</div>
</div><!--.innerLR-->   
</div><!--#content-->
{include file="footer.tpl"}
{include file="script_validator.tpl"}
{include file="modal_small_danger.tpl"}

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
<script>
	var please_input = "{$lable.please_input}";
	var lable_title = "{$lable.title}";
</script>
<script src="{$base_tlp_admin}/js/blog.js"></script>