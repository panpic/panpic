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

class Lang_model extends CI_Model
{
    
    var $table = 'lang_values';
    
    function items() {
        $sql = "SELECT name, value FROM $this->table";
        $obj = $this->db->query($sql)->result();
        
        foreach ($obj as $vl){
            $tmp[$vl->name] = $vl->value;
        }
        
        return $tmp;
    }
    
}    
