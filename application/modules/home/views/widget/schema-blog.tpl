{if $seo.seo_image neq ''}{assign var=img_seo value=$seo.seo_image}{else}{assign var=img_seo value="`$lable.avatar_default`"}{/if}
<script type="application/ld+json">
{
    "@context":"http:\/\/schema.org\/",
    "@type":"NewsArticle",
    "mainEntityOfPage":
    {
        "@type":"WebPage",
        "@id":"{$current_url}"
    },
    "url":"{$current_url}",
    "headline":"{$seo.seo_title|replace:'"':''}",
    "datePublished":"{$seo.datePublished}",
    "dateModified":"{$seo.dateModified}",
    "publisher":
    {
        "@type":"Organization",
        "@id":"https:\/\/www.panpic.vn\/#organization",
        "name":"CÔNG TY TNHH CÔNG NGHỆ PANPIC",
        "logo":
            {
                "@type":"ImageObject",
                "url":"https://www.panpic.vn/panpic-logo.png",
                "width":971,
                "height":210
            }
    },
    "image":
    {
        "@type": "ImageObject",
            "inLanguage": "vi",
            "url": "{$img_seo}",
            "width": "790",
            "height": "510",
            "caption": "{$seo.seo_image_alt}",
            "representativeOfPage": "True",
            "contentSize": "107.9 Kb",
            "encodingFormat": ".webp",
            "description": "{$seo.seo_description|replace:'"':''}",
            "accessMode": "visual",
            "license": "{$current_url}",
            "acquireLicensePage": "{$current_url}",
            "creditText": "{$seo.seo_image_alt}",
            "creator": {
                "@type": "Person",
                "name": "Bang Andre"
            },
            "copyrightNotice": "Panpic"
    },
    "articleSection":"{$seo.articleSection|replace:'"':''}",
    "description":"{$seo.seo_description|replace:'"':''}",
    "author":
    {
        "@type":"Person",
        "name":"Bang Nguyen",
        "url":"https:\/\/www.panpic.vn\/author\/panpicteam\/",
        "description":"{$lable.schema_author_description}",
        "image":
            {
                "@type":"ImageObject",
                "url":"https://www.panpic.vn/panpic-logo.png",
                "height":690,
                "width":690
            },
        "sameAs":[
            "https://www.linkedin.com/company/panpic",
            "https://panpic.tumblr.com",
            "https://www.youtube.com/@PanpicVn",
            "https://www.pinterest.com/panpic_vn",
            "https://www.instagram.com/panpic.vn/",
            "https://x.com/panpic_vn",
            "https://g.co/kgs/ZmL8aup",
            "https://www.behance.net/nhantam",
            "https://www.reddit.com/user/Ok-Ad-1237/",
            "https://www.facebook.com/panpic.vn",
            "https://www.flickr.com/photos/phpdeveloper/",
            "https://github.com/panpic"
            ]
    }
}
</script>