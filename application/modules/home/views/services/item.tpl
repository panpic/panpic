{include file="header.tpl"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.min.css">
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content mb-7">
			<div class="heading mt-0 mb-4 mb-lg-5">
				<h1 class="heading-title lh-base h3">{$lable.menu_services}</h1>
			</div>
			<div class="row gx-sm-2 gx-md-3 gx-lg-4">
				{foreach from=$service item=serviceItem}
					<div class="col-xl-3 col-lg-4 col-sm-6">
						<div class="card service-item">
							<a href="{$serviceItem.slug|url_fe_service_detail:$serviceItem.blog_id}">
								<div class="card-body bg-gradient4 text-center">
									<i class="fa fa-laptop"></i>
									<h5 class="text-warning mt-4">{$serviceItem.title|stripslashes}</h5>
									<p class="text-light">{$serviceItem.short|stripslashes}</p>
								</div>
							</a>
						</div>
					</div>
				{/foreach}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
