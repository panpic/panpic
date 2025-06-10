<?php
function smarty_modifier_url_document_cat($slug){

    $ci = &get_instance();

    if($ci->langUrl == LANG_EN) {

        $link_url = $ci->langUrl.'/document';
    } else {
        $link_url = 'tai-lieu';
    }

    if($slug != '') {
        $link_url .= "/$slug";
    }

    return base_url($link_url);
}