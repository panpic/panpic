<?php
function smarty_modifier_url_news_cat($slug){

    /*
    $ci = &get_instance();

    if($ci->langUrl == LANG_EN) {

        $link_url = $ci->langUrl.'/news';
    } else {
        $link_url = 'tin-tuc';
    }

    if($slug != '') {
        $link_url .= "/$slug";
    }
    */

    return base_url($slug);
}