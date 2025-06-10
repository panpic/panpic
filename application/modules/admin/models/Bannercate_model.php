<?php
/**
* Model Backend Bannner
* Last update 11 Jan 2018
* 
* @package backend
* @copyright AirTrippy
* @author 
* @author position: PHP Developer
* @since 11 Jan 2018
*/

class Bannercate_model extends MY_Model
{
    
    public $table = 'pp_banner_cat';
	public $data_filter = array(),
			$id = 0;
    
    /**
     * @return list items
     */
    public function getItems(){
		$cond = $this->buildWhere();
		
		$buildJoinAndSelect = $this->buildJoinAndSelect();
		$selectMore = $buildJoinAndSelect[0];
		$joinMore = $buildJoinAndSelect[1];
        $sql = "SELECT a.*$selectMore FROM $this->table AS a $joinMore $cond";
		if( isset($this->data_filter['count']) && (int)$this->data_filter['count'] == 1 ){
			return $this->db->query($sql)->num_rows(); 
		}
		if( isset($this->data_filter['thisOne']) && (int)$this->data_filter['thisOne'] == 1 ){
			return $this->db->query($sql)->row();
		}
        return $this->db->query($sql)->result_array(); 
    }
    
    /**
     * @return array
     */
   	public function buildJoinAndSelect( )
	{
		$str = " ";
		$array[0] = "";
		$array[1] = $str;
		return $array;
	}
	
   	/**
     * [insert or update item]
     * @param type $data
     * @return boolean
     */
    function insertItem($data = array() ){
		$id = 0;
        if(empty($data)) return $id; 
        $dataInsert = $this->buildDataInsert($data);
		$dataInsertDetail = $this->buildDataInsertDetail($data);
        if( $dataInsert['banner_cat_id'] > 0 ){
            $id = $this->db->update($this->table, $dataInsert, array('banner_cat_id' => $dataInsert['banner_cat_id']));	
        } else {
            $this->db->insert($this->table, $dataInsert); 
			$id = $this->db->insert_id();
        }
		return $id;
    }
    
    public function updateItem($data=''){
        if(empty($this->data_filter)) return;
        return $this->db->update($this->table,$data, $this->data_filter); 
    }
    
	/**
     * [insert or update item]
     * @param type $data
     * @return boolean
     */
   	public function buildWhere( )
	{
	   	$strWhere = "WHERE a.banner_cat_id !=''";
		
		if(isset($this->data_filter['banner_cat_id']) && $this->data_filter['banner_cat_id'] != ""){
			$strWhere .= " AND a.banner_cat_id" . $this->data_filter['banner_cat_id'];
		}
		
		if(isset($this->data_filter['banner_cat']) && $this->data_filter['banner_cat'] != ""){
			$strWhere .= " AND a.banner_cat" . $this->data_filter['banner_cat'];
		}
		
		if(isset($this->data_filter['banner_cat_type']) && $this->data_filter['banner_cat_type'] != ""){
			$strWhere .= " AND a.banner_cat_type" . $this->data_filter['banner_cat_type'];
		}		
		
		if(isset($this->data_filter['avail']) && $this->data_filter['avail'] != ""){
			$strWhere .= " AND a.avail" . $this->data_filter['avail'];
		}
		
		if(isset($this->data_filter['order_by']) && $this->data_filter['order_by'] != "" && isset($this->data_filter['order']) && $this->data_filter['order'] != ""){
			$strWhere .= " ORDER BY a." . $this->data_filter['order_by'] .' '. $this->data_filter['order'];
		}
		
		if(isset($this->data_filter['limit']) && (int)$this->data_filter['limit'] > 0 ){
			$num = $this->data_filter['limit'];
			$offset = $this->data_filter['offset'];
			$limit = ($num > 0 ) ? " LIMIT $offset, $num" : "";
			$strWhere .= $limit;
		}
		return $strWhere;
   	}
	
	public function buildDataInsert( $data )
	{
		$dataInser['banner_cat_id'] = (isset($data['banner_cat_id'])) ? (int)$data['banner_cat_id'] : '0';		
		$dataInser['banner_cat'] = (isset($data['banner_cat'])) ? $data['banner_cat'] : '';
		$dataInser['banner_cat_type'] = (isset($data['banner_cat_type'])) ? $data['banner_cat_type'] : '';
		$dataInser['avail'] = (isset($data['avail'])) ? (int)$data['avail'] : '1';		
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
		
		$data_filter['banner_cat_id'] = "=$this->id";
		$data_filter['thisOne'] = 1;
		$this->data_filter = $data_filter;		
		$d = $this->getItems();
		if( $d->avail == 1 ){
			$data['avail'] = 0;
			$this->data_filter = array('banner_cat_id' => $this->id);
			$status = $this->updateItem($data);
		}
		else if($d->avail == 0) {
        	$is = $this->db->delete($this->table, array('banner_cat_id' => $this->id));
			if($is)
				$is = $this->db->delete($this->table_e_d, array('banner_cat_id' => $this->id));
		}
		return $is;
    }
    
}