<?php
/**
 * Model Front-end
 * Last update 15 Jun 2020
 *
 * @package Front-end
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: PHP Developer
 * @since 15 Jun 2020
 */

class Video_model extends MY_Model
{

    private $_view_video = 'view_video';

    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getVideo($cond = '', $num = 0, $offset = 0, $field = "slug, title, short, path_image, path_image_thumb, date_add ")
    {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';
        $sql = "SELECT $field FROM $this->_view_video WHERE $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @return mixed
     */
    function counterVideo($cond = '')
    {
        $sql = "SELECT count(blog_id) AS total FROM $this->_view_video WHERE $cond";
        return $this->db->query($sql)->row()->total;
    }

}
