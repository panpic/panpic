<?php
function smarty_modifier_url_portfolio_detail($cat_slug, $slug){
	$ci = &get_instance();
	return $ci->base_url."/du-an/$cat_slug/$slug";
}
