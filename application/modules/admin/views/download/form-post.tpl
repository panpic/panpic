<div class="row">
    <div class="col-md-12">
        <label class="control-label col-md-3" for="id_title_{$k}">{$lable.download_file_name} <span class="red">(*)</span></label>
        <div class="col-md-9">
        <input type="text" name="data[{$k}][title]" id="id_title_{$k}" class="form-control" value="{$data.title|stripslashes}" onkeyup="ChangeToSlugCustomer('id_title_{$k}', 'slug_{$k}');" required="required" />
        <p class="help-block">{$valid.title}</p>
        </div>
    </div>
    <input type="hidden" name="data[{$k}][slug]" id="slug_{$k}" class="form-control" value="{$data.slug}" />

    {**
    <div class="col-md-12"> 
    	<label class="control-label col-md-3" for="id_short_{$k}">{$lable.download_stype_icon}</label>
        <div class="col-md-4">
    	<input type="text" name="data[{$k}][short]" id="id_short_{$k}" class="form-control" value="{$data.short|stripslashes}" />
        </div>
        <div class="col-md-4">
            <a href="https://fontawesome.com/icons?d=gallery&p=2&m=free" target="_blank"><u>Xem thêm mã icon</u></a>
        </div>
    </div>
    **}
    <div class="col-md-12" style="padding-top:20px;">
        <label class="control-label">{$lable.seo_title}</label>
        <input name="data[{$k}][seo_title]" id="seo_title_{$k}" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
        <p class="help-block italic font_12"></p>
    </div>
    <div class="col-md-12">
        <label class="control-label">{$lable.seo_desc}</label>
        <textarea name="data[{$k}][seo_description]" id="seo_description_{$k}" class="col-md-6 form-control">{$data.seo_description}</textarea>
        <p class="help-block"></p>
    </div>
</div>
