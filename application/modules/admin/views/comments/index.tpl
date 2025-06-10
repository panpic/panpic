{include file="header.tpl"}
{include file="sidebar.tpl"}
<link rel="stylesheet" type="text/css" href="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.css" />
<script src="{$base_url}/ckeditor/ckeditor.js" charset="utf-8"></script>
<script src="{$base_url}/ckfinder/ckfinder.js" charset="utf-8"></script>

<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}

    <div class="innerLR">
        
        <form class="form-horizontal margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/add/" autocomplete="off" enctype="multipart/form-data">
	      <input type="hidden" name="option" id="option" value="{$option}" />
           <input type="hidden" name="primary" id="primary" value="{$data.id}" />
           <input type="hidden" name="old[path_image]" value="{$data.path_image}">
           <input type="hidden" name="old[image_id]" value="{$data.image_id}" />
           
            <div class="widget">
                <div class="widget-head">
                    <h4 class="heading">{$task}</h4>
                </div>
                
                <div class="widget-body innerAll inner-2x">
                    <div class="row innerLR">
                        <div class="col-md-12">
							
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
			    
                            <div>
                                <label class="col-md-2 control-label" for="primary">{$lable.title} (*)</label>
                                <div class="col-md-10">
                                    <input type="text" name="data[title]" id="id_title" class="form-control" value="{$data.title|stripslashes}" maxlength="150" onkeyup="ChangeToSlug('id_title');" />
                                    <p class="help-block">{$valid.title}</p>
                                </div>
                           </div>
                           <div>
                                <label class="col-md-2 control-label" for="slug">Slug</label>
                                <div class="col-md-10">
                                    <input type="text" name="data[slug]" id="slug" class="form-control" value="{$data.slug}" />
                                    <p class="help-block">{$valid.slug}</p>
                                </div>
                           </div>
                      </div>
                      <div class="col-md-12">
                      	<div class="row">          
                            <div class="col-md-6">
                            	<div>
                                    <label class="col-md-4 control-label" for="primary">{$lable.category} (*)</label>
                                    <div class="col-md-8">
                                        <select name="data[category]" id="category" class="form-control">
                                            {$categories.cmb}
                                        </select>
                                       <p class="help-block">{$valid.category}</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="col-md-4 control-label" for="date_add">{$lable.date_add}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
                                    </div>
                           	    </div>
                                <div>
                                	<label class="col-md-4 control-label" for="admin_verify">{$lable.admin_verify}</label>
                                    <div class="col-md-1">
                                        <input type="checkbox" name="data[admin_verify]" id="admin_verify" class="form-control" value="{$ADMIN_BLOG_VERIFY}" {if $data.admin_verify eq $ADMIN_BLOG_VERIFY} checked="checked"{/if} />
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-6">         
                           {include file="blogs/slim_upload.tpl"}
                           </div>
                       </div>    
                     </div>
                     <div class="col-md-12">           
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="short">{$lable.short_description}</label>
                                <div class="col-md-10">
                                   <textarea class="form-control" id="short" name="data[short]" onChange="hideFieldRequire('#valid_short)">{$data.short|stripslashes}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="full_content">{$lable.content}</label>
                                <div class="col-md-10">
                                   <textarea class="form-control" id="full_content" name="data[content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>		
                                </div>
                           </div>
						   	
                           <div class="form-group">
                               <label class="col-sm-2 control-label" >{$lable.seo_title}</label>
                                <div class="col-sm-10">
                                    <input name="data[seo_title]" id="seo_title" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
                                    <p class="help-block italic font_12"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{$lable.seo_desc}</label>
                                <div class="col-sm-10">
                                    <textarea name="data[seo_description]" id="seo_description" class="col-md-6 form-control">{$data.seo_description}</textarea>
                                    <p class="help-block"></p>
                                </div>
                            </div>
						</div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                    <div class="form-actions">
                                        <button type="submit" id="btLang" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.save}</button>
                                    </div>									
                                </div>
                            </div>                           
                           
                        </div><!-- // Column END -->
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

<script type="text/javascript">
    CKEDITOR.replace('full_content');
</script>
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>
<script>
{literal}
	$('#date_add').datetimepicker({format:'Y-m-d H:i'});
{/literal}
</script>
