<div class="form-group">
    <label class="col-sm-2 control-label" >{$lable.seo_title}</label>
    <div class="col-sm-10">
        <input name="data[seo_title]" id="seo_title" class="form-control" value="{$data.seo_title}" class="form-control" maxlength="80" />
        <p class="help-block italic font_12"></p>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{$lable.seo_desc}</label>
    <div class="col-sm-10">
        <textarea name="data[seo_description]" rows="3" id="seo_description" class="col-md-6 form-control">{$data.seo_description}</textarea>
        <p class="help-block"></p>
    </div>
</div>