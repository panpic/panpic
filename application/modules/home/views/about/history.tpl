{include file="header.tpl"}
<main class="main-content" id="main-content">
	{if $banner.banner_file neq ''}
		{assign var=file value="{$link_upload}/`$banner.banner_file`"}
	{else}
		{assign var=file value=$lable.bg_default}
	{/if}
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			{include file="about/tab.tpl"}
			<div class="row">
				<div class="col-6 col-md-8">
					<h1 class="single-title text-uppercase">{$page.page_title}</h1>
				</div>
				<div class="col-6 col-md-4 ms-auto">
					<ul class="social-share d-flex m-0">
						<li class="me-2 category mt-1">Share</li>
						<li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ nội dung lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
						<li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ nội dung lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
						<li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ nội dung lên linkedin" target="_blank"><i class="fa bi-linkedin"></i></a></li>
						<li>
							<div class="zalo-share-button"  data-oaid="1069300263628412773" data-layout="2" data-color="blue" data-customize="false"></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<section class="about-detail mb-8">
		<div class="section bg-light">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-9">
						<div class="about-thumb">
							{foreach from=$history key=$keyHistory item=historyItem}
							<div class="about-item">
								<h5 class="text-center">{$historyItem.title|stripslashes}</h5>
								<figure class="thumbnail-centered thumbnail--6x4">
									{if $historyItem.path_image neq ''}
										{assign var=img value="$link_upload/`$historyItem.path_image`"}
									{else}
										{assign var=img value=$lable.no_image_history}
									{/if}
									<img src="{$img}" alt="{$historyItem.title|stripslashes}">
								</figure>
							</div>
							{/foreach}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="about-detail-content">
			<div class="container">
				<div class="about-content">
					{foreach from=$history key=$keyHistory item=historyItem}
					<div class="about-item">
						<div class="card card-body py-lg-6 bg-light">
							<div class="row">
								<div class="col-lg-6">
									<figure class="thumbnail-centered thumbnail--6x4">
										{if $historyItem.path_image neq ''}
											{assign var=img value="`$link_upload`/`$historyItem.path_image`"}
										{else}
											{assign var=img value=$lable.no_image_history}
										{/if}
										<img src="{$img}" alt="{$historyItem.title|stripslashes}">
									</figure>
								</div>
								<div class="col-lg-6 mt-5 mt-lg-0">
									<div class="post-date">
										<i class="bi bi-clock"></i>
										<span class="text-primary">{$historyItem.title|stripslashes}</span>
									</div>
									<div class="fs-6">
										{$historyItem.content|stripslashes}
									</div>
								</div>
							</div>
						</div>
					</div>
					{/foreach}
				</div>
			</div>
		</div>
	</section>
	{include file="about/services.tpl"}
</main>
{include file="footer.tpl"}
