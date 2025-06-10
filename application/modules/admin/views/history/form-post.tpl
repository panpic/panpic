<div class="row">
<div class="col-md-12">
    <label class="control-label" for="primary">{$lable.year} <span class="red">(*)</span></label>
    <input type="text" name="data[{$k}][title]" id="id_title_{$k}" class="form-control" value="{$data.title|stripslashes}" onkeyup="ChangeToSlugCustomer('id_title_{$k}', 'slug_{$k}');" required="required" />
    <p class="help-block">{$valid.title}</p>
</div>
<div class="col-md-12">
    <input type="hidden" name="data[{$k}][slug]" id="slug_{$k}" class="form-control" value="{$data.slug}" placeholder="Slug" />
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <textarea class="form-control" id="full_content_{$k}" name="data[{$k}][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>
    </div>
</div>