<?php
/**
* Model Gallery_model
* Last update 21 Nov 2018
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 21 Nov 2018
*/

class Gallery_model extends MY_Model
{
    
    private $_pp_blog_translate = 'pp_blog_translate';
    private $_pp_blog    = 'pp_blog';

    private $_pp_blog_gallery = 'pp_blog_gallery';
    private $_pp_images = 'pp_images';
    public $_post_type_album_detail = POST_TYPE_ALBUM_DETAIL;

    public $album_id,
        $id,
        $current_lang = 'vi',
        $page_lang,
        $default_lang;


    public function __construct(){

    }

    
    function getKeyString() { return " a.id = $this->id "; }


    /**
     * Insert album gallery detail
     *
     * @param array $_data
     * @return bool
     */
    function insertItem($params){

        $this->db->trans_begin();
        
            $this->db->insert($this->_pp_blog_gallery, $params);
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
     * Update album gallery detail
     *
     * @param array $params
     * @return bool
     */
    function updateItem($params) {
        if($this->id == '') return FALSE;

        $this->db->trans_begin();

            $this->db->update($this->_pp_blog_gallery, $params, array('id'=>$this->id));

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


    function getImageByBlogId($blog_id, $cond=" AND image_type = '".POST_TYPE_ALBUM_DETAIL."' ") {
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


    function updateByFields($params) {
        if($this->id == '') return;
        
        return $this->db->update($this->_pp_blog_gallery, $params, array('id' => $this->id) );
    }



    /**
     * Remove table[pp_blog_gallery], table[pp_images]
     *
     * @param int $this->id
     * @return bool
     */
    function deleteItem() {
        if($this->id == '') return;

        $this->db->trans_begin();

            $this->db->delete($this->_pp_blog_gallery, array('id' => $this->id));
            $this->db->delete($this->_pp_images, array('object_id' => $this->id, 'image_type'=> $this->_post_type_album_detail) );

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
        
        $sql = "SELECT a.category_id, a.post_type, a.date_add, a.avail, a.admin_verify, b.*, d.cat_name, i.path_image, i.path_image_thumb 
              FROM $this->_pp_blog AS a JOIN $this->_pp_blog_translate AS b ON a.blog_id = b.blog_id AND b.lang = '$this->current_lang' 
              LEFT JOIN $this->_table_blog_cat AS d ON a.category_id = d.post_cat_id 
              LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 
              $cond 
              GROUP BY b.blog_id ORDER BY a.date_add DESC $limit";
        
        return $this->db->query($sql)->result('array');
    }


    /**
     * Album gallery images detail
     *
     * @param int $album_id
     * @return array mix
     */
    function albumGalleryDetail($album_id, $cond='') {
        if($album_id == '') return;

        $sql = "SELECT a.*, b.path_image, b.path_image_thumb, c.title AS album_name 
                FROM pp_blog_gallery AS a
                JOIN pp_images AS b
                ON a.id = b.object_id AND b.image_type = '$this->_post_type_album_detail' AND a.album_id = $album_id $cond 
                JOIN pp_blog_translate AS c
                ON c.blog_id = a.album_id AND c.lang = '$this->current_lang'";

        return $this->db->query($sql)->result('array');
    }


    function albumGalleryDetailById($id) {
        if($id == '') return;

        $sql = "SELECT a.*, b.image_id, b.path_image, b.path_image_thumb
                FROM pp_blog_gallery AS a
                JOIN pp_images AS b
                ON a.id = b.object_id AND b.image_type = '$this->_post_type_album_detail' AND a.id = $id";

        return $this->db->query($sql)->row_array();
    }
    

    /**
     * Build param items before insert update database
     *
     * @param array $_data
     * @param string $lang
     * @return array
     */
    function builParamsInsert($_data) {
        $title = ($_data['title'] != '') ? addslashes($_data['title']) : '';
        $date_add = ($_data['date_add'] != '') ? $_data['date_add'] : date('Y-m-d H:i:s');

        return array(
            'album_id'  => $_data['album_id'],
            'title'     => $title,
            'date_add'  => $date_add
        );
    }
    
    
    
}