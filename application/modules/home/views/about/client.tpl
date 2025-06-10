{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content  page-partner">
			<div class="heading mt-0 mb-4 mb-lg-5">
				<h1 class="heading-title lh-base h3">{$page.page_title|stripslashes}</h1>
			</div>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="customer-tab" href="#customer" data-bs-toggle="tab" role="tab"
					   aria-controls="customer" aria-selected="true">{$lable.mn_partner}</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
					<ul class="list-unstyled row align-items-center mb-3">
                        {foreach from=$partners item=partnerItem}
							<li class="col-lg-2 col-md-3 col-sm-4 col-6 text-center mt-sm-5 mt-4">
                                {if $partnerItem.link_click != '' & $partnerItem.link_click != '#'}
								<a class="ani-opa05" href="{$partnerItem.link_click}" target="_blank">
                                    {else}
									<a class="ani-opa05">
                                        {/if}
										<img class="img-fluid" src="{$link_upload}/{$partnerItem.banner_file}"
										     alt="{$partnerItem.title|stripslashes}">
									</a>
							</li>
                        {/foreach}
					</ul>
				</div>
			</div>
			<div class="post-content mt-5">
				{$page.page_detail|stripslashes}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
