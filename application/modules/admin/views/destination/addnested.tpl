{include file="header.tpl"}
{include file="sidebar.tpl"}

<link rel="stylesheet" href="{$base_tlp_admin}/css/custom.css" />

<div id="content">
{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

<form class="form-horizontal margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/processnested/" autocomplete="off" enctype="multipart/form-data">

<input type="hidden" name="option" id="option" value="{$option}" />
<input type="hidden" name="data[tour_destination_id]" id="mcId" value="{$data.tour_destination_id}" />
<input type="hidden" name="old[path_image]" value="{$data.cat_icon}">

<div class="widget">
<div class="widget-head">
    <h4 class="heading">{$task}</h4>
</div>

<div class="widget-body innerAll inner-2x">
<div class="row innerLR">
	<div class="col-md-12">

		{if $msg neq ''} {include file="notes.tpl"} {/if}

        <div class="form-group">
            <label class="col-md-2 control-label" for="primary">{$lable.root}</label>
            <div class="col-md-8">
                <select data-placeholder="Danh mục.." class="col-md-8" name="data[parents]" id="select2_1">
                    {$arrNested.cmb} 
                </select>
                <p class="help-block">{$valid.cmbCat}</p>
            </div>
	   </div>


            <div class="form-group">
                <label class="col-md-2 control-label" for="mcCategory">Tỉnh/TP hoặc Tên đại lý(*)</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="data[cat_name]" id="mcCategory" value="{$data.cat_name}" class="form-control" onkeyup="ChangeToSlug('mcCategory');" />
                        <span class="help-block alert-danger">{$valid.mcCategory}</span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Nhập tên Tỉnh/TP khu vực hoặc tên Đại Lý"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="slug">Slug</label>
                <div class="col-md-8">
                    <input type="text" name="data[slug]" id="slug" class="form-control" value="{$data.slug}" />
                    <p class="help-block">{$valid.slug}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="cat_name_unicode">{$lable.address}</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="data[cat_name_unicode]" id="cat_name_unicode" value="{$data.cat_name_unicode}" class="form-control" placeholder="" />
                        <span class="help-block alert-danger">{$valid.cat_name_unicode}</span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Nếu là Đại lý thì nhập địa chỉ"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="link_gmap">Link google map</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="data[link_gmap]" id="link_gmap" value="{$data.link_gmap}" class="form-control" placeholder="" />
                        <span class="help-block alert-danger">{$valid.link_gmap}</span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Nếu là Đại lý thì nhập link google map"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="cat_name_lable">{$lable.phone}</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="data[cat_name_lable]" id="cat_name_lable" value="{$data.cat_name_lable}" class="form-control" placeholder="" />
                        <span class="help-block alert-danger"></span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Nếu là Đại lý thì nhập số điện thoại"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="starting_latitude">{$lable.latitude} (*)</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="data[starting_latitude]" id="starting_latitude" value="{$data.starting_latitude}" class="form-control" placeholder="" />
                        <span class="help-block alert-danger">{$valid.starting_latitude}</span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Map latitude"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                	<a href="http://www.latlong.net/place/ho-chi-minh-city-vietnam-333.html" target="_blank">http://www.latlong.net</a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="starting_longtitude">{$lable.longtitude} (*)</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="data[starting_longtitude]" id="starting_longtitude" value="{$data.starting_longtitude}" class="form-control" placeholder="" />
                        <span class="help-block alert-danger">{$valid.starting_longtitude}</span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Map longtitude"><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div>
          
            {include file="destination/slim_upload.tpl"}
            
			<!--
            <div class="form-group">
                <label class="col-md-2 control-label" for="cat_icon_class">Show class</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="data[cat_icon_class]" id="cat_icon_class" value="{$data.cat_icon_class}" class="form-control" />
                        <span class="help-block alert-danger"></span>
                        <span class="input-group-addon" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Big image 'col-2-1' Small image 'col-1-1' "><i class="fa fa-question-circle"></i></span>
                    </div>
                </div>
            </div> -->


            <div class="form-group">
                <label class="col-md-2 control-label" for="cat_icon_class">Show default</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="checkbox" name="data[home]" id="home_check" value="1" {if $data.home eq 1} checked="checked"{/if} /> (Checked province show defaul)
                        <span class="help-block alert-danger"></span>
                    </div>
                </div>
            </div>

	</div><!-- // Column END -->
</div><!-- // Row END -->

    <div class="row"><hr /></div>
    <br clear="all" />
    <div class="row innerLR">
    <div class="col-md-10">

        <div class="form-group">
            <label class="col-md-1 control-label" for="lang_value"> &nbsp; </label>
            <div class="col-md-11">
                {include file="destination/seo.tpl"}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-6">
                <div class="form-actions">
                    <button type="submit" id="btLang" class="btn btn-primary">
                        <i class="fa fa-check-circle"></i> 
                        {if $option eq 'edit'} {$lable.edit} {else} {$lable.btn_save} {/if}
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

<script src="{$base_tlp_admin}/js/bang.js"></script>
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>