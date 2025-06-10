{include file="header.tpl"}
<main class="main-content" id="main-content">
    <section class="section">
        <div class="container">
            {include file="widget/breadcrumb_about.tpl"}

            <div class="tab-content">
                <h1 class="single-title text-uppercase">{$tags.title|stripslashes}</h1>
                <div class="tab-pane active" id="tab1-nav" role="tabpanel" aria-labelledby="tab1">
                    <article>
                    <div class="post">
                        <div class="row gx-4">
                            <div class="col-12 col-lg-12">
                                <h3>{$tags.short|stripslashes}</h3>
                            </div>
                        </div>
                    </div>
                    </article>
                    {if !$items}
                        <div class="post">
                            <div class="row gx-4">
                                <div class="col-12 col-lg-12 text-center p-7">
                                    {$lable.updating}
                                </div>
                            </div>
                        </div>
                    {else}
                        <div class="row gx-4 gx-lg-5 video-clip">
                        {if $items}
                            {foreach from=$items item=n}
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
                         {/if}
                        </div>
                        <div class="d-flex justify-content-center py-4">
                            {$links}
                        </div>
                    </div>
                {/if}
                <div class="row gx-4 gx-lg-12">
                    <div class="col-md-12">
                        <article>
                        {$tags.content|stripslashes}
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
{include file="footer.tpl"}
