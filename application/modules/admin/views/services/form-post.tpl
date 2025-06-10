<div class="row">
<div class="col-md-12">
    <label class="control-label" for="id_title_{$k}">{$lable.title} <span class="red">(*)</span></label>
    <input type="text" name="data[{$k}][title]" id="id_title_{$k}" class="form-control" value="{$data.title|stripslashes}" onkeyup="ChangeToSlugCustomer('id_title_{$k}', 'slug_{$k}');" required="required" />
    <p class="help-block">{$valid.title}</p>
</div>
<div class="col-md-12">
    <input type="text" name="data[{$k}][slug]" id="slug_{$k}" class="form-control" value="{$data.slug}" placeholder="Slug" />
    <p class="help-block">{$valid.slug}</p>
</div>
{**
<div class="col-md-12">
    <label class="col-md-1 control-label" for="title_2_{$k}">Icon</label>
    <div class="col-md-3">
        <input type="text" class="form-control" id="title_2_{$k}" name="data[{$k}][title_2]" value="{$data.title_2|stripslashes}">
    </div>
</div>
**}
<div class="col-md-12">
    <label class="control-label" for="short_{$k}">{$lable.short_description}</label>
    <textarea class="form-control" id="short_{$k}" name="data[{$k}][short]">{$data.short|stripslashes}</textarea>
</div>
<div class="col-md-12">  
   <label class="control-label" for="full_content_{$k}">{$lable.content}</label>
   <textarea class="form-control" id="full_content_{$k}" name="data[{$k}][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>		
</div>
<div class="col-md-12">
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