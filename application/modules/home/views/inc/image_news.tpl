{if $thumbnail}
    <img src="{$link_upload}/{$thumbnail}" loading="lazy" alt="{$title}">
{elseif $image}
    <img src="{$link_upload}/{$image}" loading="lazy" alt="{$title}">
{else}
    <img src="{$no_image_news}" loading="lazy" alt="{$title}">
{/if}