<?php
/**
* Model Backend language
* Last update 28 August 2018
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 28 August 2018
*/

class Page_model extends MY_Model
{

	public $table = 'pp_pages';
	public $table_pd = 'pp_pages_desc';

	public $current_lang,
		$page_lang,
		$default_lang;

	public $data_filter = array(), $id = 0;
    
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
		$str = " JOIN $this->table_pd AS b ON a.page_id = b.page_id ";
		$array[0] = ",b.lang,b.page_title,b.page_slug,b.page_short,b.page_detail,b.seo_title,b.seo_description";
		$array[1] = $str;
		return $array;
	}
	
   	/**
     * [insert or update item]
     * @param type $data
     * @return boolean
     */
	public function insertItem($data = array() ){
		$id = 0;
        if(empty($data)) return $id; 
        $dataInsert = $this->buildDataInsert($data);
		$dataInsertDetail = $this->buildDataInsertDetail($data);
		$lang = $data['lang'];

        if( $dataInsert['page_id'] > 0 ){
			unset($dataInsert['date_add']);
            $id = $this->db->update($this->table, $dataInsert, array('page_id' => $dataInsert['page_id']));
			// $dataInsertDetail['page_slug'] = $dataInsertDetail['page_slug']; //str_replace("-$lang", '', $dataInsertDetail['page_slug'] ) . "-$lang";
			$id = $this->db->update($this->table_pd, $dataInsertDetail, array('page_id' => $dataInsertDetail['page_id'], 'lang' => $lang));
			//$this->updatePageSlug( $dataInsert['page_id'], $dataInsertDetail['page_slug'], $dataInsertDetail['lang']);
        } else {
            $this->db->insert($this->table, $dataInsert); 
			$id = $this->db->insert_id();
			if( $id > 0 ) {
				$dataInsertDetail['page_id'] = $id;
				$langArr = $data['langArr'];
				foreach( $langArr as $kl => $vl ){
					$dataInsertDetail['lang'] = strtolower( $kl );
					$dataInsertDetail['page_slug'] = $dataInsertDetail['page_slug']; // . '-' . $kl;
					$this->db->insert($this->table_pd, $dataInsertDetail); 
					$id = $this->db->insert_id();
					//$this->updatePageSlug( $dataInsertDetail['page_id'], $dataInsertDetail['page_slug'], $dataInsertDetail['lang']);
				}
			}
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
	public function buildWhere(){
	   	$strWhere = "WHERE a.page_id > 0 AND b.lang = '$this->current_lang'";
		
		if(isset($this->data_filter['page_id']) && $this->data_filter['page_id'] != ""){
			$strWhere .= " AND a.page_id" . $this->data_filter['page_id'];
		}
		
		if(isset($this->data_filter['page_cat']) && $this->data_filter['page_cat'] != ""){
			$strWhere .= " AND a.page_cat" . $this->data_filter['page_cat'];
		}
		
		if(isset($this->data_filter['lang']) && $this->data_filter['lang'] != ""){
		 	$strWhere .= " AND b.lang" . $this->data_filter['lang'];
		}
		
		if(isset($this->data_filter['page_title']) && $this->data_filter['page_title'] != ""){
			$strWhere .= " AND b.page_title" . $this->data_filter['page_title'];
		}
		
		if(isset($this->data_filter['page_slug']) && $this->data_filter['page_slug'] != ""){
			$strWhere .= " AND b.page_slug" . $this->data_filter['page_slug'];
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
		$dataInser['page_id'] = (isset($data['page_id'])) ? (int)$data['page_id'] : '0';
		$dataInser['page_cat'] = (isset($data['page_cat'])) ? $data['page_cat'] : '';
		$dataInser['date_add'] = (isset($data['date_add'])) ? $data['date_add'] : time();
		$dataInser['last_update'] = (isset($data['last_update'])) ? $data['last_update'] : time();
		$dataInser['avail'] = (isset($data['avail'])) ? (int)$data['avail'] : '1';		
		return $dataInser;
	}


	public function buildDataInsertDetail( $data )
	{
		$dataInser['page_id'] = (isset($data['page_id'])) ? (int)$data['page_id'] : '0';		
		$dataInser['lang'] = strtolower( (isset($data['lang'])) ? $data['lang'] : '' );
		$dataInser['page_title'] = (isset($data['page_title'])) ? $data['page_title'] : '';
		// $dataInser['page_slug'] = (isset($data['page_slug'])) ? $data['page_slug'] : '';
		$dataInser['page_short'] = (isset($data['page_short'])) ? $data['page_short'] : '';
		$dataInser['page_detail'] = (isset($data['page_detail'])) ? $data['page_detail'] : '';
		$dataInser['seo_title'] = (isset($data['seo_title'])) ? $data['seo_title'] : '';
		$dataInser['seo_description'] = (isset($data['seo_description'])) ? $data['seo_description'] : '';
		return $dataInser;
	}


	/**
     * 
     * @param type $id
     * @return boolean
     */
	public function removeItem(){
		$is = 0;
        if(!$this->id) return;
		
		$data_filter['page_id'] = "=$this->id";
		$data_filter['thisOne'] = 1;
		$this->data_filter = $data_filter;		
		$d = $this->getItems();
		if( $d->avail == 1 ){
			$data['avail'] = 0;
			$this->data_filter = array('page_id' => $this->id);
			$status = $this->updateItem($data);
		}
		else if($d->avail == 0) {
        	$is = $this->db->delete($this->table, array('page_id' => $this->id));
			if($is)
				$is = $this->db->delete($this->table_pd, array('page_id' => $this->id));
		}
		return $is;
    }


	/**
     * [insert or update item]
     * @param type $page_id 
     * @param type $page_title 
     * @return boolean
     */
	public function updatePageSlug($page_id, $page_slug, $lang ){
		
        if(!$page_id) return 0; 
		
		// $page_slug = str_replace(" ", "-", $this->RemoveSign($page_slug) );
        // $dataInsert['page_slug'] = $page_slug;
		$data_filter = array();
		// $data_filter['page_slug'] = "='$page_slug'";
		$data_filter['thisOne'] = 1;
		$data_filter['lang'] = "!='$lang'";
		$data_filter['page_id'] = "!=$page_id";
		$this->data_filter = $data_filter;
		$d = $this->getItems();
		if( $d ){
			// $dataInsert['page_slug'] = $dataInsert['page_slug'] . '-' . $page_id;
			return $this->db->update($this->table_pd, $dataInsert, array('page_id' => $page_id));
		}
		else {
			return $this->db->update($this->table_pd, $dataInsert, array('page_id' => $page_id));
		}
    }


	public function RemoveSign($str) {
        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ"
            , "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "ê", "ù", "à");
        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "e", "u", "a");
        return str_replace($coDau, $khongDau, $str);
    }
    
}