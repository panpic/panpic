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
 * @link   http://www.smarty.net/docs/en/language.modifier.escape
 * @author Monte Ohrt <monte at ohrt dot com>
 *
 * @param int $member_id
 * 
 * @return array
 */
function smarty_modifier_getmember($member_id) {
    $ci = &get_instance();
    $ci->load->model('members_model');

    $ci->members_model->id = $member_id;
    return $ci->members_model->getMemberById();
}
