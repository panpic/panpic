{if $seo.seo_last_update neq ''}{assign var=seo_last_update value=$seo.seo_last_update}{else}{assign var=seo_last_update value={""|date_format_t}}{/if}
{if $seo.seo_image neq ''}{assign var=img_seo value=$seo.seo_image}{else}{assign var=img_seo value="`$lable.avatar_default`"}{/if}
<script type="application/ld+json">
 {
    "@context":"https://schema.org",
    "@type":"Person",
    "@id":"https://www.panpic.vn/author/nguyen-van-bang#person",
    "name":"Nguyễn Văn Bàng",
    "url":"https://www.panpic.vn/author/nguyen-van-bang",
    "image":"https://www.panpic.vn/nguyen-van-bang.webp",
    "jobTitle":"Founder & CEO",
    "worksFor":{
        "@id":"https://www.panpic.vn/#organization"
    },
    "description":"Founder & CEO Panpic..."
}
</script>
