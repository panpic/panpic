{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<ul class="nav nav-tabs mb-5" role="tablist">
				{foreach from=$menu_document item=cc}
				<li class="nav-item" role="presentation">
					<a class="nav-link {if $cc.post_cat_id eq $category.post_cat_id}active{/if}" href="{$cc.cat_slug|url_document_cat}">{$cc.cat_name}</a>
				</li>
				{/foreach}
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1-nav" role="tabpanel" aria-labelledby="tab1">
					<div class="row gx-md-6 mt-5 justify-content-center">
						<div class="col-sm-12 col-md-12">
							<div>
								<h1 class="heading-title single-title">{$category.cat_note|stripslashes}</h1>
							</div>
						</div>
						{if !$document}
							<div class="post-item col-lg-4 col-sm-6 mb-6 ani-zoomIn">
								{$lable.updating}
							</div>
						{else}
						{foreach from=$document item=vl}
							<div class="post-item col-lg-4 col-sm-6 mb-6 ani-zoomIn">
							<a href="{$vl.slug|url_fe_document_detail:$vl.cat_slug}">
								<figure class="thumbnail-centered thumbnail--3x4">
									{include file="inc/image_news.tpl"
										thumbnail=$vl.path_image_thumb
										image=$vl.path_image
										title=$vl.title|stripslashes}
								</figure>
							</a>
							<div class="d-flex justify-content-center mt-4">
								<a class="btn btn-sm btn-primary mx-1" href="{$vl.slug|url_fe_document_detail:$vl.cat_slug}" title="{$vl.title|stripslashes}">{$lable.document_view}</a>
								<a class="btn btn-sm btn-primary mx-1" href="{$vl.slug|url_document_download:$vl.blog_id}" title="{$lable.document_download}: {$vl.title|stripslashes}" target="_blank">{$lable.document_download}</a>
							</div>
						</div>
						{/foreach}
						{/if}
					</div>
					<div class="d-flex justify-content-center py-4">
						{$links}
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
{include file="footer.tpl"}
