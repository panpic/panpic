<?php
function smarty_modifier_url_sidebar_news_cat($slug, $parents)
{
    $ci = &get_instance();

    if ($parents == PARENT_CAT_CULTURE) {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/culture';
        } elseif ($ci->langUrl == LANG_ZH)
            $link_url = $ci->langUrl . '/culture';
        else {
            $link_url = 'van-hoa-doanh-nghiep';
        }
    } else {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/news';
        } elseif ($ci->langUrl == LANG_ZH)
            $link_url = $ci->langUrl . '/news';
        else {
            $link_url = 'tin-tuc';
        }
    }

    $link_url .= ($slug != '') ? "/$slug" : '';

    return base_url($link_url);

}
