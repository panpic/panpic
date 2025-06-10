{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<ul class="nav nav-tabs mb-5" role="tablist">
				{foreach from=$categories item=cc}
					<li class="nav-item" role="presentation">
						<a class="nav-link {if $cc.post_cat_id eq $news.category_id}active{/if}" href="{$cc.cat_slug|url_news_cat}">{$cc.cat_name}</a>
					</li>
				{/foreach}
			</ul>
			<article class="single">
				{if $form_app eq ACTIVE && $alert neq '' && $msg neq ''}
					<div class="col-md-12">
						{include file="notes.tpl"}
					</div>
				{/if}
				<h1 class="single-title">{$news.title|stripslashes}</h1>
				{include file="widget/breadcrumb_news.tpl"}
				{**<h5 class="single-exerpt">{$news.short|stripslashes|nl2br}</h5>**}
				<div class="single-content mb-5 mt-5">
					<div class="post-item row">
						<div class="col-sm-4 mb-3 mb-sm-0">
							<a href="{$news.short|stripslashes}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video">
								<span class="post-thumb ani-zoomIn">
									<figure class="thumbnail-centered thumbnail--6x4">
										{include file="inc/image_news.tpl"
										thumbnail=$news.path_image_thumb
										image=$news.path_image
										title=$news.title}
									</figure>
									<i class="icon-play"></i>
								</span>
							</a>
						</div>
					</div>
					{$news.content|stripslashes}
				</div>
			</article>
		</div>
	</section>
	<section class="section pt-0">
		<div class="container">
			<div class="heading">
				<h4 class="heading-title">{$lable.news_related_lb}</h4>
			</div>
			<div class="news-slider slick-custom">
				{if count($newsRelated)}
				{foreach from=$newsRelated item=nn}
				<div class="news-slider-item">
					<div class="card h-100">
						<a class="post-link ani-zoomIn" href="{$nn.slug|url_news_detail:$nn.cat_slug}" title="{$nn.title|stripslashes}">
							<figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
								{include file="inc/image_news.tpl"
								thumbnail=$nn.path_image
								image=$nn.path_image
								title=$nn.title|stripslashes}
							</figure>
						</a>
						<div class="card-body">
							<div class="post-body">
								<div class="post-date text-primary">{$nn.date_add|date_format:"%d/%m/%Y"}</div>
								<a class="post-title text-hover-primary" href="{$nn.slug|url_news_detail:$nn.cat_slug}" title="{$nn.title|stripslashes}">
									<h6 class="mb-0 max-2-line">{$nn.title|stripslashes}</h6>
								</a>
							</div>
						</div>
					</div>
				</div>
				{/foreach}
				{/if}
			</div>
		</div>
	</section>
</main>
{include file="footer.tpl"}
<script>
{literal}
$(document).ready(function(){
	$('.single-content img').each(function(i){$(this).addClass('img-fluid');});
});
{/literal}
</script>