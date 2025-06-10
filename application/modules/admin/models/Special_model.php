<?php
/**
* Model Backend Special_model
* Last update 03 Mar 2017
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 03 Mar 2017
*/

class Special_model extends MY_Model
{
    
    private $_special_destination = 'special_destination';
    private $_tour_destination_desc = 'tour_destination_desc';
    private $_general_desc = 'general_desc';
    private $_tour_destination = 'tour_destination';
    
    //tour_destination
    public $id;
    
    function getKeyString() { return "c.id ='$this->id'"; }	
    
    
    /**
     * 
     * @param $id int
     * @return array
     */
    function getItemById(){
        if($this->id == '') return;
        
        $sql = "SELECT * FROM $this->_special_destination AS c WHERE ".$this->getKeyString();
        return $this->db->query($sql)->row_array();
    }
    
    function getDestinationById($id = ''){
        $sql = "SELECT * FROM $this->_tour_destination AS d wHERE tour_destination_id = $id "; 
        return $this->db->query($sql)->row_array(); 
    }
    
    
    
    
    
    function getSlugById(){
        
    }
    
    
    function insertItem($params){
        $this->db->trans_begin();
        
            $this->db->insert($this->_special_destination, $params);
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
            
            $this->db->update($this->_special_destination,$params, array('id'=>$this->id));
            
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
        
        return $this->db->update($this->_special_destination, $params, array('id'=>$this->id)); 
    }
    
    
    function deleteItem($where) {
        if(!$where) return;
        
        $this->db->where($where); 
        return $this->db->delete($this->_special_destination);
    }
    
    
    function countItems($cond) {
        
        $sql = "SELECT COUNT(c.id) AS total FROM $this->_special_destination AS c
            JOIN $this->_tour_destination_desc AS b ON c.destination_id = b.tour_destination_id
            JOIN $this->_general_desc AS g ON g.id = c.category $cond";
        
        return $this->db->query($sql)->row()->total;
    }
    
    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT c.*, b.cat_name, g.name FROM $this->_special_destination AS c
            JOIN $this->_tour_destination_desc AS b ON c.destination_id = b.tour_destination_id
            JOIN $this->_general_desc AS g ON g.id = c.category $cond ORDER BY c.id DESC $limit";
        
        return $this->db->query($sql)->result('array');
    }
    
    
    
}