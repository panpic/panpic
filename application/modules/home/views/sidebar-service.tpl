<div class="col-lg-4 col-xl-3 mt-5 mt-lg-0">
    <div class="widget">
        <h3 class="widget-title bg-gradient3 mb-0">{$lable.menu_services}</h3>
        <div class="widget-content widget-menu">
            <ul class="navbar-nav">
                {foreach from=$menu_services item=vl}
                    <li class="nav-item">
                        <a class="nav-link {if $service.category_id eq $vl.post_cat_id}active{/if}" href="{$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}">
                            <div class="bi bi-chevron-double-right text-dark"></div><span>{$vl.cat_name|stripslashes}</span>
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>
    <div class="widget widget-menu">
        <h3 class="widget-title">{$lable.mn_portfolio}</h3>
        <ul class="navbar-nav list-unstyled">
            {foreach from=$menu_duan item=cc}
                <li class="nav-item">
                    <a class="nav-link {if $cc.post_cat_id eq $category.post_cat_id}active{/if}" href="{$cc.cat_slug|url_fe_portfolio_cat}" title="{$cc.cat_name}">
                        <div class="bi bi-chevron-double-right text-dark"></div><span>{$cc.cat_name}</span>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
    <div class="widget">
        <h3 class="widget-title bg-gradient3 mb-0">{$lable.mn_news}</h3>
        <div class="widget-content widget-menu">
            <ul class="navbar-nav">
                {foreach from=$menu_tintuc item=mn_news}
                    <li class="nav-item">
                        <a class="nav-link {if $mn_news.post_cat_id eq $news.category_id}active{/if}" href="{$mn_news.cat_slug|url_news_cat}">
                            <div class="bi bi-chevron-double-right text-dark"></div><span>{$mn_news.cat_name|stripslashes}</span>
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>
</div>
