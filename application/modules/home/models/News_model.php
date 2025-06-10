<?php
/**
 * Model Front-end
 * Last update 25 Aug 2021
 *
 * @package Front-end
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: PHP Developer
 * @since 15 Jun 2020
 */

class Blog_model extends MY_Model
{

    public $lang = 'vi';
    private $_view_blog = 'view_blog';
    private $_view_blog_history = 'view_blog_history';

    private $_view_category = 'view_category';
    private $_view_testimonial = 'view_testimonial';


    /**
     * @param string $cond
     * @param $limit
     * @param string $field
     * @return mixed
     */
    function getBlogBasic($cond = '', $limit, $orderBy, $field = "cat_slug, slug, blog_id, title, short, path_image, path_image_thumb, date_add ")
    {
        $sql = "SELECT $field FROM $this->_view_blog WHERE $cond $orderBy $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @param string $limit
     * @param string $field
     * @return mixed
     */
    function getBlogBy($cond = '', $field = "a.cat_slug, a.slug, a.title, a.date_add, a.short, a.path_image, a.content, a.seo_title, a.seo_description, a.category_id, a.blog_id, c.cat_name, c.cat_slug ")
    {
        $sql = "SELECT a.*, c.cat_name, c.cat_slug
                FROM $this->_view_blog AS a
                INNER JOIN view_category AS c ON a.category_id = c.post_cat_id $cond";

        return $this->db->query($sql)->row_array();

        // $sql = "SELECT $field FROM $this->_view_blog WHERE $cond ORDER BY date_add DESC";
    }

    function getBlogByQuery($cond = '', $field = "a.cat_slug, a.slug, a.title, a.date_add, a.short, a.path_image, a.content, a.seo_title, a.seo_description, a.category_id, a.blog_id ")
    {
        $sql = "SELECT $field FROM $this->_view_blog AS a $cond ORDER BY a.date_add DESC";
        return $this->db->query($sql)->row_array();
    }

    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getBlog($cond = '', $num = 0, $offset = 0, $field = "cat_slug, category_id, slug, blog_id, title, short, path_image, path_image_thumb, date_add ")
    {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';

        $sql = "SELECT $field FROM $this->_view_blog WHERE $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @return mixed
     */
    function counterBlog($cond = '')
    {
        $sql = "SELECT count(blog_id) AS total FROM $this->_view_blog WHERE $cond";
        return $this->db->query($sql)->row()->total;
    }


    function getNodeByParentId($parent_id, $cond='', $order=' ORDER BY c.lft ASC ') {
        if($parent_id == '') return;

        $sql = "SELECT c.post_cat_id, c.posts_no, d.cat_name, d.cat_slug 
				FROM pp_post_category AS c 
				JOIN pp_post_category_desc AS d ON c.post_cat_id = d.post_cat_id  
				JOIN (SELECT p.* FROM pp_post_category AS p WHERE p.post_cat_id = $parent_id) AS parent 
				ON c.lft >= parent.lft AND c.rgt < parent.rgt AND d.lang = 'vi' $cond $order";

        return $this->db->query($sql)->result('array');
    }

    function getBlogServicesItems($cond = '', $field = "a.slug, a.title, a.date_add, a.short, a.path_image, a.content, a.seo_title, a.seo_description, a.category_id, a.blog_id ")
    {
        $sql = "SELECT $field FROM view_blog_services AS a $cond ORDER BY a.date_add DESC";
        return $this->db->query($sql)->result('array');
    }

    function getBlogServicesByQuery($cond = '', $field = "a.slug, a.title, a.date_add, a.short, a.path_image, a.content, a.seo_title, a.seo_description, a.category_id, a.blog_id ")
    {
        $sql = "SELECT $field FROM view_blog_services AS a $cond ORDER BY a.date_add DESC";
        return $this->db->query($sql)->row_array();
    }


    /**
     * @param string $cond
     * @param $limit
     * @param string $field
     * @return mixed
     */
    function getBlogHistory($cond = '', $limit, $orderBy, $field = "slug, blog_id, title, short, path_image, path_image_thumb, date_add ")
    {
        $sql = "SELECT $field FROM $this->_view_blog_history WHERE $cond $orderBy $limit";
        return $this->db->query($sql)->result_array();
    }


    /**
     * @param string $cond
     * @return mixed
     */
    function counterTestimonial($cond = '')
    {
        $sql = "SELECT count(blog_id) AS total FROM $this->_view_testimonial WHERE $cond";
        return $this->db->query($sql)->row()->total;
    }

    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getTestimonial($cond = '', $num = 0, $offset = 0, $field = "cat_slug, category_id, slug, blog_id, title, short, path_image, path_image_thumb, date_add ")
    {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';
        $sql = "SELECT $field FROM $this->_view_testimonial WHERE $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @param string $limit
     * @param string $field
     * @return mixed
     */
    function getTestimonialBy($cond = '', $field = "a.cat_slug, a.slug, a.title, a.date_add, a.short, a.path_image, a.content, a.seo_title, a.seo_description, a.category_id, a.blog_id, c.cat_name, c.cat_slug ")
    {
        $sql = "SELECT a.*, c.cat_name, c.cat_slug
                FROM $this->_view_testimonial AS a
                INNER JOIN view_category AS c ON a.category_id = c.post_cat_id $cond";

        return $this->db->query($sql)->row_array();
    }


    function countMainProductByCondTags($cond=''){

        $sql = "SELECT COUNT(a.blog_id) AS total 
            FROM $this->_view_blog AS a
            JOIN pp_blog_tags_items AS b ON a.blog_id = b.blog_id 
            JOIN pp_blog_tags AS c ON b.tag_id = c.tag_id $cond";

        return $this->db->query($sql)->row()->total;
    }

    function getMainProductByCondTags($select='a.*', $cond='', $num=0, $offset=0){

        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';

        $sql = "SELECT $select FROM $this->_view_blog AS a  
            JOIN pp_blog_tags_items AS b ON a.blog_id = b.blog_id 
            JOIN pp_blog_tags AS c ON b.tag_id = c.tag_id $cond $limit";

        return $this->db->query($sql)->result_array();
    }


    function getTagBySlug($slug){
        if(!$slug) return;

        $sql = "SELECT tag_id, title FROM pp_blog_tags WHERE slug='$slug'";
        return $this->db->query($sql)->row_array();
    }

    function getTags() {
        if($this->blog_id == 0) return;

        $sql ="SELECT a.blog_id, b.*
                FROM pp_blog_tags_items AS a
                JOIN pp_blog_tags AS b ON a.tag_id = b.tag_id
                WHERE a.blog_id = $this->blog_id";

        return $this->db->query($sql)->result_array();
    }


}
