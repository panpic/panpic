<?php
function smarty_modifier_url_fe_document_detail($slug, $cat_slug)
{
    return base_url("$cat_slug/$slug");

    /*
    $ci = &get_instance();

    if ($ci->langUrl == LANG_EN) {
        $link_url = $ci->langUrl . '/document';
    } else {
        $link_url = 'tai-lieu';
    }

    if ($slug != '') {
        if ($blog_id > 0) {
            $link_url .= "/$slug-$blog_id.html";
        } else {
            $link_url .= "/$slug.html";
        }
    }
    */
}