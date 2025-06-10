{include file="header.tpl"}
<main class="main-content" id="main-content">
    <section class="section">
        <div class="container">
            {include file="widget/breadcrumb_about.tpl"}
            <div class="row">
                <div class="col-xl-9 col-md-8 col-lg-8 order-lg-1">
                    <div class="heading">
                        <h1 class="heading-title single-title">{$portfolio.title_2|stripslashes}</h1>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-auto offset-md-9 mb-5">
                            <ul class="social-share d-flex mb-0">
                                <li class="me-2 category mt-1">Share</li>
                                <li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ bài viết lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ bài viết lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ bài viết lên linked" target="_blank"><i class="fa bi-linkedin"></i></a></li>
                                <li>
                                    <div class="zalo-share-button"  data-oaid="1069300263628412773" data-layout="2" data-color="blue" data-customize="false"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="nav flex-column flex-sm-row justify-content-start justify-content-sm-between">
                        <li class="nav-item fw-normal"><span>{$lable.year}:</span><span class="text-primary ms-2">{$portfolio.year}</span></li>
                        {**
                        <li class="nav-item fw-normal"><span>{$lable.by_zone}:</span><span class="text-primary ms-2">{$location.cat_name}</span></li>
                        **}
                        <li class="nav-item fw-normal">
                            <span>{$lable.portfolio_function}:</span>
                            <span class="text-primary ms-2">{$category.cat_name}</span>
                        </li>
                    </ul>
                    <div class="row project-detail mt-5 justify-content-center">
                        <div class="col-xxl-8 col-lg-10">
                            <div class="project-content">
                                <div class="project-item">
                                    <figure class="thumbnail-centered thumbnail--4x3">
                                        {if !$portfolio.path_image}
                                            <img src="{$no_image_portfolio}" alt="PANPIC default">
                                        {else}
                                            <img src="{$link_upload}/{$portfolio.path_image}" alt="{$portfolio.title|stripslashes}">
                                        {/if}
                                    </figure>
                                </div>
                                {if count($gallery)}
                                {foreach from=$gallery item=gg}
                                <div class="project-item">
                                    <figure class="thumbnail-centered thumbnail--4x3">
                                        {if !$gg.path_image}
                                            <img src="{$no_image_portfolio}" alt="{$gg.title}">
                                        {else}
                                            <img src="{$link_upload}/{$gg.path_image}" alt="{$gg.title}">
                                        {/if}
                                    </figure>
                                </div>
                                {/foreach}
                                {/if}
                            </div>
                            <div class="project-thumb">
                                <div class="project-item">
                                    <figure class="thumbnail-centered thumbnail--4x3">
                                        {if !$portfolio.path_image}
                                            <img src="{$no_image_portfolio}" alt="PANPIC default">
                                        {else}
                                            <img src="{$link_upload}/{$portfolio.path_image}" alt="{$portfolio.title|stripslashes}">
                                        {/if}
                                    </figure>
                                </div>
                                {if count($gallery)}
                                {foreach from=$gallery item=gg}
                                <div class="project-item">
                                    <figure class="thumbnail-centered thumbnail--4x3">
                                        {if !$gg.path_image}
                                            <img src="{$no_image_portfolio}" alt="PANPIC default">
                                        {else}
                                            <img src="{$link_upload}/{$gg.path_image}" alt="{$gg.title|stripslashes}">
                                        {/if}
                                    </figure>
                                </div>
                                {/foreach}
                                {/if}
                            </div>
                        </div>
                    </div>
                    <div class="heading mt-7">
                        <h5 class="heading-title">{$lable.lable_portfolio_architecture}</h5>
                    </div>
                    <ul class="navbar-nav list-unstyled fs-6">
                        <li class="nav-item row">
                            <span class="col-4 col-sm-4 col-xl-3 border-sm-end py-2 fw-bold">Clients:</span>
                            <span class="col py-2 {if $portfolio.portfolio_clients eq ''}ms-2 empty{/if}">{$portfolio.portfolio_clients|stripslashes}</span>
                        </li>
                        <li class="nav-item row">
                            <span class="col-4 col-sm-4 col-xl-3 border-sm-end py-2 fw-bold">Skills:</span>
                            <span class="col py-2 {if $portfolio.portfolio_skills eq ''}ms-2 empty{/if}">{$portfolio.portfolio_skills|stripslashes}</span>
                        </li>
                        <li class="nav-item row">
                            <span class="col-4 col-sm-4 col-xl-3 border-sm-end py-2 fw-bold">Danh mục:</span>
                            <span class="col py-2 {if $category.cat_name eq ''}ms-2 empty{/if}">{$category.cat_name}</span>
                        </li>
                        <li class="nav-item row">
                            <span class="col-4 col-sm-4 col-xl-3 border-sm-end py-2 fw-bold">Ngày:</span>
                            <span class="col py-2 {if $portfolio.date_add eq ''}ms-2 empty{/if}">{$portfolio.date_add|date_format:"%d-%m-%Y"}</span>
                        </li>
                    </ul>
                    {if $portfolio.content neq ''}
                        <div class="row pt-5">
                            <div class="col-sm-12 col-md-12 post-format">
                                {$portfolio.content|stripslashes}
                            </div>
                        </div>
                    {/if}
                </div>
                {include file="sidebar-portfolio.tpl"}
            </div>
        </div>
    </section>
    {if count($portfolioRelated)}
    <section class="section bg-light">
        <div class="container">
            <div class="heading"><h4 class="heading-title">{$lable.portfolio_related}</h4></div>
            <div class="project-slider slick-custom">
                {foreach from=$portfolioRelated item=rr}
                <div class="project-slider-item">
                    <a class="post-item ani-zoomIn" href="{$rr.slug|url_fe_portfolio_detail:$rr.cat_slug}">
                        <figure class="thumbnail-centered thumbnail--4x3">
                            {include file="inc/image_portfolio.tpl" thumbnail=$rr.path_image_thumb image=$rr.path_image title=$rr.title|stripslashes}
                        </figure>
                        <h6 class="mt-2 text-center">{$rr.title|stripslashes}</h6>
                    </a>
                </div>
                {/foreach}
            </div>
        </div>
    </section>
    {/if}
</main>
{literal}<script>$(document).ready(function(){ $('.post-format img').addClass('img-fluid');});</script>{/literal}
{include file="footer.tpl"}
