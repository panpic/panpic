<?php
/**
* Model Backend Order
* Last update 8 Aug 2019
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 13 July 2019
*/

class Order_model extends MY_Model
{
    
    private $_pp_order_services = 'pp_order_services';
    private $_pp_order_services_items = 'pp_order_services_items';
    private $_pp_province_district = 'pp_province_district';
    private $_view_post_services = 'view_services';


    public function getItemById($id)
    {
        $sql = "SELECT a.*, p.district FROM $this->_pp_order_services AS a 
        LEFT JOIN $this->_pp_province_district AS p ON a.district_id = p.district_id WHERE a.id = $id";
        return $this->db->query($sql)->row_array();
    }


    public function countItem($cond)
    {
       $sql = "SELECT COUNT(a.id) AS total FROM $this->_pp_order_services AS a 
            LEFT JOIN $this->_pp_province_district AS p ON a.district_id = p.district_id $cond ";
        return $this->db->query($sql)->row()->total;
    }


    public function items($cond='',$num='',$offset='')
    {
        $limit = ($num > 0) ? "LIMIT $offset,$num" : "";

        $sql = "SELECT a.*, p.district FROM  $this->_pp_order_services AS a 
            LEFT JOIN $this->_pp_province_district AS p ON a.district_id = p.district_id 
            $cond ORDER BY a.date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }


    public function services_items($cond='')
    {
        $sql = "SELECT b.*, c.* FROM  $this->_pp_order_services AS a 
            JOIN $this->_pp_order_services_items AS b ON a.id = b.order_id 
            JOIN $this->_view_post_services AS c ON b.product_id = c.blog_id $cond";

        return $this->db->query($sql)->result_array();
    }


    public function insertItem($params){
        return $this->db->insert($this->_pp_order_services, $params);
    }

    
    public function updateItem($id,$params)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->_pp_order_services, $params);
    }


    public function deleteItem($where)
    {
        if(!$where) return;
        $this->db->where($where);
        return $this->db->delete($this->_pp_order_services);
    }

}