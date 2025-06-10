<?php
function smarty_modifier_url_home($slug=''){
    $ci = &get_instance();
    $link_url = ($ci->langUrl == LANG_VI) ? '' : "/$ci->langUrl";
    return base_url($link_url);
}
