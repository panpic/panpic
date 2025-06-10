<?php
/**
* Model Backend Subscriber_model
* Last update 9 Apr 2019
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 9 Apr 2019
*/

class Subscriber_model extends MY_Model
{
    
    private $_pp_subscriber = 'pp_subscriber';


    public function getItemById($id)
    {
        $sql = "SELECT * FROM $this->_pp_subscriber WHERE id = $id";
        return $this->db->query($sql)->row_array();
    }


    public function countItem($cond)
    {
       $sql = "SELECT COUNT(id) AS total FROM $this->_pp_subscriber $cond ";
        return $this->db->query($sql)->row()->total;
    }


    public function items($cond='',$num='',$offset='')
    {
        $limit = ($num > 0) ? "LIMIT $offset,$num" : "";

        $sql = "SELECT * FROM  $this->_pp_subscriber $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }


    public function insertItem($params){
        return $this->db->insert($this->_pp_subscriber, $params);
    }

    
    public function updateItem($id,$params)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->_pp_subscriber, $params);
    }


    public function deleteItem($where)
    {
        if(!$where) return;
        $this->db->where($where);
        return $this->db->delete($this->_pp_subscriber);
    }

}