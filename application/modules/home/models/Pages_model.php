<?php
/**
 * Model frontend Pages
 * Last update 16 Feb 2020
 *
 * @package frontend
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: PHP Developer
 * @since 16 Feb 2020
 */

class Pages_model extends MY_Model
{
    private $_view_page = 'view_pages';

    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getPageBy($cond = '', $field = "page_id, page_slug, page_title, page_short, page_detail, seo_title, seo_description")
    {
        $sql = "SELECT $field FROM $this->_view_page WHERE $cond ORDER BY date_add DESC";
        return $this->db->query($sql)->row_array();
    }
}