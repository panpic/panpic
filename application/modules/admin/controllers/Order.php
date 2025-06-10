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

class Order extends MY_Controller{


    public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->model('order_model');
        $this->load->library('admin_permission');

        $this->order_model->_lang = $this->current_lang;
        $this->order_model->page_lang = $this->page_lang;
        $this->order_model->default_lang = $this->default_lang;

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
        $fromdate = $this->input->get('from');
        $todate = $this->input->get('to');

        $more_url = '';
        $cond = '';
        $search = array();

        if($q != '') {
            $cond = " WHERE a.order_fullname LIKE'%$q%' OR a.order_email LIKE '%$q%' OR a.order_phone LIKE '%$q%' ";
            $search['q'] = $q;
        }

        if($fromdate != '' && $todate != '') {
            $more_url .= "&from=$fromdate&to=$todate";
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
            $cond .= ($cond == '') ? 'WHERE' : 'AND';
            $cond .= " a.date_add BETWEEN '$fromdate' AND '$todate' ";
            $search['from'] = $fromdate;
            $search['to'] = $todate;
        } elseif ($fromdate == '' && $todate != '') {
            $todate = date('Y-m-d', strtotime($todate));
            $cond .= " DATEDIFF(a.date_add, '$todate') <= 0 ";
            $more_url .= "&to=$todate";
            $search['to'] = $todate;
        }elseif ($fromdate != '' && $todate == '') {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $cond .= " DATEDIFF(a.date_add, '$fromdate') >= 0 ";
            $more_url .= "&from=$fromdate";
            $search['from'] = $fromdate;
        }

        $this->_data['search'] = $search;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['order_product'];
        $totalItems = $this->order_model->countItem($cond, 0);

        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url('order');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

        $items = $this->order_model->items($cond, $per_page, $offset, 0);
        $this->_data['items'] = $items;
        $this->parser->parse($this->_control."/items.tpl", $this->_data);
    }


    /**
     * Order detail
     */
    function detail()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $id = $this->input->get('s');

        if($id == '') {
            redirect( admin_url('order') );
        }

        $data = $this->order_model->getItemById($id);
        $this->_data['data'] = $data;

        $cond = " WHERE a.id = $id ";
        $items = $this->order_model->services_items($cond);
        $this->_data['items'] = $items;
        $this->parser->parse($this->_control."/detail.tpl", $this->_data);
    }


}