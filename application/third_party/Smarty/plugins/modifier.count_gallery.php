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
 * @param int $album_id
 * 
 * @return array
 */
function smarty_modifier_count_gallery($album_id, $post_type = '') {
    $ci = &get_instance();
    $ci->load->model('gallery_model');

    if($post_type != '') {
        $ci->gallery_model->_post_type_album_detail = $post_type;
    }

    $arr = $ci->gallery_model->albumGalleryDetail($album_id);
    return sizeof($arr);
}
