{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<article class="single">
				<div class="heading">
					<h1 class="heading-title single-title text-uppercase">{$page.page_title}</h1>
				</div>
				<div class="single-content mb-5">
					{$page.page_detail|stripslashes}
				</div>
			</article>
		</div>
	</section>
</main>
{include file="footer.tpl"}
