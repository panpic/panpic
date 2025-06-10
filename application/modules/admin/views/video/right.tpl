{**<div style="padding-top:10px;">
    <label class="control-label" for="primary">{$lable.category} (*)</label>
    <select name="data[category_id]" id="category_id" class="form-control">
        {$categories.cmb}
    </select>
    <p class="help-block">{$valid.category_id}</p>
</div>**}

<input type="hidden" name="data[category_id]" id="category_id" value="{$category_id}" />
<div>
    <label class="col-md-5 control-label" for="date_add">{$lable.date_add}</label>
    <div class="col-md-7 l-r-0">
    <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
    </div>
</div>
{**
<div>
    <label class="col-md-6 control-label" for="admin_verify">{$lable.admin_verify}</label>
    <div class="col-md-6">
    <input type="checkbox" name="data[admin_verify]" id="admin_verify" class="form-control" value="{$ADMIN_BLOG_VERIFY}" {if $data.admin_verify eq $ADMIN_BLOG_VERIFY} checked="checked"{/if} />
    </div>
</div>
**}
<div>         
{include file="testimonial/slim_upload.tpl"}
</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBlog" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>
