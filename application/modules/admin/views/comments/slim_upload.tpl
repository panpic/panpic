<link rel="stylesheet" href="{$base_tlp_admin}/css/slim.min.css" />
<div class="form-group check-file">
<label class="col-md-4 control-label" for="title">{$lable.image}</label>
<div class="col-md-8 slim logo" data-label="{$lable.image}" data-min-size="0,0" data-ratio="850:520" style='width:150px;height:100px;margin-left:12px;'>
    {if $data.path_image neq ''}
        <img src="{$link_upload}/{$data.path_image}" alt="">
    {/if}
    <input class="form-control" id="path_image" name="path_image" type="file" value="">
    <span id="valid_path_image" class="red"></span>
</div>
</div>

