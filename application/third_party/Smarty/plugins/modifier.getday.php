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
function smarty_modifier_getday($tour_id)
{
    $ci = &get_instance();
    $ci->load->model('Tour_model');
    return $ci->Tour_model->getDay($tour_id);
    
}
