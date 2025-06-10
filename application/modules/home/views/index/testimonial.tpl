<div class="news-slider slick-custom">
{foreach from=$testimonial item=nn}
{assign var=title value=$nn.title|stripslashes}{assign var=link value=$nn.slug|url_testimonial_detail:$nn.cat_slug}
<div class="news-slider-item"><div class="card h-13"><a class="post-link ani-zoomIn" href="{$link}" title="{$title}"><figure class="thumbnail-centered thumbnail--16x9 thumbnail-md--4x3">{include file="inc/image_news.tpl" thumbnail=$nn.path_image image=$nn.path_image title=$title}</figure></a><div class="card-body"><div class="post-body"><div class="post-date">{$nn.date_add|date_format:"%d/%m/%Y"}</div><a class="text-hover-primary" href="{$link}" title="{$title}"><p class="mb-0 max-2-line fst-italic">{$title}</p></a></div></div></div></div>
{/foreach}
</div>