
<input type="hidden" name="data[category_id]" id="category_id" value="{$category_id}" />
<input type="hidden" name="data[admin_verify]" id="admin_verify" value="1" />
<div>
    <label class="col-md-5 control-label" for="date_add">{$lable.date_add}</label>
    <div class="col-md-7 l-r-0">
    <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
    </div>
</div>

<div>         
{include file="events/slim_upload.tpl"}
</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBlog" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>
