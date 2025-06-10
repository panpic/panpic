{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">
			<div class="heading mt-0 mb-4 mb-lg-5">
				<h1 class="heading-title lh-base h3">{$page.page_title}</h1>
			</div>
			<div class="post-content">
				{$page.page_detail}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
