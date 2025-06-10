{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<div class="row">
				<div class="col-xl-9 col-lg-8 order-lg-1">
					<article class="single">
						{if $form_app eq ACTIVE && $alert neq '' && $msg neq ''}
							<div class="col-md-12">{include file="notes.tpl"}</div>
						{/if}
						<div class="heading mb-5">
							<h1 class="heading-title single-title">{$news.title|stripslashes}</h1>
						</div>
						{include file="widget/breadcrumb_news.tpl"}
						<h5 class="single-exerpt mt-5">{$news.short|stripslashes|nl2br}</h5>
						<div class="single-content mb-5">
							{$news.content|stripslashes}
						</div>
					</article>
				</div>
				{include file="sidebar-portfolio.tpl"}
			</div>
		</div>
	</section>
	<section class="section pt-0">
		<div class="container">
			<div class="heading"><h4 class="heading-title">{$lable.mn_testimonial}</h4></div>
			<div class="news-slider slick-custom">
				{if count($newsRelated)}
				{foreach from=$newsRelated item=nn}
				{assign var=title value=$nn.title|stripslashes}
				{assign var=link value=$nn.slug|url_testimonial_detail:$nn.cat_slug}
				<div class="news-slider-item">
					<div class="card h-13">
						<a class="post-link ani-zoomIn" href="{$link}" title="{$title}">
							<figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">{include file="inc/image_news.tpl" thumbnail=$nn.path_image image=$nn.path_image title=$title}</figure>
						</a>
						<div class="card-body">
							<div class="post-body">
								<div class="post-date">{$nn.date_add|date_format:"%d/%m/%Y"}</div>
								<a class="text-hover-primary" href="{$link}" title="{$title}"><h6 class="mb-0 max-2-line fst-italic">{$title}</h6></a>
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
{literal}<script> $(document).ready(function(){ $('.single-content img').each(function(i){$(this).addClass('img-fluid');});});</script>{/literal}