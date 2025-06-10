<form class="margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/gallery?album={$album.blog_id}&id={$data.id}&option={$option}" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="option" id="option" value="{$option}" />
<input type="hidden" name="primary" id="primary" value="{$data.id}" />
<input type="hidden" name="old[path_image]" value="{$data.path_image}">
<input type="hidden" name="old[image_id]" value="{$data.image_id}" />

<div style="padding-top:10px;">
<div>
    <label class="col-md-5 control-label" for="date_add">{$lable.date_add}</label>
    <div class="col-md-7 l-r-0">
    <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
    </div>
</div>
<div>         
{include file="album/slim_upload.tpl"}
</div>
<div style="padding-top:10px;">
<div class="col-md-12 r-0">
    <input type="text" name="data[title]" id="title" class="form-control" value="{$data.title}" placeholder="{$lable.title}" />
</div>
</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddGallery" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>
</form>