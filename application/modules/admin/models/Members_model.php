<?php
/**
* Model Backend User members
* Last update 20 Sep 2018
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 31 August 2018
*/

class Members_model extends MY_Model
{
    
    private $_pp_members = 'pp_members';
    public $id = 0;


    function whereString() {
        return " a.user_id = $this->id ";
    }


    function getMemberById() {
        if($this->id == 0) return;

        $sql = "SELECT a.*, CONCAT(a.last_name, ' ',a.first_name) AS fullname FROM $this->_pp_members AS a WHERE ".$this->whereString();
        return $this->db->query($sql)->row_array();
    }


    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

        $sql = "SELECT * FROM $this->_pp_members $cond ORDER BY date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }

    function countItems($cond=''){
        $sql = "SELECT user_id FROM $this->_pp_members $cond ";
        return $this->db->query($sql)->num_rows();
    }


    function updateByFields($params) {
        if($this->id == '') return;
        
        return $this->db->update($this->_pp_members, $params, array('user_id' => $this->id) );
    }

    

}