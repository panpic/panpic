{if $seo.seo_last_update neq ''}{assign var=seo_last_update value=$seo.seo_last_update}{else}{assign var=seo_last_update value={""|date_format_t}}{/if}
{if $seo.seo_image neq ''}{assign var=img_seo value=$seo.seo_image}{else}{assign var=img_seo value="`$lable.avatar_default`"}{/if}
<script type="application/ld+json">
 {
    "@context":"https://schema.org",
    "@type":"Article",
    "@id":"{$canonical}#article",
    "mainEntityOfPage":{
        "@type":"WebPage",
        "@id":"{$current_url}"
    },
    "headline":"{$seo.seo_title|stripslashes}",
    "description":"{$seo.seo_description}",
    "url":"{$current_url}",
    "inLanguage":"vi-VN",
    "image":{
        "@type":"ImageObject",
        "url":"{$img_seo}"
    },
    "author":{
        "url":"{$base_url}/author/nguyen-van-bang",
        "name":"Nguyễn Văn Bàng",
        "@type":"Person",
        "@id":"https://www.panpic.vn/#person"
    },
    "publisher":{
        "@id":"https://www.panpic.vn/#organization"
    },
    "datePublished":"{$seo.seo_date_add}",
    "dateModified":"{$seo_last_update}"
}
</script>
