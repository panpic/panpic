<?php

/**
* Model State Provience
* Last update 26 Dec 2019
*
* @package backend
* @copyright PANPIC
* @author
* @author position: PHP Developer
* @since 26 Dec 2019
*/


class State_model extends MY_Model
{


    public $table = 'pp_country_state';

	public $data_filter = array(),
			$id = 0;



	function getItemById(){
	    if($this->id == 0) return;

        $sql= "SELECT * FROM pp_country_state AS a WHERE a.state_id = $this->id";
        return $this->db->query($sql)->row_array();
    }



	function countItems($cond) {
	    $sql= "SELECT COUNT(state_id) AS total FROM pp_country_state AS a $cond";
        return $this->db->query($sql)->row()->total;
    }
    

    /**
     * @return list items
     */
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

        $sql= "SELECT * FROM pp_country_state AS a $cond ORDER BY a.pos ASC $limit";
        return $this->db->query($sql)->result_array();

    }



    public function getMaxPos(){
        $sql = "SELECT MAX(a.pos) as pos FROM $this->table AS a";
        return $this->db->query($sql)->row()->pos;
    }

    

    /**

     * [insert or update item]

     * @param type $data

     * @return boolean

     */

    function insertItem($data=''){

        if(!$data) return ; 

        $dataInsert = $this->buildDataInsert($data);		

        $id = $data['state_id'];

        if($id){

			unset($dataInsert['pos']);

            return $this->db->update($this->table, $dataInsert, array('state_id' => $id)); 

        } else {

            return $this->db->insert($this->table, $dataInsert); 

        }

    }

    

    function updateItem($data=''){

        if(empty($data) || $this->id == 0) return;

        return $this->db->update( $this->table, $data, array('state_id' => $this->id) );
    }


     /**
     * Remove physycle
     *
     * @param $where
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
    


	public function buildDataInsert( $data )
	{
        $max_pos = $this->getMaxPos()+1;

		$dataInser['state_id'] = (isset($data['state_id'])) ? (int)$data['state_id'] : '';
		$dataInser['state'] = (isset($data['state'])) ? $data['state'] : '';
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

        $is = $this->db->delete($this->table, array('state_id' => $this->id));

		return $is;

    }

    

}