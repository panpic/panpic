<?php
/**
* Model Backend Car Categories
* Last update 29 August 2018
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 29 August 2018
*/

class Carcat_model extends MY_Model
{
    
    var $table = 'pp_car_cat';
    public $id;
    
    function getKeyString() { return "cat_cat_id ='$this->id'"; }
    
    
    /**
     * 
     * @param $id int
     * @return array
     */
    function getItemById(){ 
        $sql = "SELECT * FROM $this->table WHERE ".$this->getKeyString();
        return $this->db->query($sql)->row_array();
    }
    
    
    function insertItem($params){
        return $this->db->insert($this->table, $params);
    }

    
    function deleteItem($where) {
        if(!$where) return;

        $this->db->where($where);
        return $this->db->delete($this->table);
    }

    
    public function updateItem($params) {
        $this->db->where('cat_cat_id', $this->id);
        return $this->db->update($this->table, $params);
    }
    
    
    function items($cond='', $num='', $offset=''){

        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

        $sql = "SELECT * FROM $this->table $cond ORDER BY date_add DESC $limit";

        return $this->db->query($sql)->result('array');
    }


    function countItems($cond=''){
        $sql = "SELECT COUNT(cat_cat_id) AS total FROM $this->table $cond";
        return $this->db->query($sql)->row()->total;
    }
    
}