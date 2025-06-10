<?php
/**
* Model Backend Category
* Last update 31 August 2018
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 31 August 2018
*/

class Comments_model extends MY_Model
{
    
    private $_pp_blog = 'pp_blog';

    private $_view_blogs = 'view_blogs';
    private $_pp_blog_comments = 'pp_blog_comments';
    private $_pp_members = 'pp_members';


    public $id;
    
    function getKeyString() { return " a.id = $this->id "; }
    

    
    /**
     * Get item by Id
     * 
     * @param $id int
     * @param string $cond_image
     * @return array
     */
    function getItemById($cond_image=" AND c.image_type = 'B' "){
        if($this->id == '') return;
        
        $sql = "SELECT a.*, b.slug, c.image_id, c.path_image, c.path_image_thumb
                FROM $this->_pp_blog AS a 
                JOIN $this->_pp_blog_comments AS b ON a.id = b.blog_id $cond_image 
                WHERE ".$this->getKeyString();

        return $this->db->query($sql)->row_array();
    }


    function countItems($cond) {
        $sql = "SELECT COUNT(s.id) AS total FROM $this->_view_blogs AS c
                JOIN $this->_pp_blog_comments AS s ON c.id = s.blog_id $cond";

        return $this->db->query($sql)->row()->total;
    }


    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

        $sql = "SELECT c.title, c.slug, c.avail AS post_avail, c.admin_verify AS post_admin_avail, s.*, m.email, CONCAT(m.first_name, ' ', m.last_name) AS fullname 
              FROM $this->_view_blogs AS c JOIN $this->_pp_blog_comments AS s ON c.id = s.blog_id
              LEFT JOIN $this->_pp_members AS m ON m.user_id = s.member_id
              $cond ORDER BY s.date_add DESC $limit ";

        return $this->db->query($sql)->result('array');
    }


    function insertItem($params, $param_slug=''){
        $this->db->trans_begin();
        
            $this->db->insert($this->_pp_blog_comments, $params);
            $primary = $this->db->insert_id();

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $primary; 
        }
    }



    function updateItem($params, $param_slug='') {
        $this->db->trans_begin();
            
            $this->db->update($this->_pp_blog_comments,$params, array('id'=>$this->id));

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return TRUE; 
        } 
    }
    
    
    function updateByFields($params) {
        if($this->id == '') return;
        
        return $this->db->update($this->_pp_blog_comments, $params, array('id' => $this->id) );
    }


    /**
     * Remove phycycle
     * Empty Recycle bin
     * @param $where
     */
    function deleteItem($where) {
        if(!$where) return;
        
        $this->db->where($where); 
        return $this->db->delete($this->_pp_blog_comments);
    }
    

    
}