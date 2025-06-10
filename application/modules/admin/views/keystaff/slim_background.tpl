<div class="form-group check-file">
    <label class="col-md-2 control-label" for="title">{$lable.background} </label>
    <div class="col-md-10 slim background" data-label="Drop your background here" data-ratio="16:9" style="width:64%; min-height:200px;margin-left:12px">
        {if $data.background_url neq ''}
            {assign var=img_file_exist value="$dir_path/`$data.background_url`"}
            {if $img_file_exist|image_exist}
                <img src="{$dir_thumb}{$data.background_url}" alt="">
            {/if}
        {/if}
        <input class="form-control" id="background_url" name="background_url" type="file" value="">
        <span id="valid_background_url" class="red"></span>
    </div>
</div>