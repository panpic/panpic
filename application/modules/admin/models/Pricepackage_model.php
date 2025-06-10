<?php 

/**
* Model Backend
* Last update 16 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 16 Jan 2017
*/

class Pricepackage_model extends MY_Model {
	
	 
	private $_package = 'package';

    function table_package() {return $this->_package ;}


    public function items()
    {
	    $sql = "SELECT package_id,package_type,package_name,price,limited_days,maximum_post,price_promotion,promotion_limited_days,promotion_maximum_posts 
	                FROM $this->_package ";
     return $this->db->query($sql)->result_array();  
	}


	function updateItems($data)
    {
		$this->db->trans_begin();
		foreach ($data as $vl) 
		{
			
	        $this->db->update($this->table_package(), $vl, array('package_id'=>$vl['package_id'])); 
		}
		if($this->db->trans_status() === FALSE)
		{
            $this->db->trans_rollback(); 
            return FALSE; 
        } 
        else 
        {
            $this->db->trans_commit(); 
            return TRUE; 
        }
	}

		
}