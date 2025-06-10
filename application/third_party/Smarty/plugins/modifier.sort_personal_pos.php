<?php

function smarty_modifier_sort_personal_pos($arr) {
    if(!$arr) return;

    $ci = &get_instance();
    $ci->load->model('blogs_model');
    $ci->load->library('home_library');

    return $ci->home_library->parsePos($arr);
}
