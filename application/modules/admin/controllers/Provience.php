<?php

/**
* Controllers Provience
* Last update 26 Dec 2019
*
* @package backend
* @copyright PANPIC
* @author
* @author position: PHP Developer
* @since 26 Dec 2019
*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Provience extends MY_Controller{

	

	public function __construct(){
		parent::__construct();
		$this->load->model('state_model');

        $this->state_model->current_lang = $this->current_lang;

        $this->_data['ADMIN_BLOG_VERIFY'] = ADMIN_BLOG_VERIFY;
        $this->_data['BLOG_TAB_VIEWALL'] = BLOG_TAB_VIEWALL;
        $this->_data['BLOG_TAB_UNVERIFY'] = BLOG_TAB_UNVERIFY;
        $this->_data['BLOG_TAB_VERIFY'] = BLOG_TAB_VERIFY;
        $this->_data['BLOG_TAB_ACTIVE'] = BLOG_TAB_ACTIVE;
        $this->_data['BLOG_TAB_INACTIVE'] = BLOG_TAB_INACTIVE;
        $this->_data['ACTIVE_DUPLICATE'] = ACTIVE_DUPLICATE;
	}

	

	function index()
	{
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $more_url = '';
		$this->_data['breadcrumb'] = $this->lable['city_province'];

        $tab = $this->input->get('t');
        $tab = ($tab == '') ? 4 : $tab;
        $this->_data['tab'] = $tab;
        $q = $this->input->get('q');

        $cond = '';

        if($tab == BLOG_TAB_ACTIVE) {
            $cond .= " WHERE a.avail = 1 ";
        }

        if($tab == BLOG_TAB_INACTIVE) { // Recycle bin
            $cond .= " WHERE (a.avail = 0 || a.avail = 2) ";
        }

        if($q != '') {
            $cond .= " AND a.state LIKE '%$q%' ";
            $search['q'] = $q;
        }

        $this->_data['search'] = $search;

        $totalItems  = $this->state_model->countItems($cond);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url($this->_control );
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $items = $this->state_model->getItems($cond, $per_page, $start);
        $this->_data['items'] = $items;

        if( $this->input->post()) { // Delete to Recyle bin

            $arr = $this->input->post('checkAll');
            if( sizeof($arr) > 0 ) {

                $params['avail'] = 0;
                foreach ($arr as $vl) {
                    $this->state_model->id = $vl;
                    $update = $this->state_model->updateItem($params);
                }

                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['delete_succ']);
                redirect( admin_url( $this->_control ) );

            } else {
                $this->session->set_flashdata('alert', 'danger');
                $this->session->set_flashdata('msg', $this->lable['delete_fail']);
                redirect( admin_url( $this->_control ) );
            }
        }

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

		$this->parser->parse($this->_control."/index.tpl", $this->_data);
	}		



	function add(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['breadcrumb'] = $this->lable['city_province'];

        $data = array();

        if (!empty($id) && $option == 'edit') {
            $this->state_model->id = $id;
            $data = $this->state_model->getItemById();
        }

        $this->_data['data'] = $data;
        $this->_data['valid'] = '';

        if( $this->input->post() ) {

            $_data = $this->input->post('data');

            $params = array(
                'state' => $_data['state'],
                'pos'   => $_data['pos']
            );

            if (!empty($id) && $option == OPTION_EDIT) { //Update
                $this->state_model->id = $id;
                $update = $this->state_model->updateItem($params);
                if($update) {
                    $this->session->set_flashdata('alert', 'success');
                    $this->session->set_flashdata('msg', $this->lable['edit_succ']);
                    redirect( admin_url( $this->_control ) );
                } else {
                    $this->session->set_flashdata('alert', 'danger');
                    $this->session->set_flashdata('msg', $this->lable['edit_fail']);
                    redirect( admin_url($this->_control."/add/?id=$id&option=edit") );
                }

            } else {

                $insert = $this->state_model->insertItem($params);
                if ($insert) {
                    $this->session->set_flashdata('alert', 'success');
                    $this->session->set_flashdata('msg', $this->lable['add_succ']);
                    redirect( admin_url($this->_control."/add") );
                } else {
                    $this->_data['alert'] = 'danger';
                    $this->_data['msg'] = $this->lable['add_fail'];
                    $this->_data['data'] = $params;
                    $this->parser->parse($this->_control."/add.tpl", $this->_data);
                    return;
                }

            }

        }

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');
        $this->parser->parse($this->_control."/add.tpl", $this->_data);
    }


    /**
     * Restore active
     */
	function restore()
	{
		$base_url = admin_url( $this->_control );
        $id = (int)$this->input->get('id');

        if($id) {
            $params['avail'] = 1;
            $this->state_model->id = $id;
            $update = $this->state_model->updateItem($params);
        }

        if($update) {
            $this->session->set_flashdata('alert', 'success');
            $this->session->set_flashdata('msg', $this->lable['restore_success']);
            redirect( $base_url );
        } else {
            $this->session->set_flashdata('alert', 'danger');
            $this->session->set_flashdata('msg', $this->lable['restore_fail']);
            redirect( $base_url );
        }
    }


    /**
     * Remove Item
     */
    function removemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $checkAll = $this->input->post('checkAll');

        if(sizeof($checkAll) > 0) {

            foreach ($checkAll as $id) {
                $this->state_model->deleteItem( array('state_id' => $id) );
            }

        }

        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('msg', $this->lable['delete_succ']);
        redirect( admin_url($this->_control."?t=5") );
    }



	function del() {
        $mess['not_error'] = '0';
        $id = (int) $this->input->get('id');
        // $this->state_model->deleteItem( array('state_id' => $id) );
    }

	

	public function ajaxState(){

		$mess['not_error'] = '0';

		if($this->input->post()) {
			$data = $this->input->post();
			$data_filter['country_id'] = ' = ' . $data['country_id'];
			$data_filter['avail'] = ' = 1';
			$data_filter['order_by'] = 'state';
			$data_filter['order'] = 'ASC';

			$this->state_model->data_filter = $data_filter;
			$dataPro = $this->state_model->getItems();

			$str = '<option value="">---</option>';

			foreach($dataPro as $item ){
				$str .= '<option value="' . $item['state_id'] . '">' . $item['state'] . '</option>';
			}

			$mess['data'] = $str;
		}

		die (json_encode( $mess ));
	}

	

}