<?php
function smarty_modifier_url_blog_detail($slug){
	$ci = &get_instance();
	return $ci->base_url."/blogs/$slug".$ci->lable['link_ext'];
}
