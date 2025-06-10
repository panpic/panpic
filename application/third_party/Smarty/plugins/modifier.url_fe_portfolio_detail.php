<?php
function smarty_modifier_url_fe_portfolio_detail($slug, $cat_slug)
{
    /*
    $ci = &get_instance();
    if ($ci->langUrl == LANG_EN) {

        $link_url = $ci->langUrl.'/portfolio';
    } else {
        $link_url = 'du-an';
    }
    if ($slug != '') {
        if ($blog_id > 0) {
            $link_url .= "/$slug-$blog_id.html";
        } else {
            $link_url .= "/$slug.html";
        }
    }
    */

    return base_url("$cat_slug/$slug");
}