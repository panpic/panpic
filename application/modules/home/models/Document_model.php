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


class Document_model extends MY_Model
{

    public $lang = 'vi';
    public $post_type = POST_TYPE_DOWNLOAD;
    private $_view_download = 'view_download';
    private $_view_category = 'view_category';


    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getDocumentBy($cond = '', $field = "slug, title, title_2, date_add, seo_title, seo_description, hits, path_image ")
    {
        $sql = "SELECT $field FROM $this->_view_download WHERE $cond ORDER BY date_add DESC";
        return $this->db->query($sql)->row_array();
    }

    /**
     * @param  string  $cond
     * @return mixed
     */
    function counterDocument($cond = '')
    {
        $sql = "SELECT  count(d.blog_id) AS total
            FROM $this->_view_download AS d
            INNER JOIN $this->_view_category AS c ON d.category_id = c.post_cat_id
            WHERE d.post_type = '$this->post_type' $cond";

        return $this->db->query($sql)->row()->total;
    }

    /**
     * @param $cond
     * @return mixed
     */
    function getDocument($cond='', $num = 0, $offset = 0)
    {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';

        $sql = "SELECT d.slug, d.blog_id, d.title, d.path_image, d.path_image_thumb, d.date_add, d.hits, c.cat_name, c.cat_slug, c.seo_title, c.seo_description
            FROM $this->_view_download AS d
            INNER JOIN $this->_view_category AS c ON d.category_id = c.post_cat_id
            WHERE d.post_type = '$this->post_type' $cond
            ORDER BY d.date_add DESC $limit";

        return $this->db->query($sql)->result_array();
    }

    function getCategoryByCond($cond, $fields="c.post_cat_id, c.posts_no, d.cat_name, d.cat_slug, d.seo_title, d.seo_description") {

        $sql = "SELECT $fields FROM pp_post_category AS c 
				JOIN pp_post_category_desc AS d ON c.post_cat_id = d.post_cat_id $cond";

        return $this->db->query($sql)->row_array();
    }

    function getNodeByParentId($parent_id, $cond='', $order=' ORDER BY c.lft ASC ') {
        if($parent_id == '') return;

        $sql = "SELECT c.post_cat_id, c.posts_no, d.cat_name, d.cat_slug 
				FROM pp_post_category AS c 
				JOIN pp_post_category_desc AS d ON c.post_cat_id = d.post_cat_id  
				JOIN (SELECT p.* FROM pp_post_category AS p WHERE p.post_cat_id = $parent_id) AS parent 
				ON c.lft >= parent.lft AND c.rgt <= parent.rgt $cond $order";

        return $this->db->query($sql)->result('array');
    }

}
