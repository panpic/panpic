<div class="col-lg-4 mt-5 mt-lg-0">
    <div class="widget">
        <h3 class="widget-title bg-gradient3 mb-0">{$lable.menu_recruitment}</h3>
        <div class="widget-content widget-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{'careers_policies'|url_menu_page}" title="{$lable.mn_human_resource_policy}">{$lable.mn_human_resource_policy}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{'careers'|url_menu_page}" title="{$lable.opportunity_careers}">{$lable.opportunity_careers}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="widget">
        <h3 class="widget-title bg-gradient3 mb-0">{$lable.sidebar_lb_portfolio}</h3>
        <div class="widget-content widget-post">
            <ul class="navbar-nav">
                {foreach from=$portfolio item=itemPortfolio}
                    <li class="nav-item">
                        <a class="nav-thumb ani-opa05"
                           href="{$itemPortfolio.slug|url_fe_portfolio_detail:$itemPortfolio.blog_id}"
                           title="{$itemPortfolio.title|stripslashes}">
                            <figure class="thumbnail-object-fit thumbnail--6x4">
                                {include file="inc/image_portfolio.tpl" thumbnail=$itemPortfolio.path_image_thumb image=$itemPortfolio.path_image title=$itemPortfolio.title}
                            </figure>
                        </a>
                        <div class="nav-content content-4-line">
                            <a class="nav-link" href="{$itemPortfolio.slug|url_fe_portfolio_detail:$itemPortfolio.blog_id}">{$itemPortfolio.title|stripslashes}</a>
                            <p class="nav-desc">{$itemPortfolio.title_2}</p>
                        </div>
                    </li>
                {/foreach}
            </ul>
            <div class="text-end">
                <a class="d-flex align-items-center justify-content-end fs-7" href="{'portfolio'|url_menu_page}" title="{$lable.view_more}"><span class="me-1">{$lable.view_more}</span><i class="bi-chevron-double-right fs-9"></i></a>
            </div>
        </div>
    </div>
</div>
