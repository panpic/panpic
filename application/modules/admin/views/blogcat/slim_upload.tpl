<link rel="stylesheet" href="{$base_tlp_admin}/css/slim.min.css" />
<div class="check-file">
    <label class="col-md-4 control-label" for="title">{$lable.image}</label>
    <div class="col-md-8 slim logo" data-label="{$lable.image}" data-force-min-size="false" data-min-size="80,50" style="width:180px;height:120px;margin-left:12px;">
        {if $data.cat_icon neq ''}
            <img src="{$link_upload}/{$data.cat_icon}" alt="">
        {/if}
        <input class="form-control" id="path_image" name="path_image" type="file" value="" accept="image/jpeg, image/png, image/git, image/webp, image/jpg">
        <span id="valid_path_image" class="red"></span>
    </div>
</div>

