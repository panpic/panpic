<?php
/**
 * Controllers Backend
 * Last update 8 Aug 2019
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 6 Aug 2019
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends MY_Controller{

    private $_post_type;
    private $_blog_parent_category;

    public function __construct(){
        parent::__construct();
        $this->load->model('schedule_model');

        $session_admin = $this->_data['user_data'];

        $adminPermission= $session_admin->adminPermission;
        $super_admin = $this->config->item("super_admin");
        if($session_admin->adminRole != $super_admin) {
            if($this->admin_permission->myPermission($this->_control, $adminPermission) == false) {
                redirect(admin_url('index/notpermission'));
            }
        }
    }


    /**
     * List items
     *
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

        $totalItems  = $this->schedule_model->countItem($cond);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url($this->_control.'/items');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $items = $this->schedule_model->items($cond, $per_page, $start);
        $this->_data['items'] = $items;

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');
        $this->parser->parse($this->_control."/index.tpl", $this->_data);
    }



}