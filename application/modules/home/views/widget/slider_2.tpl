<section class="main-slider custom-slide" id="main-slider">
    {foreach from=$banners item=bn}
        <div class="main-slider-item">
            <figure class="main-slider-thumb thumbnail-object-fit">
                <img src="{$link_upload}/{$bn.banner_file}" alt="{$bn.title|stripslashes}">
            </figure>
            <div class="main-slider-content">
                <h2 class="text-primary">{$bn.title|stripslashes}</h2>
                <p class="text-primary"><strong>{$bn.short|stripslashes}</strong></p>
                <p class="text-primary">{$bn.content|stripslashes}</p>
            </div>
        </div>
    {/foreach}
</section>