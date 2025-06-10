<?php
/**
* Controllers Backend login
* Last update 21 May 2021
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 28 August 2018
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller{
	

	public function __construct(){
		parent::__construct();
		$this->load->model('page_model');

		$this->page_model->current_lang = $this->current_lang;
		$this->page_model->page_lang = $this->page_lang;
		$this->page_model->default_lang = $this->default_lang;

		$this->load->library('form_validation');
		$this->load->helper('form');
	}

	function index() {
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

		$this->_data['title_page'] = @$this->dataLang['list_pages'];
		
		$paramLang = $this->current_lang;
		$more_url = '';
        $keyword = trim(strip_tags($this->input->get('keyword')));
        $avail_str = trim(strip_tags($this->input->get('avail')));

		$lang = $this->current_lang; // Close 210521 trim($this->input->get('langp'));
		if($lang == ''){
			$lang = $paramLang;
		}

		$page_cat = trim($this->input->get('page_cat'));
		$data_filter = array();
        if ($avail_str != 'trash') {
            $avail = '1';
        } else {
            $avail = '0';
        }
        if ($keyword || $avail_str == 'trash') {
			$data_filter['category'] = $keyword;			
			$data_filter['avail'] = " = $avail";
            $more_url .= "&keyword=$keyword&avail=$avail";
            $page_more_url = "keyword=$keyword&avail=$avail";
        } else if ($avail_str == '' || $avail != '' ) {			
			$data_filter['avail'] = " = $avail";
            $more_url .= "&avail=$avail";
        }
		
		if($lang != '') {
			$data_filter['lang'] = "='$lang'";
			// $more_url .= "&langp=$lang";
		}
		
		if($page_cat != '') {
			$data_filter['page_cat'] = "='$page_cat'";
			$more_url .= "&page_cat=$page_cat";
		}
		
        $this->_data['keyword'] = $keyword;
		$this->_data['langp'] = $lang;
		$this->_data['page_cat'] = $page_cat;
        $this->_data['more_url'] = $more_url;
		
		$data_filter['count'] = 1;
		$this->page_model->data_filter = $data_filter;
		$totalItems = $this->page_model->getItems();
		
		$data_filter_trash['count'] = 1;
		$data_filter_trash['avail'] = '=0';
		$this->page_model->data_filter = $data_filter_trash;
		$trash = $this->page_model->getItems();		
		
        $per_page = 20;
        $base_url = admin_url("pages");
        $uri_segment = 4;

        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
       
		$data_filter['count'] = 0;
		$data_filter['limit'] = $per_page;
		$data_filter['offset'] = $start;
		
		$this->page_model->data_filter = $data_filter;
		$items = $this->page_model->getItems();
		
        $this->_data['action_url'] = $base_url;
        $this->_data['action_url_add'] = admin_url("pages/add");
        $this->_data['list'] = $items;
        $this->_data['trash'] = $trash;
		
		$this->_data['langArr'] = $this->config->item('page_lang');
		$this->_data['page_catArray'] = $this->config->item('page_cat');

		$this->_data['alert'] = $this->session->flashdata('alert');
		$this->_data['msg'] = $this->session->flashdata('msg');

		$this->_data['content'] = 'pages/index';
		$this->parser->parse("layout/index.tpl", $this->_data);
	}

	function add(){
	    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->_data['title_page'] = @$this->dataLang['admin_add_page'];

		$id = (int) $this->input->get('id');
		$paramLang = $this->current_lang;
				
		$item = array();
		$item['page_id'] = 0;
		$item['page_cat'] = '';		
		$item['avail'] = 1;
		
		$lang = trim($this->input->get('langp'));
		if($lang == ''){
			$lang = $paramLang;
		}
		$this->_data['langp'] = $lang;
		$item['lang'] = $paramLang;
		$item['page_title'] = '';
		$item['page_slug'] = '';
		$item['page_short'] = '';
		$item['page_detail'] = '';
		$item['seo_title'] = '';
		$item['seo_description'] = '';
		$is_check_page = 0;
		$is_check_page_slug = 0;
		if ($id > 0) {
			$this->page_model->data_filter = array(
				'avail' => '=1',
				'thisOne' => 1,
				'page_id' => "=$id",
				'lang' => "='$lang'"
			);
			$item = $this->page_model->getItems();
        }
		
		$langArr = $this->config->item('page_lang');

		/*
		$strLangIn = "'" . implode("','", array_keys($langArr)) . "'";

		if ($this->input->post()) {
			$data = $this->input->post();
			$where_id = '';
		}

		if( $id > 0 ) {//case edit the required choose lang
		    $this->form_validation->set_rules('lang', '', 'required', array('required' =>  @$this->dataLang['page_lang_required']));
		}
        */

		$this->form_validation->set_rules('page_cat', '', 'required', array('required' => @$this->dataLang['page_cat_required']));
		$this->form_validation->set_rules('page_title', '', 'required', array('required' => @$this->dataLang['page_title_required']));
		
        //chech validate
        if ($this->form_validation->run() && $is_check_page == 0 && $is_check_page_slug == 0 ) {
            $data = $this->input->post();
			$data['langArr'] = $langArr;

            $status = $this->page_model->insertItem($data);
			if($status) {
				$this->session->set_flashdata('alert', 'success');
				$this->session->set_flashdata('msg', $this->lable['edit_succ']);
				redirect( admin_url("pages") );
			} else {
				$this->session->set_flashdata('alert', 'danger');
				$this->session->set_flashdata('msg', $this->lable['edit_fail']);
				redirect( admin_url("pages/add?id=$id") );
			}
        }		
		
		$this->_data['data'] = $item;
		$this->_data['langArr'] = $langArr;
		$this->_data['page_catArray'] = $this->config->item('page_cat');

		$this->_data['alert'] = $this->session->flashdata('alert');
		$this->_data['msg'] = $this->session->flashdata('msg');

		$this->parser->parse("pages/add.tpl", $this->_data);
	}		

	function restore() {
		$paramLang = $this->_data['currentLang'];
		$base_url = admin_url("pages"); // ?lang=$paramLang
        $id = (int) $this->input->get('id');
        $this->page_model->id = $id;
		$this->page_model->data_filter = array('page_id' => $id);
        $data['avail'] = 1;
        $this->page_model->updateItem($data);
        redirect($base_url);
    }

	function del() {
        $mess['not_error'] = '0';
        $id = (int) $this->input->get('id');
        $this->page_model->id = $id;
        $status = $this->page_model->removeItem();
        die(json_encode($mess));
    }

}
