<?php

function smarty_modifier_get_kienthuc($category_id, $num=0, $offset=0, $select='') {
    if(!$category_id) return;

    $ci = &get_instance();
    $ci->load->model('blogs_model');

    $cond = " WHERE category_id = $category_id ";
    return $ci->blogs_model->getKienThucItems($cond, $num, $offset, $select);
}
