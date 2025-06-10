{if $thumbnail}
    <img class="card-img-top" src="{$link_upload}/{$thumbnail}" loading="lazy" alt="{$title}">
{elseif $image}
    <img class="card-img-top" src="{$link_upload}/{$image}" loading="lazy" alt="{$title}">
{else}
    <img class="card-img-top" src="{$no_image_portfolio}" loading="lazy" alt="{$title}">
{/if}