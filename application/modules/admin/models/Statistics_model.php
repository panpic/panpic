<?php
/**
* Model Backend Statistics_model
* Last update 24 August 2018
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 22 August 2018
*/

class Statistics_model extends MY_Model
{
    
    private $_pp_blog = 'pp_blog';
    private $_pp_product = 'pp_product';
    private $_pp_members = 'pp_members';


    
    function countPost($cond) {
        $sql = "SELECT COUNT(blog_id) AS total FROM $this->_pp_blog $cond";
        return $this->db->query($sql)->row()->total;
    }




    function countProducts($cond='') {
        $sql = "SELECT COUNT(product_id) AS total FROM $this->_pp_product $cond";
        return $this->db->query($sql)->row()->total;
    }
    

    
}