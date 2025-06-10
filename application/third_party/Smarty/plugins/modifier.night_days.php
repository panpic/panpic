<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty spacify modifier plugin
 * Type:     modifier<br>
 * Name:     spacify<br>
 * Purpose:  add spaces between characters in a string
 *
 * @link   http://smarty.php.net/manual/en/language.modifier.spacify.php spacify (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 *
 * @param string $string       input string
 * @param string $spacify_char string to insert between characters.
 *
 * @return string
 */
function smarty_modifier_night_days($tour_id)
{
    // $this->load->model('Days_model');
    $ci= &get_instance();
    return $ci->days_model->getNightDays($tour_id);

}
