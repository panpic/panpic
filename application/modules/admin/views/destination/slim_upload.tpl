<link rel="stylesheet" href="{$base_tlp_admin}/css/slim.min.css" />
<div class="form-group check-file">
    <label class="col-md-2 control-label" for="title">{$lable.image}</label>
    <div class="col-md-10 slim logo" data-label="{$lable.image}" data-force-min-size="false" data-min-size="48,23" style="width:150px;height:80px;margin-left:12px;">

        {if $data.cat_icon neq ''}<img src="{$dir_path}{$data.cat_icon}" alt="">{/if}
        <input class="form-control" id="path_image" name="path_image" type="file" value="">
        <span id="valid_path_image" class="red"></span>
    </div>
</div>

