<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty get day modifier plugin
 * Type:     modifier<br>
 * Name:     escape<br>
 * Purpose:  escape string for output
 *
 * @link
 * @author Monte Ohrt <monte at ohrt dot com>
 *
 * @param int  $blog_id
 * 
 * @return array
 */
function smarty_modifier_comment_reply($case_parent) {
    $ci = &get_instance();

    $ci->load->model('Blog_model');
    $arr = $ci->Blog_model->commentsReply($case_parent);
    $total = sizeof($arr);
    $temp = '';
    if($total > 0) {
        $temp = array(
            'total' => $total,
            'comments' => $arr
        );
    }

    return $temp;
}
