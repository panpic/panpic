<?php
function smarty_modifier_url_search_detail($slug, $cat_slug, $post_type){

    if($post_type == POST_TYPE_BLOG || $post_type == POST_TYPE_FAQ) {
        return base_url("$slug");
    } elseif($post_type == POST_TYPE_PORTFOLIO) {
        return base_url("$cat_slug/$slug");
    }
}