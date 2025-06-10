<div class="col-lg-4 col-xl-3 mt-5 mt-lg-0">
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
    <div class="widget">
        <h3 class="widget-title bg-gradient3 mb-0">{$lable.menu_services}</h3>
        <div class="widget-content widget-menu">
            <ul class="navbar-nav">
                {foreach from=$menu_services item=vl}
                    <li class="nav-item">
                        <a class="nav-link" href="{$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}">
                            <div class="bi bi-chevron-double-right text-dark"></div><span>{$vl.cat_name|stripslashes}</span>
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>
    <div class="widget">
        <h3 class="widget-title bg-gradient3 mb-0">{$lable.news_related_lb}</h3>
        <div class="widget-content widget-menu">
            <ul class="navbar-nav">
                {if count($newsRelated)}
                    {foreach from=$newsRelated item=nn}
                        <li>
                            <div class="row gx-4 mt-4">
                                <div class="col-lg-5">
                                    <a class="post-link ani-zoomIn" href="{$nn.slug|url_news_detail:$nn.cat_slug}" title="{$nn.title|stripslashes}">
                                        <figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
                                            {include file="inc/image_news.tpl" thumbnail=$nn.path_image image=$nn.path_image title=$nn.title|stripslashes}
                                        </figure>
                                    </a>
                                </div>
                                <div class="col-lg-7">
                                    <a class="text-hover-primary" href="{$nn.slug|url_news_detail:$nn.cat_slug}" title="{$nn.title|stripslashes}">
                                        <h6 class="mb-0 max-2-line">{$nn.title|stripslashes}</h6>
                                    </a>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                {/if}
            </ul>
        </div>
    </div>
</div>
