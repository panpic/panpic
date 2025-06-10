<?php
function smarty_modifier_rss_regreplace($text){
    return preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text);
}
