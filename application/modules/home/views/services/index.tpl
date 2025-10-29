{include file="header.tpl"}
<main class="main-content" id="main-content">
    <section class="section page">
        <div class="container">
        {include file="widget/breadcrumb_services.tpl"}
        {include file="services/breadcrumb/{$action}.tpl"}
            <div class="row">
                <div class="col-lg-2 mt-5 mt-lg-0"> &nbsp;</div>
                <div class="col-12 col-xl-10 col-lg-10">
                    <article class="single">
                        <h1 class="single-title text-uppercase">{$service.title|stripslashes}</h1>
                        <div class="row">
                            <div class="col-12 col-md-4 ms-auto">
                                <ul class="social-share d-flex m-0">
                                    <li class="me-2 category mt-1">Share</li>
                                    <li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ dịch vụ lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ dịch vụ lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ dịch vụ lên linkedin" target="_blank"><i class="fa bi-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single-content mb-5 text-justify">{$service.content|stripslashes}</div>
                    </article>
                </div>
                {include file="services/sidebar-table-content.tpl"}
            </div>
        </div>
    </section>
    <section class="section pt-0">
        <div class="container">
            <div class="heading"><p class="heading-title">DỊCH VỤ KHÁC</p></div>
            <div class="news-slider slick-custom">
                {if $services}
                    {foreach from=$services item=vl}
                        {assign var=link value=$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}
                        {assign var=cat_name value=$vl.cat_name|stripslashes}
                        <div class="news-slider-item">
                            <div class="card h-13">
                                <a class="post-link ani-zoomIn" href="{$link}" title="{$cat_name}"><figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">{include file="inc/image_news.tpl" image=$vl.path_image title=$cat_name}</figure></a>
                                <div class="card-body">
                                    <div class="post-body">
                                        <a class="post-title text-hover-primary" href="{$link}" title="{$cat_name}"><p class="mb-0 max-2-line">{$cat_name}</p></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                {/if}
            </div>
        </div>
    </section>
</main>
{include file="services/rating.tpl"}
{include file="footer.tpl"}