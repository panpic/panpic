{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">

			<div class="post-content">
				{$page.page_detail|stripslashes}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
