<?php
/**
* Model Backend Recruitment
* Last update 8 Aug 2019
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 13 July 2019
*/

class Recruitment_model extends MY_Model
{
    
    private $_pp_recruitment_apply = 'pp_recruitment_apply';
    private $_view_post_recruitment = 'view_post_recruitment';


    public function getItemById($id)
    {
        $sql = "SELECT a.* FROM $this->_pp_recruitment_apply AS a 
        JOIN $this->_view_post_recruitment AS b ON a.recruitment_id = b.blog_id WHERE a.id = $id";
        return $this->db->query($sql)->row_array();
    }


    public function countItem($cond)
    {
       $sql = "SELECT COUNT(a.id) AS total FROM $this->_pp_recruitment_apply AS a 
            JOIN $this->_view_post_recruitment AS b ON a.recruitment_id = b.blog_id $cond ";
        return $this->db->query($sql)->row()->total;
    }


    public function items($cond='',$num='',$offset='')
    {
        $limit = ($num > 0) ? "LIMIT $offset,$num" : "";

        $sql = "SELECT a.* FROM  $this->_pp_recruitment_apply AS a 
            JOIN $this->_view_post_recruitment AS b ON a.recruitment_id = b.blog_id 
            $cond ORDER BY a.date_add DESC $limit";
        return $this->db->query($sql)->result_array();
    }



    public function insertItem($params){
        return $this->db->insert($this->_pp_recruitment_apply, $params);
    }

    
    public function updateItem($id,$params)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->_pp_recruitment_apply, $params);
    }


    public function deleteItem($where)
    {
        if(!$where) return;
        $this->db->where($where);
        return $this->db->delete($this->_pp_recruitment_apply);
    }

}