{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">
			<div class="row">
				<div class="col-lg-8 order-lg-1">
					<div class="heading mt-0 mb-4 mb-lg-5">
						<h1 class="heading-title lh-base h3">{$lable.letters}</h1>
					</div>
					<div class="testimonial-list row">
                        {foreach from=$testimonial key=$keyTestimonial item=testimonialItem}
						<div class="col-12 col-sm-12 col-md-4 mb-4">
							<a data-fancybox="gallery" data-caption="{$testimonialItem.title|stripslashes}"
							   href="{$link_upload}/{$testimonialItem.path_image}">
                                {if !$testimonialItem.path_image_thumb}
									<img src="{$link_upload}/{$testimonialItem.path_image}" alt="{$testimonialItem.title|stripslashes}">
                                {else}
									<img src="{$link_upload}/{$testimonialItem.path_image_thumb}"
									     alt="{$testimonialItem.title|stripslashes}">
                                {/if}
							</a>
							<div class="testimonial-title text-center">{$testimonialItem.title|stripslashes}</div>
						</div>
                        {/foreach}
					</div>
					<div class="row justify-content-center py-4">
                        {$links}
					</div>
				</div>
                {include file="sidebar-about.tpl"}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
