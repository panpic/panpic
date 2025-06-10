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


class Portfolio_model extends MY_Model
{
    private $_view_portfolio = 'view_portfolio';

    /**
     * @param $portfolioId
     * @return mixed
     */
    function getGallery($portfolioId) {
        $sql = "SELECT bg.title, i.path_image, i.path_image_thumb
                FROM pp_blog_gallery AS bg
                INNER JOIN pp_images AS i ON bg.id = i.object_id
                WHERE bg.album_id = '$portfolioId'
                    AND bg.post_type = '".POST_TYPE_SERVICES_GALLERY."'
                    AND i.image_type = '".POST_TYPE_SERVICES_GALLERY."'
                ORDER BY bg.date_add ASC";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param  string  $cond
     * @param $limit
     * @param  string  $field
     * @return mixed
     */
    function getPortfolioBasic(
        $cond = '',
        $limit,
        $orderBy,
        $field = "cat_slug, slug, blog_id, title, title_2, short, path_image, path_image_thumb, date_add, portfolio_utility "
    ) {
        $sql = "SELECT $field FROM $this->_view_portfolio WHERE $cond $orderBy $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param  string  $cond
     * @param  string  $limit
     * @param  string  $field
     * @return mixed
     */
    function getPortfolioBy(
        $cond = '',
        $field = "cat_slug, slug, title, title_2, date_add, portfolio_year, portfolio_clients, portfolio_skills, short, path_image, path_image_thumb, content, seo_title, seo_description, category_id, blog_id, portfolio_utility, portfolio_clients, portfolio_skills "
    ) {
        $sql = "SELECT $field FROM $this->_view_portfolio WHERE $cond ORDER BY date_add DESC";
        return $this->db->query($sql)->row_array();
    }

    /**
     * @param  string  $cond
     * @param $limit
     * @param $select
     * @return mixed
     */
    function getPortfolio($cond = '', $limit, $select)
    {
        $sql = "SELECT $select FROM $this->_view_portfolio $cond GROUP BY blog_id ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param  string  $cond
     * @param  string  $field
     * @return mixed
     */
    function getPortfolioPagination($cond = '', $num = 0, $offset = 0,
        $field = "cat_slug, slug, blog_id, title, title_2, short, path_image, path_image_thumb, date_add "
    ) {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';

        $sql = "SELECT $field FROM $this->_view_portfolio $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param  string  $cond
     * @return mixed
     */
    function counterPortfolio($cond = '')
    {
        $sql = "SELECT count(blog_id) AS total FROM $this->_view_portfolio $cond";
        return $this->db->query($sql)->row()->total;
    }

}