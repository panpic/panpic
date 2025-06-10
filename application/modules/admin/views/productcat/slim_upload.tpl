<link rel="stylesheet" href="{$base_tlp_admin}/css/slim.min.css" />
<div class="form-group check-file">
    <label class="col-md-4 control-label" for="title">{$lable.image}</label>
    <div class="col-md-4 slim logo" data-label="{$lable.image}" data-force-min-size="false" data-min-size="80,50" style='width:100px;height:70px;margin-left:12px;'>
        {if $data.cat_icon neq ''}<img src="{$link_upload}/{$data.cat_icon}" alt="">{/if}
        <input class="form-control" id="path_image" name="path_image" type="file" value="">
        <span id="valid_path_image" class="red"></span>
    </div>
    <div class="col-md-4">
    	(W x H = 200 x 140)
    </div>
</div>

