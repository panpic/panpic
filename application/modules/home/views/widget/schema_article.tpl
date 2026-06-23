{if $seo.seo_last_update neq ''}{assign var=seo_last_update value=$seo.seo_last_update}{else}{assign var=seo_last_update value={""|date_format_t}}{/if}
{if $seo.seo_image neq ''}{assign var=img_seo value=$seo.seo_image}{else}{assign var=img_seo value="`$lable.avatar_default`"}{/if}
<script type="application/ld+json">
 {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{$seo.seo_title|stripslashes}",
    "image": "{$img_seo}",
    "author":
    {
        "@type": "Person",
        "name": "Nguyễn Văn Bàng"
    },
    "publisher":
    {
        "@type": "Organization",
        "name": "Công ty Panpic đối tác tin cậy thiết kế website tại TP HCM. Nguyễn Văn Bàng",
        "logo": {
            "@type": "ImageObject",
            "url": "https://www.panpic.vn/assets/front/images/logo.png"
        }
    },
    "datePublished": "{$seo.seo_date_add}",
    "dateModified": "{$seo_last_update}"
}
</script>
