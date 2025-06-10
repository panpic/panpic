<?php
class Login_model extends MY_Model
{
    var $table = 'admin';

    
     
    /*
     * lay thong tin thanh vien
     */
    public function get_info_user($where = array())
    {
        //tao dieu kien cho cau truy van
        
        $this->db->where($where);
        $result = $this->db->get($this->table);
        return $result->row();
        
    }


   

}