<?php
function smarty_modifier_url_news_detail($slug, $cat_slug){
    return base_url("$slug");
    // return base_url("$cat_slug/$slug");
}