{include file="header.tpl"}
<main class="main-content" id="main-content">
    <header class="author-hero">
        <div class="container">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-lg-12">
                    {include file="widget/breadcrumb_about.tpl"}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-0 mt-0">Tác giả Nguyễn Văn Bàng</h1>
                </div>
                <div class="col-lg-12">
                    {include file="news/person/author_1.tpl"}
                </div>
            </div>
        </div>
    </header>
    <section class="author-about">
        <div class="container">
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-12">
                    {include file="news/person/author_2.tpl"}
                </div>
            </div>
        </div>
    </section>

    <section class="section author-articles">
        <div class="container">



                        <div class="row gx-4 gx-lg-5 row-custom video-clip">
                            <div class="col-lg-8 mb-4 mb-lg-5">
                                <a class="post-link ani-zoomIn"
                                   {if $hot_1.category_id eq PARENT_CAT_VIDEO}
                                       href="{$hot_1.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                   {else}
                                    href="{$hot_1.slug|url_news_detail:$hot_1.cat_slug}"
                                   {/if}
                                   title="{$hot_1.title|stripslashes}">
                                    <figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
                                        {include file="inc/image_news.tpl"
                                        thumbnail=$hot_1.path_image
                                        image=$hot_1.path_image
                                        title=$hot_1.title|stripslashes}
                                        {if $hot_1.category_id eq PARENT_CAT_VIDEO}
                                            <i class="video-play"></i>
                                        {/if}
                                    </figure>
                                    <div class="post-content">
                                        <div class="post-date">
                                            <i class="bi bi-clock"></i>
                                            <span>{$hot_1.date_add|date_format:"%d/%m/%Y"}</span>
                                        </div>
                                        <h6 class="post-title mb-0">{$hot_1.title|stripslashes}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <div class="row gx-4 gx-lg-5">
                                    {if $hot_2}
                                    <div class="col-md-6 col-lg-12 mb-4 mb-lg-5">
                                        <a class="post-link ani-zoomIn"
                                           {if $hot_2.category_id eq PARENT_CAT_VIDEO}
                                            href="{$hot_2.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                           {else}
                                            href="{$hot_2.slug|url_news_detail:$hot_2.cat_slug}"
                                           {/if}
                                           title="{$hot_2.title|stripslashes}">
                                            <figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
                                                {include file="inc/image_news.tpl"
                                                thumbnail=$hot_2.path_image
                                                image=$hot_2.path_image
                                                title=$hot_2.title|stripslashes}
                                                {if $hot_2.category_id eq PARENT_CAT_VIDEO}
                                                    <i class="video-play"></i>
                                                {/if}
                                            </figure>
                                            <div class="post-content">
                                                <div class="post-date">
                                                    <i class="bi bi-clock"></i>
                                                    <span>{$hot_2.date_add|date_format:"%d/%m/%Y"}</span>
                                                </div>
                                                <h6 class="post-title mb-0">{$hot_2.title|stripslashes}</h6>
                                            </div>
                                        </a>
                                    </div>
                                    {/if}
                                    {if $hot_3}
                                    <div class="col-md-6 col-lg-12 mb-4 mb-lg-0">
                                        <a class="post-link ani-zoomIn"
                                           {if $hot_3.category_id eq PARENT_CAT_VIDEO}
                                            href="{$hot_3.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                           {else}
                                            href="{$hot_3.slug|url_news_detail:$hot_3.cat_slug}"
                                           {/if}
                                           title="{$hot_3.title|stripslashes}">
                                            <figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
                                                {include file="inc/image_news.tpl"
                                                thumbnail=$hot_3.path_image
                                                image=$hot_3.path_image
                                                title=$hot_3.title|stripslashes}
                                                {if $hot_3.category_id eq PARENT_CAT_VIDEO}
                                                    <i class="video-play"></i>
                                                {/if}
                                            </figure>
                                            <div class="post-content">
                                                <div class="post-date">
                                                    <i class="bi bi-clock"></i>
                                                    <span>{$hot_3.date_add|date_format:"%d/%m/%Y"}</span>
                                                </div>
                                                <h6 class="post-title mb-0">{$hot_3.title|stripslashes}</h6>
                                            </div>
                                        </a>
                                    </div>
                                    {/if}
                                </div>
                            </div>

                    </div>
                    <div class="row gx-4 gx-lg-5 video-clip">
                    {if $news}
                        <div class="col-lg-12">
                            <div class="row gx-4 gx-lg-5">

                        {foreach from=$news item=n}
                            <div class="post-item col-md-6 col-lg-4 mb-4 mb-lg-5">
                                <div class="card h-100">
                                    <a class="post-link ani-zoomIn"
                                       {if $n.category_id eq PARENT_CAT_VIDEO}
                                        href="{$n.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                       {else}
                                        href="{$n.slug|url_news_detail:$n.cat_slug}"
                                       {/if}
                                       title="{$n.title|stripslashes}">
                                        <figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
                                            {include file="inc/image_news.tpl"
                                            thumbnail=$n.path_image
                                            image=$n.path_image
                                            title=$n.title|stripslashes}
                                            {if $n.category_id eq PARENT_CAT_VIDEO}
                                                <i class="video-play"></i>
                                            {/if}
                                        </figure>
                                    </a>
                                    <div class="card-body">
                                        <div class="post-body">
                                            <div class="post-date text-primary">
                                                <i class="bi bi-clock"></i>
                                                <span>{$n.date_add|date_format:"%d/%m/%Y"}</span>
                                            </div>
                                            <a class="post-title text-hover-primary"
                                               {if $n.category_id eq PARENT_CAT_VIDEO}
                                                href="{$n.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                               {else}
                                                href="{$n.slug|url_news_detail:$n.cat_slug}"
                                               {/if}
                                               title="{$n.title|stripslashes}">
                                                <h6 class="mb-0">{$n.title|stripslashes}</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                        </div>
                        </div>
                        {/if}
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        {$links}
                    </div>

        </div>

    </section>

    <section class="">
    </section>

</main>
{include file="widget/schema_nguyenvanbang.tpl"}
{include file="footer.tpl"}
