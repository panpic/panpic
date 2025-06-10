<div style="padding-top:10px;">
    <label class="control-label" for="primary">{$lable.category} (*)</label>
    <select name="data[category_id]" id="category_id" class="form-control">
        {$categories.cmb}
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
{*
<div>
    <label class="col-md-6 control-label" for="admin_verify">{$lable.admin_verify}</label>
    <div class="col-md-6">
    <input type="checkbox" name="data[admin_verify]" id="admin_verify" class="form-control" value="{$ADMIN_BLOG_VERIFY}" {if $data.admin_verify eq $ADMIN_BLOG_VERIFY} checked="checked"{/if} />
    </div>
</div>*}
<input type="hidden" name="data[admin_verify]" id="admin_verify" value="1" />
<div>         
{include file="products/slim_upload.tpl"}
<div class="top-10">
    <label class="col-md-3 control-label" for="product_price">{$lable.price}</label>
    <div class="col-md-9">
    	<input type="text" name="data[product_price]" id="product_price" class="form-control" value="{$data.product_price}" />
    </div>
</div>
<div class="top-10">
    <label class="col-md-3 control-label" for="product_sale_percent">{$lable.product_sale}</label>
    <div class="col-md-7">
    	<input type="text" name="data[product_sale_percent]" id="product_sale_percent" class="form-control" value="{$data.product_sale_percent}" />
    </div>
    <div class="col-md-1">%</div>
</div>
<div class="top-10">
    <label class="col-md-3 control-label" for="sku">SKU</label>
    <div class="col-md-9">
        <input type="text" name="data[sku]" id="sku" class="form-control" value="{$data.sku}" />
    </div>
</div>
<div class="top-10">
    <label class="col-md-3 control-label" for="brand">Brand</label>
    <div class="col-md-9">
        <input type="text" name="data[brand]" id="brand" class="form-control" value="{$data.brand}" />
    </div>
</div>
<div class="top-10">
    <label class="col-md-6 control-label" for="hot_status">{$lable.product_hot}</label>
    <div class="col-md-6">
    <input type="checkbox" name="data[hot_status]" id="hot_status" class="form-control" value="1" {if $data.hot_status eq 1} checked="checked"{/if} />
    </div>
</div>
<div class="top-10">
    <label class="col-md-6 control-label" for="home_status">{$lable.show_home}</label>
    <div class="col-md-6">
    <input type="checkbox" name="data[vi][home_status]" id="home_status" class="form-control" value="1" {if $data.home_status eq 1} checked="checked"{/if} />
    </div>
</div>

</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBlog" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>
