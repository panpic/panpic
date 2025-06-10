<div class="header" id="header">
<div class="container">
<div class="overlay"></div>
<div class="row gx-3 align-items-center">
<div class="col-3 col-lg-4">
<div class="d-flex align-items-center">
<div class="logo"><a href="{$base_url}" title="Logo Thiết kế web Panpic"><img class="img-fluid" src="{$base_tlp_front}/images/logo.png" width="97" height="97" alt="Logo Panpic"></a></div><div class="d-none d-md-block"><span class="slogan">Great website great business</span></div>
</div>
</div>
<div class="col-9 col-lg-8">
<div class="d-flex flex-column align-items-md-end">
	<div class="d-flex align-items-center justify-content-end">
		<div class="nav-info">
			<a class="nav-info-item" href="tel:{$lable.top_hotline}"><i class="bi bi-telephone-fill"></i><span> {$lable.top_hotline}</span></a>
			<a class="nav-info-item d-none d-md-flex" href="mailto:{$lable.top_email}" title="Email: {$lable.top_email}"><i class="bi bi-envelope-fill"></i><span> {$lable.top_email}</span></a>
		</div>
		<ul class="nav nav-lang">
			<li class="nav-item"><a class="nav-link mt-2" href="{$base_url}" title="tiếng Việt"><i class="sprite sprite-lang-vi"></i></a></li>
			<li class="nav-item"><a class="nav-link mt-2" href="https://panpic.com.vn" title="Web development in HCM" target="_blank"><i class="sprite sprite-lang-en"></i></a></li>
			<li class="nav-item lang-item me-2"><div class="nav-link search-form-trigger cursor"><i class="bi bi-search"></i></div></li>
		</ul>
		<div class="search-form__wrap">
			<div class="search-form__overlay"></div>
			<div id="search-form" class="search-form__jws">
				<button type="button" class="search-form__close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<form method="get" id="frm-search" name="frm-search" action="{$base_url}/tim-kiem">
					<div class="row">
						<div class="col-sm-12 col-md-10"><input name="s" value="{$search.s}" type="text" class="form-control" placeholder="{$lable.placeholder_search}"></div>
						<div class="col-sm-12 col-md-2"><button type="submit" name="seach" class="form-control"><i class="bi bi-search"></i> {$lable.btn_search}</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="main-menu" id="main-menu">
		<div class="main-menu-inner">
			<ul class="nav">
				<li class="nav-item"><a class="nav-link{if $control eq 'index'} active{/if}" href="{$base_url}" title="Trang chủ">
					<i class="{**sprite sprite-home**} bi bi-house fs-4"></i><span class="d-lg-none">{$lable.menu_homepage}</span></a>
				</li>
				<li class="nav-item">
					{assign var=focus value=$menu_services[0]}
					<a class="nav-link{if $control eq 'contact'} active{/if}" href="{$focus.cat_slug|url_fe_service_detail:$focus.post_cat_id}" title="{$focus.cat_name|stripslashes}">{$focus.cat_name|stripslashes}</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link{if $control eq 'about'} active{/if}" href="{'about_us'|url_menu_page}">{$lable.menu_aboutus}<i class="bi bi-caret-down-fill"></i></a>
					<ul class="navbar-nav dropdown-content">
						<li class="dropdown-item"><a class="dropdown-link" href="{'about_us'|url_menu_page}">{$lable.menu_about_gioithieu}</a></li>
						<li class="dropdown-item"><a class="dropdown-link" href="{'history'|url_menu_page}">{$lable.menu_about_history}</a></li>
						<li class="dropdown-item"><a class="dropdown-link" href="{'company_chart'|url_menu_page}">{$lable.menu_about_cocautochu}</a></li>
						<li class="dropdown-item"><a class="dropdown-link" href="{'core_value'|url_menu_page}">{$lable.menu_about_corevalue}</a></li>
						<li class="dropdown-item"><a class="dropdown-link" href="{'partner'|url_menu_page}">{$lable.menu_partner_client}</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					{assign var=service_1 value=$menu_services.0}
					<a class="nav-link{if $control eq 'services'} active{/if}" href="{$service_1.cat_slug|url_fe_service_detail:$service_1.post_cat_id}">{$lable.menu_services}<i class="bi bi-caret-down-fill"></i></a>
					<ul class="navbar-nav dropdown-content">{foreach from=$menu_services item=vl}<li class="dropdown-item"><a class="dropdown-link" href="{$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}" title="{$vl.cat_name|stripslashes}">{$vl.cat_name|stripslashes}</a></li>{/foreach}</ul>
				</li>
				<li class="nav-item dropdown dropdown-mega">
					<a class="nav-link {if $control eq 'portfolio'}active{/if}" href="{'portfolio'|url_menu_page}">{$lable.mn_portfolio}<i class="bi bi-caret-down-fill"></i></a>
					<div class="container dropdown-content">
						<div class="row justify-content-center">
							<div class="col-lg-6 col-xxl-6 bg-white">
								<ul class="nav">
									<li class="dropdown-item col-lg-4 mb-2 mb-lg-0 {if $control eq 'portfolio'}active{/if}">
										<p class="fw-bold text-primary text-uppercase mb-lg-3">{$lable.by_portfolio}</p>
										<ul class="navbar-nav">{foreach from=$menu_duan item=mn_duan}<li><a href="{$mn_duan.cat_slug|url_fe_portfolio_cat}" title="{$mn_duan.cat_name}">{$mn_duan.cat_name}</a></li>{/foreach}</ul>
									</li>
									<li class="dropdown-item col-lg-4 mb-2 mb-lg-0">
										<p class="fw-bold text-primary text-uppercase mb-lg-3">{$lable.by_year}</p>
										<ul class="navbar-nav">{foreach from=$menu_year_portfolio key=$keyYear item=mnYearPortfolio}{if $keyYear <= 3}<li><a href="{$mnYearPortfolio.portfolio_year|date_format:"%Y"|url_fe_portfolio_year}" title="{$mnYearPortfolio.portfolio_year|date_format:"%Y"}">{$mnYearPortfolio.portfolio_year|date_format:"%Y"}</a></li>{/if}{if $keyYear == 4}{$tempYear = $mnYearPortfolio.portfolio_year|date_format:"%Y"}{/if}{if $keyYear == $menu_year_portfolio_count}<li><a href="{$tempYear|url_fe_portfolio_year}" title="{$mnYearPortfolio.portfolio_year|date_format:"%Y"}">{$mnYearPortfolio.portfolio_year|date_format:"%Y"} - {$tempYear}</a></li>{/if}{/foreach}</ul>
									</li>
									<li class="dropdown-item col-lg-4 mb-2 mb-lg-0">
										<p class="fw-bold text-primary text-uppercase mb-lg-3">{$lable.menu_testimonial_short}</p>
										<ul class="navbar-nav"><li><a href="{'testimonial'|url_fe_portfolio_cat}" title="{$lable.mn_testimonial}">{$lable.mn_testimonial}</a></li></ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link{if $control eq 'news'} active{/if}" href="{'news'|url_menu_page}">{$lable.mn_news}<i class="bi bi-caret-down-fill"></i></a>
					<ul class="navbar-nav dropdown-content">{foreach from=$menu_tintuc item=mn_news}<li class="dropdown-item"><a class="dropdown-link" href="{$mn_news.cat_slug|url_news_cat}">{$mn_news.cat_name|stripslashes}</a></li>{/foreach}</ul>
				</li>
				<li class="nav-item dropdown">{assign var=doc_1 value=$menu_document.0}
					<a class="nav-link{if $control eq 'documents'} active{/if}" href="{$doc_1.cat_slug|url_document_cat}">{$lable.menu_tailieu}<i class="bi bi-caret-down-fill"></i></a>
					<ul class="navbar-nav dropdown-content">{foreach from=$menu_document item=mn_doc}<li class="dropdown-item"><a class="dropdown-link" href="{$mn_doc.cat_slug|url_document_cat}">{$mn_doc.cat_name|stripslashes}</a></li>{/foreach}</ul>
				</li>
				<li class="nav-item"><a class="nav-link{if $control eq 'contact'} active{/if}" href="{'contact'|url_menu_page}" title="{$lable.mn_contact}">{$lable.mn_contact}</a></li>
			</ul>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>