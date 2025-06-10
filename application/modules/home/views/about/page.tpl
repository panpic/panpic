{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">
			<div class="row">
				<div class="col-lg-8 order-lg-1">
					<div class="heading mt-0 mb-4 mb-lg-5">
						<h1 class="heading-title lh-base h3">{$page.page_title|stripslashes}</h1>
					</div>
                    {$page.page_detail|stripslashes}
				</div>
                {include file="sidebar-about.tpl"}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
