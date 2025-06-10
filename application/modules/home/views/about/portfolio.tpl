<section class="section bg-light">
    <div class="container">
        <div class="heading">
            <h4 class="heading-title">{$lable.lable_portfolio_typical_projects}</h4>
        </div>
        <div class="project-slider slick-custom">
            {foreach from=$portfolioRelated item=rr}
                <div class="project-slider-item">
                    <a class="post-item ani-zoomIn" href="{$rr.slug|url_fe_portfolio_detail:$rr.blog_id}">
                        <figure class="thumbnail-centered thumbnail--4x3">
                            {include file="inc/image_portfolio.tpl"
                            thumbnail=$rr.path_image_thumb
                            image=$rr.path_image
                            title=$rr.title|stripslashes}
                        </figure>
                        <h6 class="mt-2 text-center">{$rr.title|stripslashes}</h6>
                    </a>
                </div>
            {/foreach}
        </div>
    </div>
</section>