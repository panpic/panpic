<?php
/**
* Model Backend Users
* Last update 26 Augus 2018
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 26 Augus 2018
*/

class Users_model extends MY_Model
{
    
    var $table = 'admin';
    
    public $id = ''; 
    public  $_pathThumb           = '';
    public  $_pathLogo           = '';
    private $_admin = 'admin';
    
    function table_admin(){
        return $this->_admin; 
    }

    
    
    /**
     * 
     * @param type $cond
     * @param type $num
     * @param type $offset
     * @return list items
     */
    function getItems($cond='', $num='', $offset=''){
        
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT * FROM {$this->table_admin()}  $cond $limit";
        
                
        return $this->db->query($sql)->result_array(); 
        
    }
    
    function countItems($cond=''){
        
        $sql = "SELECT adminId FROM {$this->table_admin()}  $cond ";
        return $this->db->query($sql)->num_rows();  
    }
    
    function getInfo(){
        
        if(!$this->id) return ; 
        $query = $this->db->get_where($this->table_admin(), array('adminId' => $this->id));
        //echo $this->db->last_query(); 
        return $query->row_array(); 
        
    }
    
    /**
     * [insert or update item]
     * @param type $data
     * @return boolean
     */
    
    function insertItem($data=''){
        if(!$data) return ; 
        $adminId = $data['adminId'];
        if($adminId){
            return $this->db->update($this->table_admin(), $data, array('adminId' => $adminId)); 
        } else {
            return $this->db->insert($this->table_admin(), $data); 
        }
    }
    
    function updateItem($data=''){
        if(!$this->id) return;  
        return $this->db->update($this->table_admin(),$data, array('adminId' => $this->id)); 
    }
    
    /**
     * 
     * @param type $id
     * @return boolean
     */
    
    function removeItem(){
        if(!$this->id) return; 
        return $this->db->delete($this->table_admin(), array('adminId' => $this->id));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  
    
    
}