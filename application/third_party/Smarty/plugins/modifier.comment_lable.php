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
function smarty_modifier_comment_lable($blog_id) {
    $ci = &get_instance();
    $ci->load->model('comments_model');
    $row = $ci->comments_model->getDateTimeAndTotalComment($blog_id);

    $str = $row['total_comments'].' '.$ci->lable['comment'];
    if($row['total_comments'] > 0) {
        $str .= ' | '.$ci->lable['before'].' ';

        if ($row['post_before_minutes'] <= 60) {
            $str .= $row['post_before_minutes'].' '.$ci->lable['minute'];
        }elseif ($row['post_before_hours'] <= 24) {
            $str .= $row['post_before_hours'].' '.$ci->lable['hours'];
        } else {
            $str .= $row['post_before_days'].' '.$ci->lable['day'];
        }

    }

    return $str;
}
