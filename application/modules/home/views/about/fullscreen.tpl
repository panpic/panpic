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
			<article class="single">
				<h1 class="single-title text-uppercase">{$page.page_title}</h1>
				<div class="row">
					<div class="col-12 col-md-4 ms-auto">
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
				<div class="single-content mb-5">
					{$page.page_detail|stripslashes}
				</div>
			</article>
		</div>
	</section>
	{include file="about/services.tpl"}
</main>
<script>
	{literal}$(document).ready(function(){$('.single-content img').each(function(i){$(this).addClass('img-fluid');});});{/literal}
</script>
{include file="footer.tpl"}