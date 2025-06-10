<?php
/**
* Model Backend language
* Last update 3 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 3 Jan 2017
*/

class Language_model extends MY_Model
{
    
    var $table = 'lang_values';
    public $name;
    
    function getKeyString() { return "d.name ='$this->name'"; }	
    
    
    /**
     * 
     * @param $name string
     * @return array
     */
    function getItemById(){
        
        $sql = "SELECT * FROM $this->table AS d WHERE d.lang ='VN' AND ".$this->getKeyString();
        
        return $this->db->query($sql)->row_array();
    }
    
    
    function insertItem($params){
        return $this->db->insert($this->table, $params);
    }
    
    public function updateItem($params) {

        $this->db->where('name', $this->name);
        return $this->db->update($this->table, $params);

    }
    
    
    function checkNameExist($name){
        $sql = "SELECT name FROM $this->table AS d WHERE d.lang ='VN' AND d.name = '$name'"; //.$this->getKeyString();
        return $this->db->query($sql)->row_array();
    }
    
    
    
    
}