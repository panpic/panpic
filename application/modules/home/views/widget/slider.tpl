<section class="main-slider" id="sub-slider">
    {foreach from=$banners item=bn}
        <div class="main-slider-item">
            <figure class="main-slider-thumb thumbnail-object-fit">
                <img src="{$link_upload}/{$bn.banner_file}" alt="{$bn.title|stripslashes}" alt="{$bn.title|stripslashes}">
            </figure>
            <div class="main-slider-content">
                <h2 class="text-primary">{$bn.title|stripslashes}</h2>
                <p class="text-primary"><strong>{$bn.short|stripslashes}</strong></p>
                <p class="text-primary text-justify">{$bn.content|stripslashes}</p>
                {if $bn.link_click neq ''}
                <a class="btn btn-primary mt-sm-4 mt-3" href="{$bn.link_click|stripslashes}" title="{$lable.view_more}">
                    <span class="me-2">{$lable.view_more}</span>
                    <i class="icon icon-btn-arrow"></i>
                </a>
                {/if}
            </div>
        </div>
    {/foreach}
</section>