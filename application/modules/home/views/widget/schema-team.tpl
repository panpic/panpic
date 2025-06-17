{if $seo.seo_image neq ''}{assign var=img_seo value=$seo.seo_image}{else}{assign var=img_seo value="`$lable.avatar_default`"}{/if}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Nguyễn Văn Bàng",
    "honorificPrefix": "Manager",
    "description": "Quản lý kỹ thuật Nguyễn Văn Bàng là lập trình viên tại Panpic - với hơn 20 năm kinh nghiệm. Đã làm việc qua 3 công ty chuyên oursourcing (2007–2025) và hiện làm việc tại Panpic.",
    "jobTitle": "Lập trình viên",
    "worksFor": [
    {
        "@type": "MedicalClinic",
        "name": "Phòng khám Lao phổi BS.CKII. Nguyễn Văn Tẩn",
        "url": "https://phongkhamlaophoi.com/"
    }
    ],
    "alumniOf": {
    "@type": "CollegeOrUniversity",
    "name": "Đại học Y dược TP.HCM"
    },
    "hasCredential": {
    "@type": "EducationalOccupationalCredential",
    "credentialCategory": "Bác sĩ Chuyên khoa II"
    },
    "hasOccupation": [
    {
        "@type": "Occupation",
        "name": "Bác sĩ điều trị"
    },
    {
        "@type": "Occupation",
        "name": "Trưởng khoa Lao Phổi"
    }
    ],
    "knowsLanguage": ["vi"],
    "knowsAbout": ["Pulmonology"],
    "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+84-91-380-5082",
    "contactType": "Customer Service",
    "availableLanguage": {
        "@type": "Language",
        "name": "Vietnamese"
    }
    },
    "image": "https://phongkhamlaophoi.com/files/2025/06/16/042618-36ecb71d-4d06-4d22-96ce-fefa495a7f01.webp"
}
</script>

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