<?php
function smarty_modifier_url_document_download($slug, $blog_id)
{
    $ci = &get_instance();

    if ($ci->langUrl == LANG_EN) {
        $link_url = $ci->langUrl.'/download';
    } else {
        $link_url = 'download';
    }

    $link_url .= "/$slug-$blog_id.html";
    return base_url($link_url);
}
