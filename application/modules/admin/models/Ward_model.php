<?php

/**
* Model District
* Last update 30 Dec 2019
*
* @package backend
* @copyright PANPIC
* @author
* @author position: PHP Developer
* @since 30 Dec 2019
*/


class Ward_model extends MY_Model
{


    public $table = 'pp_country_ward';
    public $pp_country_district = 'pp_country_district';
    public $pp_country_state = 'pp_country_state';

	public $data_filter = array(),
			$id = 0;



	function getItemById(){
	    if($this->id == 0) return;

        $sql = "SELECT a.*, b.district
                FROM $this->table AS a
                JOIN $this->pp_country_district AS b 
                ON a.district_id = b.district_id AND a.ward_id = $this->id";

        return $this->db->query($sql)->row_array();
    }



	function countItems($cond) {
	    $sql= "SELECT COUNT(ward_id) AS total FROM $this->table AS a 
              JOIN $this->pp_country_district AS b ON a.district_id = b.district_id $cond";

        return $this->db->query($sql)->row()->total;
    }
    

    /**
     * @return list items
     */
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

        echo $sql= "SELECT a.*, b.district, c.state FROM $this->table AS a 
              JOIN $this->pp_country_district AS b ON a.district_id = b.district_id $cond 
              JOIN $this->pp_country_state AS c ON b.state_id = c.state_id 
              ORDER BY a.pos ASC $limit";

        return $this->db->query($sql)->result_array();
    }


    function getDistrictItemsByStateId($state_id){
        if($state_id == '') return;

        $sql = "SELECT * FROM pp_country_district AS a WHERE a.state_id = $state_id";

        return $this->db->query($sql)->result_array();
    }


    public function getMaxPos(){
        $sql = "SELECT MAX(a.pos) as pos FROM $this->table AS a";
        return $this->db->query($sql)->row()->pos;
    }

    

    /**
     * [insert or update item]
     * @param array $data
     * @return boolean
     */
    function insertItem($data=''){

        if(!$data) return ; 

        $dataInsert = $this->buildDataInsert($data);		

        $id = $data['ward_id'];

        if($id){

			unset($dataInsert['pos']);
            return $this->db->update($this->table, $dataInsert, array('ward_id' => $id));

        } else {
            return $this->db->insert($this->table, $dataInsert);
        }

    }

    

    function updateItem($data=''){

        if(empty($data) || $this->id == 0) return false;

        return $this->db->update( $this->table, $data, array('ward_id' => $this->id) );
    }


    /**
     * Remove physycle
     *
     * @param array $where
     * @return bool
     */
    function deleteItem($where) {
        if(!$where) return;

        $this->db->trans_begin();

            $this->db->delete($this->table, $where);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    

	function buildDataInsert( $data )
	{
	    $max_pos = $this->getMaxPos()+1;

        $dataInser['ward_id'] = (isset($data['ward_id'])) ? (int)$data['ward_id'] : '';
	    $dataInser['district_id'] = (isset($data['district_id'])) ? (int)$data['district_id'] : '';
		$dataInser['ward'] = (isset($data['ward'])) ? $data['ward'] : '';
		$dataInser['pos'] = ($data['pos'] == '') ? $max_pos : $data['pos'];
		$dataInser['avail'] = (isset($data['avail'])) ? $data['avail'] : 1;
		return $dataInser;
	}


	/**
     *
     * @param type $id
     * @return boolean
     */
    function removeItem(){

		$is = 0;

        if(!$this->id) return;

        $is = $this->db->delete($this->table, array('ward_id' => $this->id));

		return $is;

    }


}