<?php
/**
* Model Backend Media_model
* Last update 24 August 2018
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 22 August 2018
*/

class Media_model extends MY_Model
{
    
    private $_pp_images = 'pp_images';
    public $id;
    
    function getKeyString() { return " image_id = $this->id "; }



    function getImageById() {
        if($this->id == '') return;

        $sql = "SELECT * FROM $this->_pp_images WHERE image_id = $this->id";
        return $this->db->query($sql)->row_array();
    }

    function getImageByPostType($cond=" image_type = '".POST_TYPE_BLOG."' ") {
        if($cond == '') return;

        $sql = "SELECT * FROM $this->_pp_images WHERE $cond";
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



    /**
     * Remove phycycle
     * Empty Recycle bin
     * @param $where
     */
    function deleteItem($where) {
        if(!$where) return;
        
        $this->db->where($where); 
        return $this->db->delete($this->_pp_images);
    }
    
    
    function countItems($cond) {
        $sql = "SELECT COUNT(image_id) AS total FROM $this->_pp_images $cond";
        
        return $this->db->query($sql)->row()->total;
    }
    
    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT * FROM $this->_pp_images $cond ORDER BY date_add DESC $limit ";
        
        return $this->db->query($sql)->result('array');
    }


    
}