<div class="col-lg-4 mt-5 mt-lg-0">
	<div class="widget">
		<h3 class="widget-title bg-gradient3 mb-0">{$lable.menu_aboutus}</h3>
		<div class="widget-content widget-menu">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="{'history'|url_menu_page}" title="{$lable.history}">{$lable.history}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{'strategy-statement'|url_menu_page}" title="{$lable.mn_strategy_statement}">{$lable.mn_strategy_statement}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{'certificate'|url_menu_page}" title="{$lable.mn_certificate}">{$lable.mn_certificate}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{'testimonial'|url_menu_page}" title="{$lable.mn_letters_appreciation}">{$lable.mn_letters_appreciation}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{'technology'|url_menu_page}" title="{$lable.mn_technology}">{$lable.mn_technology}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {if $control eq 'document'}active{/if}" href="{'document'|url_menu_page}" title="{$lable.menu_tailieu}">{$lable.menu_tailieu}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{'partner'|url_menu_page}" title="{$lable.mn_partner_client}">{$lable.mn_partner_client}</a>
				</li>
			</ul>
		</div>
	</div>
	{if $portfolio}
	<div class="widget">
		<h3 class="widget-title bg-gradient3 mb-0">{$lable.sidebar_lb_portfolio}</h3>
		<div class="widget-content widget-post">
			<ul class="navbar-nav">
                {foreach from=$portfolio item=itemPortfolio}
					<li class="nav-item">
						<a class="nav-thumb ani-opa05" href="{$itemPortfolio.slug|url_fe_portfolio_detail:$itemPortfolio.blog_id}"
						   title="{$itemPortfolio.title|stripslashes}">
							<figure class="thumbnail-object-fit thumbnail--6x4">
                                {include file="inc/image_portfolio.tpl" thumbnail=$itemPortfolio.path_image_thumb image=$itemPortfolio.path_image title=$itemPortfolio.title}
							</figure>
						</a>
						<div class="nav-content content-4-line">
							<a class="nav-link" href="{$itemPortfolio.slug|url_fe_portfolio_detail:$itemPortfolio.blog_id}">{$itemPortfolio.title}</a>
							<p class="nav-desc">{$itemPortfolio.title_2}</p>
						</div>
					</li>
                {/foreach}
			</ul>
			<div class="text-end">
				<a class="d-flex align-items-center justify-content-end fs-7" href="{'portfolio'|url_menu_page}" title="{$lable.view_more}">
					<span class="me-1">{$lable.view_more}</span><i class="bi-chevron-double-right fs-9"></i>
				</a>
			</div>
		</div>
	</div>
	{/if}
</div>
