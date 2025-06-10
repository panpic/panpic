{include file="header.tpl"}
<main class="main-content" id="main-content">
    <section class="section">
        <div class="container">
            {include file="widget/breadcrumb_about.tpl"}
            <div class="row">
                <div class="col-xl-9 col-lg-8 order-lg-1">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1-nav" role="tabpanel" aria-labelledby="tab1">
                            <div class="heading justify-content-end mb-5">
                                <h1 class="heading-title single-title">{$category.cat_name|stripslashes}</h1>
                            </div>
                            {if !$hot_1}
                            <div class="post">
                                <div class="row gx-4">
                                    <div class="col-12 col-lg-12 text-center p-7">
                                        {$lable.updating}
                                    </div>
                                </div>
                            </div>
                            {else}
                            <div class="post">
                                <div class="row gx-4 gx-lg-5 row-custom video-clip">
                                    <div class="col-lg-8 mb-4 mb-lg-5">
                                        <a class="post-link ani-zoomIn"
                                           {if $hot_1.category_id eq PARENT_CAT_VIDEO}
                                               href="{$hot_1.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                           {else}
                                            href="{$hot_1.slug|url_testimonial_detail:$hot_1.cat_slug}"
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
                                                    href="{$hot_2.slug|url_testimonial_detail:$hot_2.cat_slug}"
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
                                                    href="{$hot_3.slug|url_testimonial_detail:$hot_3.cat_slug}"
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
                            </div>
                            <div class="row gx-4 gx-lg-5 video-clip">
                            {if $news}
                                {foreach from=$news item=n}
                                    <div class="post-item col-md-6 col-lg-4 mb-4 mb-lg-5">
                                        <div class="card h-100">
                                            <a class="post-link ani-zoomIn"
                                               {if $n.category_id eq PARENT_CAT_VIDEO}
                                                href="{$n.short}&amp;amp;autoplay=1&amp;amp;rel=0&amp;amp;controls=0&amp;amp;showinfo=0" data-fancybox="video"
                                               {else}
                                                href="{$n.slug|url_testimonial_detail:$n.cat_slug}"
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
                                                        href="{$n.slug|url_testimonial_detail:$n.cat_slug}"
                                                       {/if}
                                                       title="{$n.title|stripslashes}">
                                                        <h6 class="mb-0">{$n.title|stripslashes}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                                {/if}
                            </div>
                            <div class="d-flex justify-content-center py-4">
                                {$links}
                            </div>
                        </div>
                    {/if}
                    </div>
                </div>
                {include file="sidebar-portfolio.tpl"}
            </div>
        </div>
    </section>
</main>
{include file="footer.tpl"}
