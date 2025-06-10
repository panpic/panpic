<?php
/**
 * Model Front-end
 * Last update 1 Sep 2022
 *
 * @package Front-end
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: PHP Developer
 * @since 15 Jun 2020
 */

class Index_model extends MY_Model
{

    private $_view_portfolio = 'view_portfolio';
    private $_view_blog = 'view_blog';
    private $_view_video = 'view_video';
    private $_view_testimonial = 'view_testimonial';

    /**
     * @param string $cond
     * @return mixed
     */
    function getHomePortfolio($cond = '', $fields="*", $offset=8, $num=0)
    {
        $limit = ($offset > 0) ? " LIMIT $num,$offset " : '';
        $sql = "SELECT $fields FROM $this->_view_portfolio WHERE home_status = '" . ACTIVE . "' $cond GROUP BY blog_id ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getHomeBlogsFocus($cond = '', $limit = '', $field = "cat_slug, blog_id, category_id, date_add, slug, title, short, path_image, path_image_thumb")
    {
        $sql = "SELECT $field FROM $this->_view_blog WHERE $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    function getHomeBlogsByCond($cond = "WHERE post_type = 'B' AND lang='vi'", $limit = 3, $field = "cat_slug, blog_id, category_id, date_add, slug, title, short, path_image, path_image_thumb"){

        $sql = "SELECT $field
            FROM 
                (SELECT  @prev := '', @n := 0 ) init
            JOIN
            ( 
                SELECT  @n := if(category_id != @prev, 1, @n + 1) AS n,
                      @prev := category_id,
                      $field
                FROM  view_blog $cond 
            ) X
            WHERE n <= $limit
            ORDER BY date_add DESC";

        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @param string $field
     * @return mixed
     */
    function getHomeClip($cond = '', $field = "title, short, path_image, path_image_thumb ")
    {
        $sql = "SELECT $field FROM $this->_view_video WHERE home_status = '" . ACTIVE . "' $cond ORDER BY date_add DESC LIMIT 0,4";
        return $this->db->query($sql)->result_array();
    }

    function getTestimonial($cond = '', $num = 0, $offset = 0, $field = "cat_slug, slug, title, path_image, path_image_thumb, date_add ")
    {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';
        $sql = "SELECT $field FROM $this->_view_testimonial WHERE $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

}
