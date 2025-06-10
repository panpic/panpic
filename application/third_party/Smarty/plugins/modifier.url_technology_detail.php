<?php
function smarty_modifier_url_technology_detail($slug, $blog_id = 0)
{
    $ci = &get_instance();
    if ($ci->langUrl == LANG_EN) {
        $link_url = $ci->langUrl . '/technology';
    } elseif ($ci->langUrl == LANG_ZH)
        $link_url = $ci->langUrl . '/technology';
    else {
        $link_url = 'ky-thuat-nganh';
    }

    if ($slug != '') {
        if ($blog_id > 0) {
            $link_url .= "/$slug-$blog_id.html";
        } else {
            $link_url .= "/$slug.html";
        }

    }

    return base_url($link_url);
}
