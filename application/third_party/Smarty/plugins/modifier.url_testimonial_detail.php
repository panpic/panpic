<?php
function smarty_modifier_url_testimonial_detail($slug, $cat_slug){
    return base_url("$cat_slug/$slug");
}