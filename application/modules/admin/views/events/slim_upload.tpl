<link rel="stylesheet" href="{$base_tlp_admin}/css/slim.min.css" />
<label class="col-md-12 control-label" for="path_image">{$lable.image}</label>
<div class="col-md-12 slim logo" data-label="{$lable.image}" style='width:248px;height:158px;margin-left:12px;'>
    {if $data.path_image neq ''}
        <img src="{$link_upload}/{$data.path_image}" alt="">
    {/if}
    <input class="form-control" id="path_image" name="path_image" type="file" value="" accept="image/jpeg, image/png, image/git, image/webp, image/jpg">
    <span id="valid_path_image" class="red"></span>
</div>