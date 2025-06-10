<div class="row">
<div class="col-md-12">
    <label class="control-label" for="id_title_{$k}">{$lable.portfolio_name} <span class="red">(*)</span></label>
    <input type="text" name="data[{$k}][title]" id="id_title_{$k}" class="form-control" value="{$data.title|stripslashes}" onkeyup="ChangeToSlugCustomer('id_title_{$k}', 'slug_{$k}');" required="required" />
    <p class="help-block">{$valid.title}</p>
</div>
<div class="col-md-12">
    <input type="text" name="data[{$k}][slug]" id="slug_{$k}" class="form-control" value="{$data.slug}" placeholder="Slug" />
    <p class="help-block">{$valid.slug}</p>
</div>
</div>
<div class="row">
    <label class="col-md-2 control-label" for="id_title_2_{$k}">Title H1 <span class="red">(*)</span></label>
    <div class="col-md-10">
        <input type="text" name="data[{$k}][title_2]" id="id_title_2_{$k}" class="form-control" value="{$data.title_2|stripslashes}" required="required" />
        <p class="help-block">{$valid.title_2}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <textarea class="form-control" id="full_content_{$k}" name="data[{$k}][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>
    </div>
</div>
<div class="row">
{include file="portfolio/portfolio_fields.tpl"}
</div>
<div class="row">
<div class="col-md-12">
    <label class="control-label" >{$lable.seo_title}</label>
    <input name="data[{$k}][seo_title]" id="seo_title" value="{$data.seo_title|stripslashes}" class="form-control" maxlength="80" />
    <p class="help-block italic font_12"></p>
</div>
<div class="col-md-12">
    <label class="control-label">{$lable.seo_desc}</label>
    <textarea name="data[{$k}][seo_description]" id="seo_description" class="col-md-6 form-control">{$data.seo_description|stripslashes}</textarea>
    <p class="help-block"></p>
</div>
</div>