<div style="padding-top:10px;">
    <label class="control-label" for="primary">{$lable.category} (*)</label>
    <select name="data[category_id]" id="category_id" class="form-control">
        {$categories.cmb}
    </select>
    <p class="help-block">{$valid.category_id}</p>
</div>
<div class="row" style="padding-top:10px;">
    <label class="col-md-5 control-label" for="date_add">{$lable.date_add}</label>
    <div class="col-md-7">
    <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
    </div>
</div>
<div class="row" style="padding-top:10px;">
    <label class="control-label col-md-4" for="userfile">File tài liệu</label>
    <div class="col-md-8">
        <input type="file" name="userfile" id="userfile" value="" /> (file <= 256Mb)
        <span class="col-md-12 red">{$valid.file_error}</span>
    </div>
    <div class="col-md-10">
        {if $data.title_2 neq ''}
            <a href="{$base_url_admin}/download/downloadfile?id={$data.blog_id}" target="_blank">{$data.title_2|substr_filename}</a>
        {/if}
    </div>
</div>
<div class="col-md-12" style="padding-left:10px;">
    ({$allow_upload_file})
</div>
<div class="row" style="padding-top:10px;">
    {include file="{$control}/slim_upload.tpl"}
</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBlog" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>