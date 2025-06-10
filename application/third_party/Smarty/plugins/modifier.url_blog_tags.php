<?php
function smarty_modifier_url_blog_tags($slug){
	$ci = &get_instance();
	
	return $ci->base_url."/tag/$slug";
}
