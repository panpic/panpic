{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<article class="single">
				<h1 class="single-title text-uppercase">{$page.page_title}</h1>
				<div class="row">
					<div class="col-12 col-md-4 ms-auto">
						<ul class="social-share d-flex m-0">
							<li class="me-2 category mt-1">Share</li>
							<li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ nội dung lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
							<li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ nội dung lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
							<li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ nội dung lên linked" target="_blank"><i class="fa bi-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="mt-5">
							{$page.page_detail|stripslashes}
						</div>
					</div>
				</div>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
						<ul class="list-unstyled row align-items-center mb-3">
							{foreach from=$partners item=partnerItem}
								<li class="col-lg-2 col-md-2 col-sm-4 col-6 text-center mt-sm-5 mt-4">
									{if $partnerItem.link_click != '' & $partnerItem.link_click != '#'}
										<a class="ani-opa05" href="{$partnerItem.link_click}" target="_blank">
									{else}
										<a class="ani-opa05">
									{/if}
										<img class="img-fluid border border-dark" src="{$link_upload}/{$partnerItem.banner_file}"
											 alt="{$partnerItem.title|stripslashes}">
									</a>
								</li>
							{/foreach}
						</ul>
					</div>
				</div>
			</article>
		</div>
	</section>
</main>
{include file="footer.tpl"}
