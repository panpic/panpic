<div style="padding-top:10px;">
    <label class="control-label" for="category_id">{$lable.category} (*)</label>
    <select name="data[category_id]" id="category_id" class="form-control">
        {foreach from=$categories item=cat}
        	<option value="{$cat.banner_cat_id}" {if $data.category_id eq $cat.banner_cat_id} selected="selected"{/if}> {$cat.banner_cat}</option>
        {/foreach}
    </select>
    <p class="help-block">{$valid.category_id}</p>
</div>
<div>
<div>
    <label class="col-md-5 control-label" for="date_add">{$lable.date_add}</label>
    <div class="col-md-7 l-r-0">
    <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
    </div>
</div>
<div>         
{include file="banner/slim_upload.tpl"}
</div>
<div>
{**
<div>
    <label class="col-md-12 control-label" for="banner_clip">Youtube clip</label>
    <div class="col-md-12 r-0">
    <input type="text" name="data[banner_clip]" id="banner_clip" class="form-control" value="{$data.banner_clip}" />
    </div>
</div>**}
</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBanner" class="btn btn-primary"><i class="fa fa-check-circle"></i>	{$lable.btn_save}</button>
</div>
