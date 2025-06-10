<?php
function smarty_modifier_url_fe_service_detail($slug, $blog_id = 0)
{
    return base_url($slug);

    /*
    $ci = &get_instance();
    if ($ci->langUrl == LANG_EN) {
        $link_url = $ci->langUrl . '/services';
    } elseif ($ci->langUrl == LANG_ZH)
        $link_url = $ci->langUrl . '/services';
    else {
        $link_url = 'dich-vu';
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
