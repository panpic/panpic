<div class="form-group {if $valid.seo_title neq ''} has-error {/if}">

	<label class="col-sm-2 control-label" >{$lable.seo_title.value}</label>
	<div class="col-sm-8">
		<input name="data_seo[seo_title]" id="seo_title" class="form-control" value="{$dataSeo.seo_title}" class="form-control" maxlength="80" />
		<p class="help-block italic font_12">{if $valid.seo_title eq ''}{$lable.seo_title_note.value}{else}{$valid.seo_title}{/if}</p>
	</div>
	
</div>
<div class="form-group {if $valid.seo_key neq ''} has-error {/if}">
	<label class="col-sm-2 control-label">{$lable.seo_key.value}</label>
	<div class="col-sm-8">
		<input name="data_seo[seo_key]" id="seo_key" class="form-control" value="{$dataSeo.seo_key}" class="form-control" maxlength="80" />
		<p class="help-block italic font_12">{if $valid.seo_key eq ''}{$lable.seo_key_note.value}{else}{$valid.seo_key}{/if}</p>
	</div>	
</div>
<div class="form-group {if $valid.seo_desc neq ''} has-error {/if}">
	<label class="col-sm-2 control-label">{$lable.seo_desc.value}</label>
	<div class="col-sm-8">
		<textarea name="data_seo[seo_desc]" id="seo_desc" class="col-md-6 form-control">{$dataSeo.seo_desc}</textarea>
		<p class="help-block">{$valid.seo_desc}</p>
	</div>
	
</div>