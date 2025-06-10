{include file="header.tpl"}
{include file="sidebar.tpl"}
<script src="{$base_url}/ckeditor/ckeditor.js" charset="utf-8"></script>
<script src="{$base_url}/ckfinder/ckfinder.js" charset="utf-8"></script>

<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}

    <div class="innerLR">
    
	<form class="form-horizontal margin-none" id="fpages" name="fpages" method="post" autocomplete="off">
	<input type="hidden" value="{$data->page_id}" name="page_id" id="page_id" />
	<input type="hidden" value="{$langp}" id="langp" />
    <input type="hidden" id="lang" name="lang" value="{$current_lang}" />
	<div class="widget">
		<div class="widget-head">
			<h4 class="heading">{$lable.add_page}</h4>
		</div>
		<div class="widget-body innerAll inner-2x">
			<div class="row innerLR">
				<div class="col-md-12">
                	{if $alert neq ''} {include file="notes.tpl"} {/if}
					<div class="form-group">
						<label class="col-md-2 control-label" for="page_cat">{$lable.page_cat} (*)</label>
						<div class="col-md-4">
							<select class="form-control" id="page_cat" name="page_cat" data-pagecatrequired="{$lable.page_cat_required}">
							<option value="">---</option>
							{foreach from=$page_catArray key = k item=v}
							<option {if $data->page_cat eq $k}selected {/if}value="{$k}">{$v}</option>
							{/foreach}
							</select>
							<span class="error red">{form_error('page_cat')}</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="page_title">{$lable.title} (*)</label>
						<div class="col-md-10">
							<input class="form-control" id="page_title" name="page_title" type="text" data-pagetitlerequired="{$lable.page_title_required}" value="{$data->page_title}" onkeyup="changeToNameUnicode('page_title', 'page_slug');">
							<span class="error red">{form_error('page_title')}</span>
                            <span class="error red">{form_error('page_title_exist')}</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="page_slug">{$lable.page_slug}</label>
						<div class="col-md-10">
							<input class="form-control" id="page_slug" name="page_slug" type="text" readonly value="{$data->page_slug}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="lang">{$lable.short_description}</label>
						<div class="col-md-10">
							<textarea rows="3" class="form-control" name="page_short" id="page_short">{$data->page_short}</textarea>
						</div>
					</div>
				</div><!-- // Column END -->
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-2 control-label" for="lang">{$lable.content}</label>
						<div class="col-md-10">							
							<textarea rows="11" class="form-control" name="page_detail" id="page_detail">{$data->page_detail}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="lang">SEO Title</label>
						<div class="col-md-9">
							<input class="form-control" name="seo_title" id="seo_title" value="{$data->seo_title}" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="lang">SEO Description</label>
						<div class="col-md-9">
							<input class="form-control" name="seo_description" id="seo_description" value="{$data->seo_description}" />
						</div>
					</div>
				</div>
                
                <div class="separator"></div>
                <div class="col-md-4 col-md-push-2">
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {$lable.btn_save}</button>
                    <a href="{$base_url_admin}/pages" class="btn btn-default"><i class="fa fa-times"></i> {$lable.cancel}</a>
                </div>
                </div>
            
			</div><!-- // Row END -->
			
		</div>
	</div><!-- // Widget END -->
</form>

</div>    
</div>

{include file="footer.tpl"}
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript">
    var editor = CKEDITOR.replace('page_detail');
	CKFinder.setupCKEditor( editor, '/ckfinder/');

	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
</script>