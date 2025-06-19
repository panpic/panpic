{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section page">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			{**
			<ul class="nav nav-tabs mb-5" role="tablist">
			{foreach from=$categories item=cc}
				<li class="nav-item" role="presentation"><a class="nav-link {if $cc.post_cat_id eq $news.category_id}active{/if}" href="{$cc.cat_slug|url_news_cat}">{$cc.cat_name}</a></li>
			{/foreach}
			</ul>
			**}
			<div class="row">
				<div class="col-lg-2 mt-5 mt-lg-0"> &nbsp;</div>
				<div class="col-12 col-xl-10 col-lg-10">
					<article class="single">
						{if $form_app eq ACTIVE && $alert neq '' && $msg neq ''}
							<div class="col-md-12">
								{include file="notes.tpl"}
							</div>
						{/if}
						<h1 class="single-title text-uppercase">{$news.title|stripslashes}</h1>
						{include file="widget/breadcrumb_news.tpl"}
						<div class="single-exerpt mt-5">{$news.short|stripslashes|nl2br}</div>
						<div class="single-content mb-5">
							{$news.content|stripslashes}
						</div>
						<div class="single-content mb-5">
							{if $tags}
							<div class="col-12 col-md-12">
								TAGS: {foreach from=$tags item=vl}<a href="{$vl.slug|url_blog_tags}" title="{$vl.title|stripslashes}" class="btn btn-outline-dark mt-2">{$vl.title|stripslashes}</a>{/foreach}
							</div>
							{/if}
							<div class="col-12 col-md-12">
								<div class="author-about">About the Author</div>
								<div class="author-wrap">
									<div class="author-avatar">
										<img src="https://www.panpic.vn/assets/front/images/logo.png" height="64" width="64" alt="Panpic Editorial Team">
									</div>
									<div class="author-info">
										<div class="author-name">
											<a href="https://www.panpic.vn/author/panpicteam">Panpic Editorial Team</a>
										</div>
										<div class="author-description">{$news.date_add|date_format:"%d/%m/%Y"}</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<ul class="social-share d-flex m-0">
									<li class="me-2 category mt-1">Share</li>
									<li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ bài viết lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
									<li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ bài viết lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
									<li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ bài viết lên linked" target="_blank"><i class="fa bi-linkedin"></i></a></li>
									<li>
										<div class="zalo-share-button"  data-oaid="1069300263628412773" data-layout="2" data-color="blue" data-customize="false"></div>
									</li>
								</ul>
							</div>
							{if $form_app eq ACTIVE}
								<div class="row">
									<div class="col-sm-5 col-md-5">
										<div class="heading"><h4 class="heading-title">{$lable.type_apply_recruitment}</h4></div><div class="form-group">{$page.page_detail|stripslashes}</div>
									</div>
									<div class="col-sm-7 col-md-7">
										{include file="careers/form.tpl"}
									</div>
								</div>
							{/if}
						</div>
					</article>
				</div>
				{**include file="sidebar-table-content.tpl"**}
				{include file="services/sidebar-table-content.tpl"}
			</div>
		</div>
	</section>
	<section class="section pt-0">
		<div class="container">
			<div class="heading"><p class="heading-title">{$lable.news_related_lb}</p></div>
			<div class="news-slider slick-custom">
				{if count($newsRelated)}
				{foreach from=$newsRelated item=nn}
				<div class="news-slider-item">
					<div class="card h-13">
						<a class="post-link ani-zoomIn" href="{$nn.slug|url_news_detail:$nn.cat_slug}" title="{$nn.title|stripslashes}"><figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">{include file="inc/image_news.tpl" thumbnail=$nn.path_image image=$nn.path_image title=$nn.title|stripslashes}</figure></a>
						<div class="card-body">
							<div class="post-body">
								<div class="post-date text-primary">{$nn.date_add|date_format:"%d/%m/%Y"}</div><a class="post-title text-hover-primary" href="{$nn.slug|url_news_detail:$nn.cat_slug}" title="{$nn.title|stripslashes}"><p class="mb-0 max-2-line">{$nn.title|stripslashes}</p></a>
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
<script>
let isiPad = "{$isiPad}";
{literal}$(document).ready(function(){$('.single-content img').each(function(i){$(this).addClass('img-fluid');});});{/literal}
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>
{include file="footer.tpl"}