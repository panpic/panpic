{include file="header.tpl"}
<main class="main-content" id="main-content">
    <section class="section">
        <div class="container">
            {include file="widget/breadcrumb_about.tpl"}
            <div class="row">
                <div class="col-xl-9 col-lg-8 order-lg-1">
                    <div class="heading justify-content-end mb-5">
                        <h1 class="heading-title single-title">{$lable.all_portfolio}</h1>
                    </div>
                    <div class="row gx-4 mt-4">
                        {foreach from=$portfolio item=portfolioItem}
                        <div class="col-sm-6 col-lg-4 mb-4">
                            <a class="post-item ani-zoomIn" href="{$portfolioItem.slug|url_fe_portfolio_detail:$portfolioItem.cat_slug}">
                                <figure class="thumbnail-centered thumbnail--4x3 border rounded-top">
                                    {include file="inc/image_portfolio.tpl"
                                    thumbnail=$portfolioItem.path_image_thumb
                                    image=$portfolioItem.path_image
                                    title=$portfolioItem.title}
                                </figure>
                                <h6 class="mt-2 text-center">{$portfolioItem.title|stripslashes}</h6>
                            </a>
                        </div>
                        {/foreach}
                        <div class="d-flex justify-content-center py-4">
                            {$links}
                        </div>
                    </div>
                </div>
                {include file="sidebar-portfolio.tpl"}
            </div>
        </div>
    </section>
</main>
{include file="footer.tpl"}