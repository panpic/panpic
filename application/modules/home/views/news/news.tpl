{include file="header.tpl"}
<main class="main-content" id="main-content">
    <div class="container">
        {include file="breadcrumb.tpl"}
        <section class="page-content">
            <div class="row">
                <div class="col-lg-8 order-lg-1">
                    <div class="heading mt-0">
                        <h1 class="heading-title lh-base h3">{$lable.mn_news}</h1>
                    </div>
                    {if $totalItems == 0}
                        <div class="row gx-2 gx-sm-3">
                            <div class="box-empty">{$lable.updating}</div>
                        </div>
                    {else}
                        <div class="row gx-2 gx-sm-3">
                            {foreach from=$news key=$newsKey item=newsItem}
                                {if $newsKey == 0}
                                    <div class="col-12 mb-4">
                                        <h5 class="post-title post-title-lg text-uppercase">
                                            <a href="{$newsItem.slug|url_news_detail:$newsItem.blog_id}"
                                               title="{$newsItem.title}" class="text-uppercase">{$newsItem.title|stripslashes}</a>
                                        </h5>
                                        <div class="nav list-unstyled single-meta">
                                            <i class="bi bi-clock me-1"></i>
                                            <span>{$newsItem.date_add|date_format:"%d/%m/%Y %H:%m"}</span>
                                        </div>
                                        <div class="post-thumb my-3">
                                            <a class="ani-opa05"
                                               href="{$newsItem.slug|url_news_detail:$newsItem.blog_id}"
                                               title="{$newsItem.title}">
                                                <figure class="thumbnail-object-fit thumbnail--6x3 ani-zoom">
                                                    {include file="inc/image_news.tpl"
                                                    thumbnail=$newsItem.path_image
                                                    image=$newsItem.path_image
                                                    title=$newsItem.titl|stripslashes}
                                                </figure>
                                            </a>
                                            <p class="post-desc pt-3">{$newsItem.short|stripslashes}</p>
                                        </div>
                                    </div>
                                {else}
                                    <div class="col-12 mb-3">
                                        <div class="row gx-2 gx-sm-3">
                                            <div class="col-5 col-md-4">
                                                <a class="ani-opa05"
                                                   href="{$newsItem.slug|url_news_detail:$newsItem.blog_id}"
                                                   title="{$newsItem.title}">
                                                    <figure class="thumbnail-object-fit thumbnail--6x4 ani-zoom">
                                                        {include file="inc/image_news.tpl"
                                                        thumbnail=$newsItem.path_image_thumb
                                                        image=$newsItem.path_image
                                                        title=$newsItem.title|stripslashes}
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="col-7 col-md-8 content-6-line">
                                                <h5 class="post-title text-uppercase">
                                                    <a href="{$newsItem.slug|url_news_detail:$newsItem.blog_id}"
                                                       title="{$newsItem.title}">{$newsItem.title|stripslashes}</a>
                                                </h5>
                                                <div class="nav list-unstyled single-meta mb-2">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <span>{$newsItem.date_add|date_format:"%d/%m/%Y %H:%m"}</span>
                                                </div>
                                                <p class="post-desc d-none d-sm-block">{$newsItem.short|stripslashes}</p>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                        <div class="row justify-content-center py-4">
                            {$links}
                        </div>
                    {/if}
                </div>
                {include file="sidebar.tpl"}
            </div>
        </section>
    </div>
</main>
{include file="footer.tpl"}
