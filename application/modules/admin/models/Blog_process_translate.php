<?php
/**
* Model Blog_process_translate
* Last update 11 Dec 2019
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 10 Nov 2018
*/

class Blog_process_translate extends MY_Model
{
    
    private $_pp_blog_translate = 'pp_blog_translate';
    private $_table_blog_cat = 'pp_post_category_desc';
    private $_pp_blog    = 'pp_blog';
    private $_pp_images = 'pp_images';

    private $_pp_blog_process_translate = 'pp_blog_process_translate';

    public $id, $current_lang;


    public function __construct(){
        $this->current_lang = 'vi';
    }


    
    /**
     * Get item by Id
     * 
     * @param $id int
     * @return array
     */
    function getItemById(){
        if($this->id == '') return;
        
        $sql = "SELECT * FROM $this->_pp_blog_process_translate AS a WHERE id = $this->id";

        return $this->db->query($sql)->row_array();
    }



    /**
     * Insert
     *
     * @param array $params
     * @return bool
     */
    function insertItem($params){
        $this->db->trans_begin();
        
            $this->db->insert($this->_pp_blog_process_translate, $params);
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
     * @param array $params
     * @return bool
     */
    function updateItem($params) {
        if($this->id == '') return FALSE;

        $this->db->trans_begin();

            $this->db->update($this->_pp_blog_process_translate, $params, array('id' => $this->id) );

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }




    /**
     * Remove physycle
     *
     * @param $where
     */
    function deleteItem($where) {
        if(!$where) return;

        $this->db->trans_begin();

            $this->db->delete($this->_pp_blog_process_translate, $where);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


    function counterItems($cond=''){
        $sql = "SELECT COUNT(a.id) AS total FROM $this->_pp_blog_process_translate AS a $cond ";
        return $this->db->query($sql)->row()->total;
    }

    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT * FROM $this->_pp_blog_process_translate AS a $cond 
              ORDER BY a.id ASC $limit";
        
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
            'lang'          => $lang,
            'blog_id'       => $_data[$lang]['blog_id'],
            'title_process' => addslashes($_data[$lang]['title_process']),
            'content_process'=> addslashes($_data[$lang]['content_process'])
        );
    }
    
    
    
}