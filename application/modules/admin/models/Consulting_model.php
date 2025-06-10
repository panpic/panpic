<?php
/**
* Model Backend Consulting
* Last update 18 Dec 2019
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 18 Dec 2019
*/

class Consulting_model extends MY_Model
{
    
    private $_pp_consulting = 'pp_consulting';
    private $_pp_consulting_services = 'pp_consulting_services';
    private $_view_post_services = 'view_post_services';


    public function getItemById($id)
    {
        $sql = "SELECT a.* FROM $this->_pp_consulting AS a WHERE a.id = $id";
        return $this->db->query($sql)->row_array();
    }


    public function countItem($cond)
    {
       $sql = "SELECT COUNT(a.id) AS total FROM $this->_pp_consulting AS a $cond ";
        return $this->db->query($sql)->row()->total;
    }


    public function items($cond='',$num='',$offset='')
    {
        $limit = ($num > 0) ? "LIMIT $offset,$num" : "";

        $sql = "SELECT a.* FROM  $this->_pp_consulting AS a $cond ORDER BY a.date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }



    public function insertItem($params){
        return $this->db->insert($this->_pp_consulting, $params);
    }

    
    public function updateItem($id,$params)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->_pp_consulting, $params);
    }


    public function deleteItem($where)
    {
        if(!$where) return;
        $this->db->where($where);
        return $this->db->delete($this->_pp_consulting);
    }


    function getServicesByConsulting($consulting_id) {
        if($consulting_id == '') return;

        $sql = "SELECT a.consulting_id, b.*
                FROM $this->_pp_consulting_services AS a
                JOIN $this->_view_post_services AS b
                ON a.services_id = b.blog_id AND a.consulting_id = $consulting_id";
        return $this->db->query($sql)->result_array();
    }

}