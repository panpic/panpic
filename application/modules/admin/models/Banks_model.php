<?php
/**
* Model Backend Blogs
* Last update 8 Mar 2017
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 8 Mar 2017
*/

class Banks_model extends MY_Model
{
    
    private $_banks = 'banks';

    function table_banks() {return $this->_banks;}
    

    public function getItemById($bank_id)
    {
        $sql = "SELECT * FROM {$this->_banks} WHERE bank_id = $bank_id";
        return $this->db->query($sql)->row_array();
    }

    public function countItem($cond)
    {
       $sql = "SELECT COUNT(bank_id) AS total FROM {$this->_banks} $cond ";
        return $this->db->query($sql)->row()->total;
    }

    public function items($cond='',$num='',$offset='')
    {
        $limit = ($num > 0) ? "LIMIT $offset,$num" : "";
        $sql = "SELECT * FROM  {$this->_banks} $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    public function insertItem($params){
        return $this->db->insert($this->_banks, $params);
    }
    
    public function updateItem($bank_id,$params)
        {
            $this->db->where('bank_id', $bank_id);
            return $this->db->update($this->_banks, $params); 
        }   
    public function deleteItem($where)
    {
        if(!$where) return;
        $this->db->where($where);
        return $this->db->delete($this->_banks);
    }
}