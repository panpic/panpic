<?php
/**
 * Model Banner model
 * Last update 23 Nov 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 10 Nov 2018
 */

class Banner_model extends MY_Model
{

	private $_pp_banner = 'pp_banner';
	private $_pp_banner_cat = 'pp_banner_cat';
	private $_pp_banner_translate = 'pp_banner_translate';

	public $id,
		$current_lang,
		$page_lang,
		$default_lang;


	public function __construct(){

	}


	function getKeyString() { return " a.banner_id = $this->id "; }



	/**
	 * Get item by Id
	 *
	 * @param $id int
	 * @return array
	 */
	function getItemById(){
		if($this->id == '') return;

		$sql = "SELECT a.*, b.lang, b.title, b.short, b.content, b.link_click, b.hits, d.banner_cat   
              FROM $this->_pp_banner AS a 
              JOIN $this->_pp_banner_translate AS b ON a.banner_id = b.banner_id AND a.banner_id = $this->id AND b.lang = '$this->current_lang' 
              JOIN $this->_pp_banner_cat AS d ON a.category_id = d.banner_cat_id";

		return $this->db->query($sql)->row_array();
	}


	function getItemByCond($cond){
		$sql = "SELECT a.*, b.lang, b.title, b.short, b.content, b.link_click, b.hits 
              FROM $this->_pp_banner AS a 
              JOIN $this->_pp_banner_translate AS b ON a.banner_id = b.banner_id $cond";

		return $this->db->query($sql)->row_array();
	}



	/**
	 * Insert multi language
	 *
	 * @param array $params
	 * @param array $_data
	 * @return bool
	 */
	function insertItem($params, $_data=''){
		$this->db->trans_begin();

		$this->db->insert($this->_pp_banner, $params);
		$primary = $this->db->insert_id();

		if($_data) {
			// multi language
			foreach ($this->page_lang as $k=>$vl) {
				// If english not input
				if($k != $this->default_lang && $_data[$k]['title'] == '') {
					$data = array(
						'banner_id' => $primary,
						'lang'      => $k,
						'title'     => $_data[$this->default_lang]['title'],
						'short'		=> $_data[$this->default_lang]['short'],
                        'content'		=> $_data[$this->default_lang]['content'],
						'link_click'=> $_data[$this->default_lang]['link_click']
					);
				} else {
					$data = $this->builParamsInsert($_data, $k);
					$data['banner_id'] = $primary;
				}

				$this->db->insert($this->_pp_banner_translate, $data);
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return $primary;
		}
	}


	/**
	 * Update item a language
	 *
	 * @param array $params_translate
	 * @param array $params
	 * @return bool
	 */
	function updateItem($params_translate, $params='') {
		$this->db->trans_begin();

		$this->db->update($this->_pp_banner_translate, $params_translate, array('banner_id'=>$this->id, 'lang'=>$this->current_lang));

		if($params != '') {
			$this->db->update($this->_pp_banner, $params, array('banner_id'=>$this->id));
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}


	/**
	 * Duplicate insert new item
	 *
	 * @param array $params
	 * @param array $param_vi
	 * @param array $param_en
	 * @return bool
	 */
	function duplicateItem($params, $param_vi, $param_en) {
		$this->db->trans_begin();

		$this->db->insert($this->_pp_banner, $params);
		$primary = $this->db->insert_id();

		$param_vi['banner_id'] = $primary;

		$this->db->insert($this->_pp_banner_translate, $param_vi);

		if($param_en != '') {
            $param_en['banner_id'] = $primary;
            $this->db->insert($this->_pp_banner_translate, $param_en);
        }


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return $primary;
		}
	}

	function updateBlogByFields($params) {
		if($this->id == '') return;

		return $this->db->update($this->_pp_banner, $params, array('banner_id' => $this->id) );
	}

	function updateBlogTranslateByFields($params) {
		if($this->id == '' || $this->current_lang == '') return;

		return $this->db->update($this->_pp_banner_translate, $params, array('banner_id' => $this->id, 'lang' => $this->current_lang) );
	}


	/**
	 * Remove physycle
	 *
	 * @param $where
	 */
	function deleteItem($where) {
		if(!$where) return;

		$this->db->trans_begin();

		$this->db->delete($this->_pp_banner, $where);
		$this->db->delete($this->_pp_banner_translate, $where);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function countItems($cond) {
		$sql = "SELECT COUNT(a.banner_id) AS total FROM $this->_pp_banner AS a
                JOIN $this->_pp_banner_translate AS b ON a.banner_id = b.banner_id AND b.lang = '$this->current_lang'
                $cond";

		return $this->db->query($sql)->row()->total;
	}


	function getItems($cond='', $num='', $offset=''){
		$limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

		$sql = "SELECT a.*, b.lang, b.title, b.short, b.hits, d.banner_cat 
              FROM $this->_pp_banner AS a 
              JOIN $this->_pp_banner_translate AS b ON a.banner_id = b.banner_id AND b.lang = '$this->current_lang' 
              JOIN $this->_pp_banner_cat AS d ON a.category_id = d.banner_cat_id
              $cond 
              ORDER BY a.date_add DESC $limit";

		return $this->db->query($sql)->result('array');
	}


	function blogCategories($cond=''){
		$sql = "SELECT * FROM $this->_pp_banner_cat $cond";
		return $this->db->query($sql)->result('array');
	}


	/**
	 * Build param items before insert update database
	 *
	 * @param array $_data
	 * @param string $lang
	 * @return array
	 */
	function builParamsInsert($_data, $lang) {
		return array(
			'lang'	=> $lang,
			'title' => addslashes($_data[$lang]['title']),
			'short'	=> addslashes($_data[$lang]['short']),
            'content' => addslashes($_data[$lang]['content']),
			'link_click' => $_data[$lang]['link_click']
		);
	}



}