<?php
function smarty_modifier_url_fe_portfolio_year($slug)
{
    $ci = &get_instance();

    if ($ci->langUrl == LANG_EN) {
        $link_url = $ci->langUrl . '/portfolio/year-';
    } else {
        $link_url = 'du-an/nam-';
    }
    $link_url .= ($slug != '') ? "$slug" : '';

    return base_url($link_url);
}