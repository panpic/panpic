<?php
/**
 * Model Frontend
 * Last update 17 Jan 2020
 *
 * @package frontend
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: PHP Developer
 * @since 3 Apr 2019
 */

class Main_model extends MY_Model
{
    private $_pp_settings = 'pp_settings';

    public $lang = 'vi';
    public $active = 1;

    private $_view_category = 'view_category';
    private $_view_portfolio = 'view_portfolio';
    private $_pp_subscriber = 'pp_subscriber';

    private $_post_type;

    function emptyTable(){
        $sql = "DELETE FROM ci_sessions";
        return $this->db->query($sql);
    }

    /**
     * @param $id
     */
    function updateHit($id) {
        if(!$id) return;

        $sql = "UPDATE pp_blog SET hits = hits+1 WHERE blog_id = $id";
        return $this->db->query($sql);
    }

    /**
     * Get year for portfolio
     */
    public function getYearPortfolio()
    {
        $sql = "SELECT portfolio_year FROM $this->_view_portfolio
                GROUP BY EXTRACT(YEAR FROM portfolio_year) ORDER BY portfolio_year DESC";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @param string $fields
     * @return mixed
     */
    function menuCatBlogs($cond = '', $fields = 'post_cat_id, posts_no, home_status, cat_name, cat_slug, parents, level', $one=false)
    {
        $sql = "SELECT $fields FROM $this->_view_category $cond";

        if($one) {
            return $this->db->query($sql)->row_array();
        } else {
            return $this->db->query($sql)->result_array();
        }
    }

    /**
     * @param string $category_id
     * @param string $limit
     * @param string $field
     * @param int $home_status
     * @param string $lang
     * @return mixed
     */
    function getBanners($lang, $category_id, $limit, $home_status='',
        $field = "b.banner_id,  b.banner_file, bt.title, bt.short, bt.content, bt.link_click"
    )
    {
        $checkHomeStatus = ($home_status == false) ? '' : " AND b.home_status = $home_status";

        $sql = "SELECT $field 
        FROM pp_banner AS b
        INNER JOIN pp_banner_translate AS bt ON b.banner_id = bt.banner_id
        WHERE b.category_id = '$category_id' AND b.avail = 1 $checkHomeStatus
        ORDER BY date_add 
        DESC $limit";

        return $this->db->query($sql)->result_array();
    }

    function getBanner($lang, $category_id, $home_status='',
        $field = "b.banner_id,  b.banner_file, bt.title, bt.short, bt.content, bt.link_click"
    )
    {
        $checkHomeStatus = ($home_status == false) ? '' : " AND b.home_status = $home_status";

        $sql = "SELECT $field 
        FROM pp_banner AS b
        INNER JOIN pp_banner_translate AS bt ON b.banner_id = bt.banner_id
        WHERE b.category_id = '$category_id' AND b.avail = 1 $checkHomeStatus";

        return $this->db->query($sql)->row_array();
    }

    /**
     * Counter visit
     * @return int
     */
    function getCounter()
    {
        $sql = "SELECT vl FROM $this->_pp_settings WHERE id = 'visisted'";
        $counter = $this->db->query($sql)->row()->vl;
        $counter = $counter + 1;
        $this->db->update($this->_pp_settings, array('vl' => $counter), array('id' => 'visisted'));
        return $counter;
    }

    function insertSubscriber($params) {
        return $this->db->replace($this->_pp_subscriber, $params);
    }


    /**
     * Insert multi language
     *
     * @param array $params
     * @param array $_data
     * @return bool
     */
    function insertItem($params){
        $this->db->trans_begin();

            $this->db->insert('pp_blog', $this->paramsInsert($params) );
            $primary = $this->db->insert_id();

            $desc = $this->descriptionParamsInsert($params);
            $desc['blog_id'] = $primary;
            $this->db->insert('pp_blog_translate', $desc);

            if($params['path_image'] != '') {
                $params['blog_id'] = $primary;
                $this->db->insert('pp_images', $this->insertImageParams($params) );
            }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $primary;
        }

    }

    function paramsInsert($data) {
        if($data['category'] == 'FAQ') {
            $this->_post_type = POST_TYPE_FAQ;
            $category_id = PARENT_CAT_FAQ;
        } elseif ($data['category'] == 'Mẫu giao diện web') {
            $this->_post_type = POST_TYPE_LAYOUT;
            $category_id = PARENT_CAT_LAYOUT;
        } else {
            $this->_post_type = POST_TYPE_BLOG;
            $category_id = PARENT_CAT_BLOG;
        }

        return array(
            'post_type'     => $this->_post_type,
            'category_id'   => $category_id,
            'date_add'      => $data['date_add']
        );
    }

    function descriptionParamsInsert($data) {
        return array(
            'title'         => addslashes($data['title']),
            'slug'          => $data['slug'],
            'content'       => addslashes($data['content']),
            'category'      => $data['category'],
            'seo_title'     => trim(strip_tags($data['seo_title'])),
            'seo_description'=> trim(strip_tags($data['seo_description'])),
        );
    }

    function insertImageParams($data) {
        return array(
            'object_id' => $data['blog_id'],
            'image_type' => $this->_post_type,
            'path_image' => $data['path_image'],
            'path_image_thumb' => $data['path_image']
        );
    }

    function insertTag($params){

        $this->db->trans_begin();

            $this->db->insert('pp_blog_tags', $params);
            $primary = $this->db->insert_id();

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $primary;
        }

    }

}