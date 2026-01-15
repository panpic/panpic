{include file="header.tpl"}
<main class="main-content" id="main-content">
<section class="main-slider">
<div id="main-slider">
{foreach from=$banners item=bn}
    {assign var=bn_link value=$bn.link_click|stripslashes}
    {if $bn_link}<a href="{$bn_link}">{/if}
    <div class="main-slider-item">
        <figure class="main-slider-thumb thumbnail-centered"><img src="{$link_upload}/{$bn.banner_file}" srcset="{$link_upload}/{$bn.banner_file} 480w, {$link_upload}/{$bn.banner_file} 1080w" sizes="50vw" alt="{$bn.title|stripslashes}"></figure>
        <div class="main-slider-content"><div class="mb-3">{$lable.seo_h1_home|stripslashes}</div><a class="btn btn-primary w-auto mx-auto text-white" href="https://www.panpic.vn/thiet-ke-web-cong-ty-xay-dung" title="Thiết kế web công ty xây dựng"><span class="me-2">Web công ty xây dựng</span><i class="bi bi-arrow-right-circle"></i></a></div>
    </div>
    {if $bn_link}</a>{/if}
{/foreach}
</div>
{if $isMobile neq DETECT_MOBILE}
<div class="scroll-downs"><div class="mousey"><div class="scroller"></div></div>{**<span>Scroll Down</span>**}</div>
{/if}
</section>
<section class="section">
<div class="container">
    <div class="heading d-flex align-items-baseline">
        <h2 class="heading-title mb-0">{$lable.lable_portfolio_typical_projects}</h2>
        <span class="ml-3 text-muted font-italic">{$lable.lable_portfolio_typical_project_note|stripslashes}</span>
    </div>
    <div class="row gx-4">
        {foreach from=$portfolios item=pp}
            {assign var=title value=$pp.title|stripslashes}
            <div class="col-6 col-sm-6 col-xl-3 col-lg-4 post-project-item">
                <a class="post-project-link" href="{$pp.slug|url_fe_portfolio_detail:$pp.cat_slug}" title="{$title}">
                    <figure class="thumbnail-centered thumbnail--4x3 rounded">{include file="inc/image_portfolio.tpl" thumbnail=$pp.path_image_thumb image=$pp.path_image title=$pp.title_2}</figure>
                    <div class="post-project-content"><h3 class="text-center">{$title}</h3><p class="fs-6 text-center">{$pp.portfolio_utility|stripslashes}</p></div>
                </a>
            </div>
        {/foreach}
        <div class="col-12 text-center mt-5">
            <a class="btn btn-icon btn-primary" href="{'portfolio'|url_menu_page}" title="{$lable.lable_portfolio_typical_projects}"><span>{$lable.view_more}</span><i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
</div>
</section>
<section class="section-paralax" style="background-image:url({$base_tlp_front}/images/background/paralax.webp);">
<div class="container">
    <div class="heading-center d-flex flex-column align-items-center mb-7">
        <h3 class="text-uppercase text-center title-focus mb-3 heading-bb">{$lable.menu_services}</h3>
        <p class="d-block text-muted font-italic">{$lable.home_service_note|stripslashes}</p>
    </div>

    <div class="row justify-content-center">
        {assign var=service_1 value=$services_menu_home[0]}
        {assign var=service_2 value=$services_menu_home[1]}
        {assign var=service_3 value=$services_menu_home[2]}
        {assign var=service_4 value=$services_menu_home[3]}
        {assign var=service_5 value=$services_menu_home[4]}
        <div class="col-6 col-sm-6 col-lg-2 text-center mb-6 mb-lg-0">
            <a class="text-white" href="{$service_1.cat_slug|url_fe_service_detail:$service_1.post_cat_id}" title="{$service_1.cat_name|stripslashes}"><i class="icon icon-paralax1"></i><h3 class="mb-0 mt-4 text-uppercase title-focus h3">{$service_1.cat_name|stripslashes}</h3></a>
        </div>
        <div class="col-6 col-sm-6 col-lg-2 text-center mb-6 mb-lg-0">
            <a class="text-white" href="{$service_2.cat_slug|url_fe_service_detail:$service_2.post_cat_id}" title="{$service_2.cat_name|stripslashes}"><i class="icon icon-paralax2"></i><h3 class="mb-0 mt-4 text-uppercase title-focus h3">{$service_2.cat_name|stripslashes}</h3></a>
        </div>
        <div class="col-6 col-sm-6 col-lg-2 text-center mb-6 mb-sm-0">
            <a class="text-white" href="{$service_3.cat_slug|url_fe_service_detail:$service_3.post_cat_id}" title="{$service_3.cat_name|stripslashes}"><i class="icon icon-paralax3"></i><h3 class="mb-0 mt-4 text-uppercase title-focus h3">{$service_3.cat_name|stripslashes}</h3></a>
        </div>
        <div class="col-6 col-sm-6 col-lg-2 text-center mb-6 mb-sm-0">
            <a class="text-white" href="{$service_4.cat_slug|url_fe_service_detail:$service_4.post_cat_id}" title="{$service_4.cat_name|stripslashes}"><i class="icon icon-paralax4"></i><h3 class="mb-0 mt-4 text-uppercase title-focus h3">{$service_4.cat_name|stripslashes}</h3></a>
        </div>
        <div class="col-6 col-sm-6 col-lg-2 text-center mb-6 mb-sm-0">
            <a class="text-white" href="{$service_5.cat_slug|url_fe_service_detail:$service_5.post_cat_id}" title="{$service_5.cat_name|stripslashes}"><i class="icon icon-paralax9"></i><h3 class="mb-0 mt-4 text-uppercase title-focus h3">{$service_5.cat_name|stripslashes}</h3></a>
        </div>
    </div>
</div>
</section>
<section class="section">
<div class="container pt-3">
    <div class="row">
        <div class="heading-center d-flex flex-column align-items-center mb-5">
            <h2 class="heading-title mb-3">{$lable.lable_why_choose_us}</h2>
            <p class="d-block text-muted font-italic">{$lable.home_why_note|stripslashes}</p>
        </div>
        <div class="col-sm-12 col-lg-12">{include file="index/why-home.tpl"}</div>
    </div>
</div>
</section>
<section class="section">
<div class="container">
    <div class="row">
        <div class="heading-center justify-content-center"><h3 class="heading-title">{$lable.testimonial}</h3></div>
        <div class="col-sm-12 col-lg-12 pt-5">{include file="index/testimonial.tpl"}</div>
    </div>
</div>
</section>
<section class="section bg-light">
<div class="container">
    <div class="heading"><h4 class="heading-title">{$lable.lable_home_news}</h4></div>
    <div class="row gx-4">
        <div class="col-xl-7 mb-4 mb-xl-0">
            <div class="row gx-4">
                {assign var=hot_1 value=$news.0}
                {assign var=hot_2 value=$news.1}
                {assign var=hot_3 value=$news.2}
                <div class="post-item col-12 mb-5">
                    <a class="post-link ani-zoomIn" href="{$hot_1.slug|url_news_detail:$hot_1.cat_slug}">
                        <figure class="thumbnail-centered thumbnail--16x9 thumbnail-xxl--24x9">{include file="inc/image_news.tpl" thumbnail=$hot_1.path_image_thumb image=$hot_1.path_image title=$hot_1.title}</figure>
                        <div class="post-content">
                            <div class="post-date"><i class="bi bi-clock-fill"></i><span>{$hot_1.date_add|date_format:"%d/%m/%Y"}</span></div>
                            <h3 class="post-title text-uppercase h3">{$hot_1.title|stripslashes}</h3>
                        </div>
                    </a>
                </div>
                <div class="post-item col-md-6 mb-4 mb-md-0">
                    <a class="post-link ani-zoomIn" href="{$hot_2.slug|url_news_detail:$hot_2.cat_slug}">
                        <figure class="thumbnail-centered thumbnail--16x9">{include file="inc/image_news.tpl" thumbnail=$hot_2.path_image_thumb image=$hot_2.path_image title=$hot_2.title}</figure>
                        <div class="post-content">
                            <div class="post-date"><i class="bi bi-clock-fill"></i><span>{$hot_2.date_add|date_format:"%d/%m/%Y"}</span></div>
                            <h3 class="post-title text-uppercase h3">{$hot_2.title|stripslashes}</h3>
                        </div>
                    </a>
                </div>
                <div class="post-item col-md-6">
                    <a class="post-link ani-zoomIn" href="{$hot_3.slug|url_news_detail:$hot_3.cat_slug}">
                        <figure class="thumbnail-centered thumbnail--16x9">{include file="inc/image_news.tpl" thumbnail=$hot_3.path_image_thumb image=$hot_3.path_image title=$hot_3.title}</figure>
                        <div class="post-content">
                            <div class="post-date"><i class="bi bi-clock-fill"></i><span>{$hot_3.date_add|date_format:"%d/%m/%Y"}</span></div>
                            <h3 class="post-title text-uppercase h3">{$hot_3.title|stripslashes}</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="bg-white px-3 py-3 py-md-3">
                <ul class="nav nav-tabs nav-tabs-arrow mb-5" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" id="tab1" data-bs-toggle="tab" data-bs-target="#tab1-nav" type="button" role="tab" aria-controls="tab1" aria-selected="true">{$news_sub_1.cat_name}</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="tab2" data-bs-toggle="tab" data-bs-target="#tab2-nav" type="button" role="tab" aria-controls="tab2" aria-selected="false">{$news_sub_2.cat_name}</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="tab3" data-bs-toggle="tab" data-bs-target="#tab3-nav" type="button" role="tab" aria-controls="tab3" aria-selected="true">{$news_sub_3.cat_name}</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="tab4" data-bs-toggle="tab" data-bs-target="#tab4-nav" type="button" role="tab" aria-controls="tab4" aria-selected="false">{$news_sub_4.cat_name}</button></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1-nav" role="tabpanel" aria-labelledby="tab1">
                        <div class="post">
                            {assign var=news_1 value=$news_sub_1.news}
                            {if $news_1}
                                {foreach from=$news_1 item=vl}
                                    <div class="post-item">
                                        {**<div class="post-date"><i class="bi bi-clock"></i><span class="text-primary">{$vl.date_add|date_format:"%d/%m/%Y"}</span></div>**}
                                        <a class="post-title text-hover-secondary" href="{$vl.slug|url_news_detail:$vl.cat_slug}"><h4 class="mb-0 text-uppercase">{$vl.title|stripslashes}</h4></a>
                                        <p class="text-truncated fs-6 pt-3">{$vl.short|stripslashes}</p><hr class="my-4">
                                    </div>
                                {/foreach}
                            {/if}
                            <a class="link-more text-hover-secondary" href="{'news'|url_menu_page}" title="{$lable.view_all_news}">{$lable.view_all_news}<i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2-nav" role="tabpanel" aria-labelledby="tab2">
                        <div class="post">
                            {assign var=news_2 value=$news_sub_2.news}
                            {if $news_2}
                                {foreach from=$news_2 item=vl}
                                    <div class="post-item">
                                        <a class="post-title text-hover-secondary" href="{$vl.slug|url_news_detail:$vl.cat_slug}"><h4 class="mb-0">{$vl.title|stripslashes}</h4></a>
                                        <p class="text-truncated fs-6 pt-3">{$vl.short|stripslashes}</p><hr class="my-4">
                                    </div>
                                {/foreach}
                            {/if}
                            <a class="link-more text-hover-secondary" href="{'news'|url_menu_page}" title="{$lable.view_all_news}">{$lable.view_all_news}<i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3-nav" role="tabpanel" aria-labelledby="tab3">
                        <div class="post">
                            {assign var=news_3 value=$news_sub_3.news}
                            {if $news_3}
                                {foreach from=$news_3 item=vl}
                                    <div class="post-item">
                                        <a class="post-title text-hover-secondary" href="{$vl.slug|url_news_detail:$vl.cat_slug}"><h4 class="mb-0">{$vl.title|stripslashes}</h4></a>
                                        <p class="text-truncated fs-6 pt-3">{$vl.short|stripslashes}</p><hr class="my-4">
                                    </div>
                                {/foreach}
                            {/if}
                            <a class="link-more text-hover-secondary" href="{'news'|url_menu_page}" title="{$lable.view_all_news}">{$lable.view_all_news}<i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4-nav" role="tabpanel" aria-labelledby="tab4">
                        <div class="post">
                            {assign var=news_4 value=$news_sub_4.news}
                            {if $news_4}
                                {foreach from=$news_4 item=vl}
                                    <div class="post-item row gx-4">
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <a href="{$vl.short|stripslashes}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video">
                                            <span class="post-thumb ani-zoomIn">
                                                <figure class="thumbnail-centered thumbnail--6x4">{include file="inc/image_news.tpl" thumbnail=$vl.path_image_thumb image=$vl.path_image title=$vl.title}</figure>
                                                <i class="icon-play"></i>
                                            </span>
                                            </a>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="post-date text-primary"><i class="bi bi-clock"></i><span>{$vl.date_add|date_format:"%d/%m/%Y"}</span></div>
                                            <a class="post-title text-hover-secondary" href="{$vl.slug|url_news_detail:$vl.cat_slug}"><h4 class="mb-0">{$vl.title|stripslashes}</h4></a>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                {/foreach}
                            {/if}
                            <a class="link-more text-hover-secondary" href="{'news'|url_menu_page}" title="{$lable.view_all_news}">{$lable.view_all_news}<i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<section class="section-partner bg-light py-4">
<div class="container">
    <div class="heading"><h4 class="heading-title">{$lable.footer_menu_partner}</h4></div>
    <div class="partner-slider">
        {foreach from=$partners item=partnerItem}
        <div class="partner-slider-item">
            <div class="partner-slider-thumb ani-zoomOut">
                {if $partnerItem.link_click != '' & $partnerItem.link_click != '#'}
                    <a href="{$partnerItem.link_click}" target="_blank">
                        <figure class="thumbnail-centered thumbnail--6x4"><img src="{$link_upload}/{$partnerItem.banner_file}" loading="lazy" alt="{$partnerItem.title|stripslashes}"></figure>
                    </a>
                {else}
                    <figure class="thumbnail-centered thumbnail--6x4"><img src="{$link_upload}/{$partnerItem.banner_file}" loading="lazy" alt="{$partnerItem.title|stripslashes}"></figure>
                {/if}
            </div>
        </div>
        {/foreach}
    </div>
</div>
</section>
<section class="section section-cta">
    <div class="container">
        <div class="row">
            <div class="col-8 col-lg-8">
                <h2>{$lable.cta|stripslashes}</h2>
            </div>
            <div class="col-4 col-lg-4">
                <a href="https://www.panpic.vn/lien-he" class="btn btn-warning">Nhận tư vấn kỹ thuật</a>
            </div>
        </div>
    </div>
</section>
</main>
{include file="footer.tpl"}
