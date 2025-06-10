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
 * @param int  $tour_id
 * 
 * @return array
 */
function smarty_modifier_getdaysnight($tour_id)
{
    $ci = &get_instance();
    $ci->load->model('Days_model');
    return $ci->Days_model->getNightDays($tour_id);
}
