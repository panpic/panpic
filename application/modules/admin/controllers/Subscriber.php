<?php
/**
 * Controllers Backend Blog category
 * Last update 23 August 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 23 August 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriber extends MY_Controller{


    public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->model('subscriber_model');
        $this->load->library('admin_permission');

        $this->subscriber_model->_lang = $this->current_lang;
        $this->subscriber_model->page_lang = $this->page_lang;
        $this->subscriber_model->default_lang = $this->default_lang;

        $session_admin            = $this->session->userdata('login');
        $this->_data['user_data'] = $session_admin;
        $adminPermission          = $session_admin->adminPermission;
        $super_admin = $this->config->item("super_admin");

        if($session_admin->adminRole != $super_admin) {
            if($this->admin_permission->myPermission($this->_control, $adminPermission) == false) {
                redirect(admin_url('index/notpermission'));
            }
        }
    }


    /**
     * List items
     */
    function index(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        $q = $this->input->get('q');

        $cond = '';
        $search = array();

        if($q != '') {
            $cond = " WHERE (fullname LIKE'%$q%' OR phone LIKE'%$q%') ";
            $search['q'] = $q;
        }

        $this->_data['search'] = $search;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['subscriber'];
        $total = $this->subscriber_model->countItem($cond, 0);

        $limit = 10;
        // load pagination library
        $config = array();
        $config['base_url'] = site_url("admin/subscriber");
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5; // page param
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 4;
        //various pagination configuration
        $config['full_tag_open'] = '<ul class="pagination margin-none">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="first">';
        $config['first_tag_close'] = '</li>';
        $config['first_link'] = '‹';
        $config['last_tag_open'] = '<li class="last">';
        $config['last_tag_close'] = '</li>';
        $config['last_link'] = '›';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $this->_data["links"] = $this->pagination->create_links();
        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $offset = ($offset > 0) ? (($offset - 1) * $limit) : $offset;
        $items = $this->subscriber_model->items($cond, $limit, $offset, 0);
        $this->_data['items'] = $items;
        $this->parser->parse("subscriber/items.tpl", $this->_data);
    }

    function delete() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $id = $this->input->get('id');
        if($id) {
            $where = array('id' => $id);
            $status = $this->subscriber_model->deleteItem($where);
            if($status) {
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['delete_succ']);
            } else {
                $this->session->set_flashdata('alert', 'danger');
                $this->session->set_flashdata('msg', $this->lable['delete_fail']);
            }
        } else {
            $this->session->set_flashdata('alert', 'danger');
            $this->session->set_flashdata('msg', $this->lable['delete_fail']);
        }

        redirect( admin_url("subscriber") );
    }

}