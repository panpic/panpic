<?php
/**
* Model Blogs
* Last update 18 Jan 2021
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 10 Nov 2018
*/

class Blogs_model extends MY_Model
{
    
    private $_pp_blog_translate = 'pp_blog_translate';
    private $_table_blog_cat = 'pp_post_category_desc';
    private $_pp_blog    = 'pp_blog';
    private $_pp_images = 'pp_images';

    public $id,
        $current_lang,
        $page_lang,
        $default_lang;


    public function __construct(){
        $this->current_lang = ($this->current_lang == '') ? 'vi' : $this->current_lang;
    }

    function getKeyString() { return " a.blog_id = $this->id "; }

    function getKeyPair() { return array('blog_id'=>$this->id, 'lang'=>$this->current_lang); }

    function get_slug_exist($slug, $blog_id='') {
        $cond = ($blog_id != '') ? " AND blog_id <> $blog_id " : '';
        $sql = "SELECT slug FROM $this->_pp_blog_translate WHERE slug = '$slug' $cond";
        $exist_slug = $this->db->query($sql)->row()->slug;
        
        if($exist_slug) {
            $exist_slug .= "$this->current_lang-1";
            return $this->get_slug_exist($exist_slug);
        }
        
        return $slug;
    }
    
    
    /**
     * Get item by Id
     * 
     * @param $id int
     * @param string $cond_image
     * @return array
     */
    function getItemById($cond_image=" AND c.image_type = 'B' "){
        if($this->id == '') return;
        
        $sql = "SELECT a.category_id, a.post_type, a.date_add, a.avail, a.admin_verify, b.*, c.image_id, c.path_image, c.path_image_thumb
                FROM $this->_pp_blog AS a 
                JOIN  $this->_pp_blog_translate AS b ON a.blog_id = b.blog_id AND b.lang = '$this->current_lang'
                LEFT JOIN $this->_pp_images AS c ON a.blog_id = c.object_id $cond_image 
                WHERE ".$this->getKeyString();

        return $this->db->query($sql)->row_array();
    }


    function getItemsMultiLangById($cond_image=" AND c.image_type = 'B' "){
        if($this->id == '') return;

        $sql = "SELECT a.category_id, a.post_type, a.date_add, a.avail, a.admin_verify, b.*, c.image_id, c.path_image, c.path_image_thumb
                FROM $this->_pp_blog AS a 
                JOIN  $this->_pp_blog_translate AS b ON a.blog_id = b.blog_id
                LEFT JOIN $this->_pp_images AS c ON a.blog_id = c.object_id $cond_image 
                WHERE ".$this->getKeyString();

        return $this->db->query($sql)->result_array();
    }


    function getItemByCond($cond, $cond_image=" AND c.image_type = 'B' "){

        $sql = "SELECT a.category_id, a.post_type, a.date_add, a.avail, a.admin_verify, b.*, c.image_id, c.path_image, c.path_image_thumb
                FROM $this->_pp_blog AS a 
                JOIN  $this->_pp_blog_translate AS b ON a.blog_id = b.blog_id $cond 
                LEFT JOIN $this->_pp_images AS c ON a.blog_id = c.object_id $cond_image";

        return $this->db->query($sql)->row_array();

        // AND b.lang = '$this->current_lang'
    }
    
    
    function getSlugById(){
        if($this->id == '') return;
        
         $sql = "SELECT * FROM $this->_pp_blog_slug WHERE blog_id = $this->id";
        return $this->db->query($sql)->row_array();
    }


    /**
     * Insert multi language
     *
     * @param array $params
     * @param array $_data
     * @return bool
     */
    function insertItem($params, $_data=''){
        $this->db->trans_begin();
        
            $this->db->insert($this->_pp_blog, $params);
            $primary = $this->db->insert_id();

            if($_data) {
                // multi language
                foreach ($this->page_lang as $k=>$vl) {
                    // If english not input
                    if($k != $this->default_lang && $_data[$k]['title'] == '') {
                        $slug = $_data[$this->default_lang]['slug']."-$k";
                        $slug = $this->get_slug_exist($slug);

                        $data = array(
                            'blog_id'   => $primary,
                            'lang'      => $k,
                            'slug'      => $slug,
                            'title'     => $_data[$this->default_lang]['title']
                        );
                    } else {
                        $data = $this->builParamsInsert($_data, $k);
                        $data['blog_id'] = $primary;
                    }

                    $this->db->insert($this->_pp_blog_translate, $data);
                 }
            }
            
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $primary; 
        }
    }


    /**
     * Update item a language
     *
     * @param array $params_translate
     * @param array $params
     * @return bool
     */
    function updateItem($params_translate, $params='') {
        $this->db->trans_begin();

            // update multi language
            foreach ($this->page_lang as $k=>$vl) {
                $this->current_lang = $k;
                // If english not input
                if($k != $this->default_lang && $params_translate[$k]['title'] == '') {
                    $slug = $params_translate[$k]['slug'];
                    $slug = $this->get_slug_exist($slug, $this->id);

                    $data = array(
                        'blog_id'   => $this->id,
                        'lang'      => $k,
                        'slug'      => $slug,
                        'title'     => $params_translate[$this->default_lang]['title']
                    );
                } else {
                    $data = $this->builParamsInsert($params_translate, $k);
                    $data['blog_id'] = $this->id;
                }

                $this->db->update($this->_pp_blog_translate, $data, $this->getKeyPair());
            }

            if($params != '') {
                $this->db->update($this->_pp_blog, $params, array('blog_id' => $this->id));
            }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


    /**
     * Duplicate insert new item
     *
     * @param array $params
     * @param array $param_vi
     * @param array $param_en
     * @return bool
     */
    function duplicateItem($params, $param_vi, $param_en='', $param_zh='') {
        $this->db->trans_begin();

            $this->db->insert($this->_pp_blog, $params);
            $primary = $this->db->insert_id();

            $param_vi['blog_id'] = $primary;
            $this->db->insert($this->_pp_blog_translate, $param_vi);

            if($param_en != '') {
                $param_en['blog_id'] = $primary;
                $this->db->insert($this->_pp_blog_translate, $param_en);
            }

            if($param_zh != '') {
                $param_zh['blog_id'] = $primary;
                $this->db->insert($this->_pp_blog_translate, $param_zh);
            }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $primary;
        }
    }


    function getImageByBlogId($blog_id, $cond=" AND image_type = '".POST_TYPE_BLOG."' ") {
        if($blog_id == '') return;

        $sql = "SELECT * FROM $this->_pp_images WHERE object_id = $blog_id $cond";
        return $this->db->query($sql)->row_array();
    }


    function insertImage($params) {
        if($params == '') return;

        return $this->db->insert($this->_pp_images, $params);
    }


    function updateImage($params, $image_id) {
        if($params == '' || $image_id == '') return;

        return $this->db->update($this->_pp_images, $params, array('image_id' => $image_id));
    }


    function updateBlogByFields($params) {
        if($this->id == '') return;
        
        return $this->db->update($this->_pp_blog, $params, array('blog_id' => $this->id) );
    }


    function updateBlogTranslateByFields($params) {
        if($this->id == '' || $this->current_lang == '') return;

        return $this->db->update($this->_pp_blog_translate, $params, array( 'blog_id' => $this->id ) );
    }


    /**
     * Remove physycle
     *
     * @param $where
     */
    function deleteItem($where) {
        if(!$where) return;

        $this->db->trans_begin();

            $this->db->delete($this->_pp_blog, $where);
            $this->db->delete($this->_pp_blog_translate, $where);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    
    function countItems($cond) {
        $sql = "SELECT COUNT(a.blog_id) AS total FROM $this->_pp_blog AS a
                JOIN $this->_pp_blog_translate AS b ON a.blog_id = b.blog_id AND b.lang = '$this->current_lang'
                $cond";
        
        return $this->db->query($sql)->row()->total;
    }
    
    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT a.category_id, a.post_type, a.date_add, a.last_update, a.avail, a.admin_verify, a.hits, b.*, d.cat_name, i.path_image, i.path_image_thumb 
              FROM $this->_pp_blog AS a JOIN $this->_pp_blog_translate AS b ON a.blog_id = b.blog_id AND b.lang = '$this->current_lang' 
              LEFT JOIN $this->_table_blog_cat AS d ON a.category_id = d.post_cat_id 
              LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 
              $cond 
              GROUP BY b.blog_id ORDER BY a.date_add DESC $limit";
        
        return $this->db->query($sql)->result('array');
    }


    function blogCategories($cond=''){
        $sql = "SELECT * FROM $this->_table_blog_cat $cond";
        return $this->db->query($sql)->result('array');
    }


    /**
     * Build param items before insert update database
     *
     * @param array $_data
     * @param string $lang
     * @return array
     */
    function builParamsInsert($_data, $lang) {

        $slug = url_convert($_data[$lang]['slug']);

        /*
        if($this->id) {
            $slug = $this->get_slug_exist($title_slug, $this->id);
        } else {
            $slug = $this->get_slug_exist($title_slug);
        }
        */

        $arr = array(
            'lang'          => $lang,
            'title'         => addslashes($_data[$lang]['title']),
            'title_2'       => addslashes($_data[$lang]['title_2']),
            'slug'          => $slug,
            'short'         => addslashes($_data[$lang]['short']),
            'content'       => addslashes($_data[$lang]['content']),
            /*
            'price'         => addslashes($_data[$lang]['price']),
            'post_comment'  => $_data[$lang]['post_comment'],
            */
            'seo_title'     => trim(strip_tags($_data[$lang]['seo_title'])),
            'seo_description'=> trim(strip_tags($_data[$lang]['seo_description'])),
        );

        if($_data[$lang]['home_status'] > INACTIVE){
            $arr['home_status'] = $_data[$lang]['home_status']; // $arr['home_status'];
        }

        return $arr;
    }


    function searchTags($txtkey) {
        if($txtkey == '') return;

        $sql = "SELECT tag_id, title FROM pp_blog_tags WHERE MATCH(title) AGAINST('$txtkey')";
        return $this->db->query($sql)->result_array();
    }

    function insertUpdateTags($tags_value) {
        $arr = explode(',', $tags_value);
        if(sizeof($arr)) {

            $this->db->delete('pp_blog_tags_items', array('blog_id' => $this->id));

            foreach ($arr as $vl) {
                if(trim($vl) != '') {

                    $title = trim(mb_strtolower($vl, 'UTF-8'));
                    $param = array(
                        'title' => $title,
                        'slug' => url_convert($vl),
                    );

                    $row = $this->getTagsByCond(" WHERE title = '$title' ");
                    if($row) {
                        $tag_id = $row['tag_id'];
                    } else {
                        $this->db->insert('pp_blog_tags', $param);
                        $tag_id = $this->db->insert_id();
                    }

                    if($tag_id) {
                        $this->db->replace('pp_blog_tags_items', array('tag_id'=> $tag_id, 'blog_id' => $this->id));
                    }
                }
            }

        }
    }

    function getTagsByCond($cond='') {
        $sql = "SELECT * FROM pp_blog_tags $cond";
        return $this->db->query($sql)->row_array();
    }

    function getProductTagsByProductId() {
        if(!$this->id) return;

        $sql = "SELECT a.title, b.*
                FROM pp_blog_tags AS a
                JOIN pp_blog_tags_items AS b
                ON a.tag_id = b.tag_id
                AND b.blog_id = $this->id";

        return $this->db->query($sql)->result_array();
    }

}