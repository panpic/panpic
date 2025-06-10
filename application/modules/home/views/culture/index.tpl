{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">
			<div class="row">
				<div class="col-lg-8 order-lg-1">
					<article class="single mb-5">
						<h1 class="single-title">{$news.title|stripslashes}</h1>
						<div class="nav list-unstyled single-meta mb-3">
							<i class="bi bi-clock me-1"></i>
							<span>{$news.date_add|date_format:"%d/%m/%Y %H:%m"}</span>
						</div>
						<p class="single-exerpt">{$news.short|stripslashes}</p>
						{**
						<div class="single-thumbnail text-center">
                            {if !$news.path_image}
								<img src="{$no_image_news}" alt="{$news.title}">
                            {else}
								<img src="{$link_upload}/{$news.path_image}"
								     alt="{$news.title}" class="img-fluid">
                            {/if}
						</div>
						**}
						<div class="single-content text-justify pt-1">
                            {$news.content|stripslashes}
						</div>
					</article>
					<div class="page-heading mb-4">
						<h4 class="page-title">{$lable.news_related_lb}</h4>
						<div class="line line-sm"></div>
					</div>
					<div class="row gx-2">
                        {if count($newsRelated) > 0}
                            {foreach from=$newsRelated item=newsRelatedItem}
								<div class="col-12 mb-3">
									<div class="row gx-2 gx-sm-3">
										<div class="col-5 col-md-4">
											<a class="ani-opa05"
											   href="{$newsRelatedItem.slug|url_news_detail:$newsRelatedItem.blog_id}"
											   title="{$newsRelatedItem.title}">
												<figure class="thumbnail-object-fit thumbnail--6x4 ani-zoom">
                                                    {if !$newsRelatedItem.path_image_thumb}
														<img src="{$no_image_news}" alt="{$newsRelatedItem.title|stripslashes}">
                                                    {else}
														<img src="{$link_upload}/{$newsRelatedItem.path_image_thumb}"
														     alt="{$newsRelatedItem.title|stripslashes}">
                                                    {/if}
												</figure>
											</a>
										</div>
										<div class="col-7 col-md-8 content-4-line">
											<h5 class="post-title text-uppercase">
												<a href="{$newsRelatedItem.slug|url_news_detail:$newsRelatedItem.blog_id}"
												   title="{$newsRelatedItem.title|stripslashes}">{$newsRelatedItem.title|stripslashes}</a>
											</h5>
											<div class="nav list-unstyled single-meta mb-2">
												<i class="bi bi-clock me-1"></i>
												<span>{$newsRelatedItem.date_add|date_format:"%d/%m/%Y %H:%m"}</span>
											</div>
											<p class="post-desc d-none d-sm-block">{$newsRelatedItem.short|stripslashes}</p>
										</div>
									</div>
								</div>
                            {/foreach}
                        {else}
	                        <div class="empty">{$lable.updating}</div>
                        {/if}
					</div>
				</div>
                {include file="sidebar.tpl"}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
