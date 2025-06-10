{include file="header.tpl"}
{include file="sidebar.tpl"}

<link rel="stylesheet" href="{$base_tlp_admin}/css/custom.css" />
<div id="content">

{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

<form class="form-horizontal margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/processnested/" autocomplete="off">
<input type="hidden" name="option" id="option" value="{$option}" />
<input type="hidden" name="data[product_cat_id]" id="mcId" value="{$data.product_cat_id}" />

<div class="widget">
<div class="widget-head">
<h4 class="heading">{$task}</h4>
</div>
<div class="widget-body innerAll inner-2x">
    <div class="row innerLR">
        <div class="col-md-8">
    
            {if $msg neq ''} {include file="notes.tpl"} {/if}
    
            <div class="form-group">
                <label class="col-md-4 control-label" for="select2_1">{$lable.root}</label>
                <div class="col-md-8">
                    <select data-placeholder="Danh mục.." class="col-md-8" name="data[parents]" id="select2_1">
                            {$arrNested.cmb}
                    </select>
                    <p class="help-block">{$valid.cmbCat}</p>
                </div>
            </div>
    
            <div class="form-group">
                <label class="col-md-4 control-label" for="mcCategory">{$lable.category}(*)</label>
                <div class="col-md-8">
                    <div class="input-group">
                    <input type="text" name="data[cat_name]" id="mcCategory" value="{$data.cat_name}" class="form-control" placeholder="" />
                    <span class="help-block alert-danger">{$valid.mcCategory}</span>
                    <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Category Name"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div>
            {include file="productcat/slim_upload.tpl"}
            <div class="form-group">
                <label class="col-md-4 control-label" for="posts_no">Thứ tự</label>
                <div class="col-md-2">
                    <div class="input-group">
                    <input type="text" name="data[posts_no]" id="posts_no" value="{$data.posts_no}" class="form-control" />
                    </div>
                </div>
            </div>
            
        </div><!-- // Column END -->
    </div><!-- // Row END -->

		<div class="row">
				<hr />
		</div>
		<br clear="all" />
		<div class="row innerLR">
		<div class="col-md-10">
        	<div class="form-group">
            	<label class="col-sm-3 control-label" >{$lable.seo_title}</label>
                <div class="col-sm-8">
                    <input name="data[seo_title]" id="seo_title" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
                    <p class="help-block italic font_12"></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{$lable.seo_desc}</label>
                <div class="col-sm-8">
                    <textarea name="data[seo_description]" id="seo_description" class="col-md-6 form-control">{$data.seo_description}</textarea>
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    <div class="form-actions">
                        <button type="submit" id="btLang" class="btn btn-primary">
                            <i class="fa fa-check-circle"></i> 
                            {if $option eq 'edit'} {$lable.btn_edit} {else} {$lable.btn_save} {/if}
                        </button>
                    </div>									
                </div>
            </div>

		</div>

	</div>


</div>
<div class="separator"></div>                    
</div>
</div><!-- // Widget END -->
</form>
</div>    
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"}

<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-select/assets/lib/js/bootstrap-select.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-select/assets/custom/js/bootstrap-select.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/select2/assets/lib/js/select2.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/select2/assets/custom/js/select2.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/multiselect/assets/lib/js/jquery.multi-select.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/multiselect/assets/custom/js/multiselect.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>

<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/bang.js"></script>
