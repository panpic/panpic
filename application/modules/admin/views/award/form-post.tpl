<div class="row">
    <div class="col-md-3 text-right">
        <label class="control-label" for="id_title_{$k}">{$lable.fullname} <span class="red">(*)</span></label>
    </div>
    <div class="col-md-9">
        <input type="text" name="data[{$k}][title]" id="id_title_{$k}" class="form-control" value='{$data.title|stripslashes}' onkeyup="ChangeToSlugCustomer('id_title_{$k}', 'slug_{$k}');" required="required" />
        <p class="help-block">{$valid.title}</p>
    </div>
    <input type="hidden" name="data[{$k}][slug]" id="slug_{$k}" class="form-control" value="{$data.slug}" placeholder="Slug" />
</div>

<div class="row">
    <div class="col-md-3 text-right">
        <label class="control-label" for="short_{$k}">{$lable.department_construction}</label>
    </div>
    <div class="col-md-9">
        <input type="text" class="form-control" id="short_{$k}" name="data[{$k}][short]" onChange="hideFieldRequire('#valid_short)" value="{$data.short|stripslashes}">
    </div>
</div>
<div class="row">
    <div class="col-md-3 text-right">
        <label class="control-label" for="short_{$k}">{$lable.job_title}</label>
    </div>
    <div class="col-md-9">
        <input name="data[{$k}][seo_title]" id="seo_title_{$k}" class="form-control" value="{$data.seo_title}" class="form-control" />
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label class="control-label" for="full_content_{$k}">{$lable.content}</label>
        <textarea class="form-control" id="full_content_{$k}" name="data[{$k}][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>
    </div>
</div>