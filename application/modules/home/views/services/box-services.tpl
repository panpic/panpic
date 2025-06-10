<section class="section pt-0">
    <div class="container">
        <div class="heading">
            <p class="heading-title">DỊCH VỤ KHÁC</p>
        </div>
        <div class="news-slider slick-custom">
            {if $services}
                {foreach from=$services item=vl}
                    {assign var=link value=$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}
                    {assign var=cat_name value=$vl.cat_name|stripslashes}
                    <div class="news-slider-item">
                        <div class="card h-13">
                            <a class="post-link ani-zoomIn" href="{$link}" title="{$cat_name}">
                                <figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">
                                    {include file="inc/image_news.tpl" image=$vl.path_image title=$cat_name}</figure>
                            </a>
                            <div class="card-body">
                                <div class="post-body">
                                    <a class="post-title text-hover-primary" href="{$link}" title="{$cat_name}">
                                        <p class="mb-0 max-2-line">{$cat_name}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
</section>