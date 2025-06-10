<?php
/**
* Model Tags model
* Last update 18 Oct 2022
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 18 Oct 2022
*/

class Tags_model extends MY_Model
{
    
    private $_pp_blog_tags = 'pp_blog_tags';
    private $_pp_images = 'pp_images';

    public $id,
        $current_lang,
        $page_lang,
        $default_lang;


    public function __construct(){
        $this->current_lang = ($this->current_lang == '') ? 'vi' : $this->current_lang;
    }

    function getKeyString() { return " a.tag_id = $this->id "; }
    
    
    /**
     * Get item by Id
     * 
     * @param $id int
     * @param string $cond_image
     * @return array
     */
    function getItemById($cond_image=" AND c.image_type = 'B' "){
        if($this->id == '') return;
        
        $sql = "SELECT a.* FROM $this->_pp_blog_tags AS a 
                WHERE ".$this->getKeyString();

        return $this->db->query($sql)->row_array();
    }


    function getItemsMultiLangById($cond_image=" AND c.image_type = 'TS' "){
        if($this->id == '') return;

        $sql = "SELECT a.*, c.image_id, c.path_image, c.path_image_thumb 
                FROM $this->_pp_blog_tags AS a 
                LEFT JOIN $this->_pp_images AS c ON a.tag_id = c.object_id $cond_image 
                WHERE ".$this->getKeyString();

        return $this->db->query($sql)->result_array();
    }


    function getItemByCond($cond, $cond_image=" AND c.image_type = 'B' "){

        $sql = "SELECT a.* FROM $this->_pp_blog_tags AS a";

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
        
            $this->db->insert($this->_pp_blog_tags, $params);
            $primary = $this->db->insert_id();

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
    function updateItem($params) {
        $this->db->trans_begin();

           $this->db->update( $this->_pp_blog_tags, $params, array('tag_id' => $this->id) );

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
    function duplicateItem($params, $param_vi, $param_en='') {
        $this->db->trans_begin();

            $this->db->insert($this->_pp_blog_tags, $params);
            $primary = $this->db->insert_id();

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $primary;
        }
    }


    function getImageByBlogId($blog_id, $cond=" AND image_type = '".POST_TYPE_TAGS."' ") {
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
        
        return $this->db->update($this->_pp_blog_tags, $params, array('tag_id' => $this->id) );
    }


    function updateBlogTranslateByFields($params) {
        if($this->id == '' || $this->current_lang == '') return;

        return $this->db->update($this->_pp_blog_translate, $params, array( 'tag_id' => $this->id ) );
    }


    /**
     * Remove physycle
     *
     * @param $where
     */
    function deleteItem($where) {
        if(!$where) return;

        $this->db->trans_begin();

            $this->db->delete($this->_pp_blog_tags, $where);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    
    function countItems($cond) {
        $sql = "SELECT COUNT(a.tag_id) AS total FROM $this->_pp_blog_tags AS a $cond";
        
        return $this->db->query($sql)->row()->total;
    }
    
    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT a.*, i.path_image, i.path_image_thumb, (SELECT COUNT(b.id) FROM pp_blog_tags_items AS b WHERE b.tag_id = a.tag_id) AS tags  
              FROM $this->_pp_blog_tags AS a 
              LEFT JOIN pp_images AS i ON a.tag_id = i.object_id 
              $cond $limit";
        
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

        return array(
                'title'     => addslashes($_data[$lang]['title']),
                'slug'      => trim($_data[$lang]['slug']),
                'content'   => addslashes($_data[$lang]['content']),
                'lastupdate' => time(),
                'short'     => addslashes($_data[$lang]['short']),
                'seo_title'      => addslashes($_data[$lang]['seo_title']),
                'seo_description'=> addslashes($_data[$lang]['seo_description']),
            );
    }


    function searchTags($txtkey) {
        if($txtkey == '') return;

        $sql = "SELECT tag_id, title FROM $this->ppp_blog_tags WHERE MATCH(title) AGAINST('$txtkey')";
        return $this->db->query($sql)->result_array();
    }

    function insertUpdateTags($tags_value) {
        $arr = explode(',', $tags_value);
        if(sizeof($arr)) {

            $this->db->delete('pp_blog_tags_items', array('tag_id' => $this->id));

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
                        $this->db->insert( $this->ppp_blog_tags, $param);
                        $tag_id = $this->db->insert_id();
                    }

                    if($tag_id) {
                        $this->db->replace('pp_blog_tags_items', array('tag_id'=> $tag_id, 'tag_id' => $this->id));
                    }
                }
            }

        }
    }

    function getTagsByCond($cond='') {
        $sql = "SELECT * FROM $this->ppp_blog_tags $cond";
        return $this->db->query($sql)->row_array();
    }

    function getProductTagsByProductId() {
        if(!$this->id) return;

        $sql = "SELECT a.title, b.*
                FROM $this->ppp_blog_tags AS a
                JOIN pp_blog_tags_items AS b
                ON a.tag_id = b.tag_id
                AND b.tag_id = $this->id";

        return $this->db->query($sql)->result_array();
    }

}