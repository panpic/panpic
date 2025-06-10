<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Công nghệ thiết kế website</title>
        <link>https://www.panpic.vn/rss/news.rss</link>
        <description>Các tin Công nghệ thiết kế website từ Công ty thiết kề web Panpic</description>
        {foreach from=$feeds item=nn}
            {assign var=short value=$nn.short|stripslashes|rss_regreplace|strip_tags}
            {if $short}
            <item>
                <title>{$nn.title|stripslashes|rss_regreplace|strip_tags}</title>
                <link>{$nn.slug|url_news_detail:$nn.blog_id}</link>
                <description>{$short}</description>
                <pubDate>{$nn.date_add|date_format:"%a, %d %b %Y %H:%M:%S"} GMT</pubDate>
            </item>
            {/if}
        {/foreach}
    </channel>
</rss>