<?php

function smarty_modifier_count_services_process($blog_id) {
    $ci = &get_instance();
    $ci->load->model('blog_process_translate');
    return $ci->blog_process_translate->counterItems(" WHERE blog_id = $blog_id ");
}
