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
function smarty_modifier_comment_counter_lasttime($blog_id) {
    $ci = &get_instance();
    $ci->load->model('comments_model');
    return $ci->comments_model->getDateTimeAndTotalComment($blog_id);
}
