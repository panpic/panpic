<?php
/**
* Controllers Backend Admin users
* Last update 4 Sep 2018
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 4 Sep 2018
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller{
	


	public function __construct(){
        parent::__construct();
        $this->load->model('users_model');
        $this->load->library('admin_permission');

        $back_url = admin_url($this->_control.'/add');

        $session_admin = $this->_data['user_data'];
        $adminPermission= $session_admin->adminPermission;

        $super_admin = $this->config->item("super_admin");

        if($session_admin->adminRole != $super_admin) {
            if($this->admin_permission->myPermission($this->_control, $adminPermission) == false) {
                redirect(admin_url('index/notpermission'));
            }
        }
	}
        
	
	function index($start=0){
        $cond = '';
        $this->_data['breadcrumb'] = '';
        $this->_data['task']       = "List of admin ";
        $this->_data['alert']      = $this->session->flashdata('alert');
        $this->_data['msg']        = $this->session->flashdata('msg');

        //$get = http_build_query($_GET);

        $more_url = '';
        $page_more_url = '';
        $cond .= " WHERE  adminValid = 1";
        $keyword = trim(strip_tags($this->input->get('keyword')));

        if($keyword){
            $cond .= " AND ( adminLogin LIKE '%$keyword%' OR adminName LIKE '%$keyword%' )";
            $more_url .= "&keyword=$keyword";
            $page_more_url = "keyword=$keyword";
        }

        $this->_data['keyword'] = $keyword;


        $this->_data['more_url'] = $more_url;

        $totalItems  = $this->users_model->countItems($cond);

        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url('users/index');
        $uri_segment = 4;

        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems,$per_page,$uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;


        $items = $this->users_model->getItems($cond, $per_page, $start);

        //pre($items);
        $this->_data['action_url']         = admin_url($this->_control);
        $this->_data['action_url_add']        = admin_url($this->_control.'/add');
        $this->_data['action_url_delete_multi'] = admin_url($this->_control.'/deletemulti');
        $this->_data['items']              = $items;

        $this->parser->parse("users/index.tpl", $this->_data);
	}


    function add(){

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->_data['breadcrumb'] = '';
        $this->_data['task']       = "Admin User";
        $this->_data['arr_permision'] = $this->admin_permission->arrFunctions();

        // echo '<pre>'; 
        // print_r($this->_data['arr_permision'] ); 
        // echo '</pre>'; 
        //$type = $this->input->get('type');
        
        $id = $this->input->get('id');
        $this->users_model->id = $id; 
        $item = $this->users_model->getInfo();

        $this->_data['id'] = $id;
        $this->_data['data'] = $item; 
        $this->_data['alert'] = $this->session->flashdata('alert'); 
        $this->_data['msg']  = $this->session->flashdata('msg'); 
        $this->_data['action_url'] = admin_url($this->_control.'/process'); 

        $this->parser->parse("users/add.tpl", $this->_data);
    }
    
    
    function process(){
        $data = $this->input->post('data'); 
        $mod = $this->input->post('mod');
        $permission = implode(",", $this->input->post('permission'));

        $_data = array(
            'adminId'      => $data['adminId'], 
            'adminLogin'   => $data['adminLogin'], 
            // 'adminPass'    => md5($data['adminPass']), 
            'adminName'    => $data['adminName'],
            'adminDateAdd' => date('Y:m:d H:i:s'),
            'adminRole'=>$mod,
            'adminPermission'=>$permission    
        ); 

        if ($data['adminPass'] !='' && $this->input->get('id') == '') {
            $_data['adminPass'] = md5($data['adminPass']) ;
        }

        // echo $mod;
        // echo '<pre>'; 
        // print_r($permission); 
        // echo '</pre>'; die;

        $status = $this->users_model->insertItem($_data);
        if($status){
            $this->session->set_flashdata('alert','success');
            if($data['adminId']){
                $this->session->set_flashdata('msg', $this->lable['update_succ']); 
            } else {
                $this->session->set_flashdata('msg', $this->lable['add_succ']);
            }
        } else {
            $this->session->set_flashdata('alert', 'danger'); 
            if($data['adminId']){
                $this->session->set_flashdata('msg', $this->lable['update_fail']); 
            } else {
                $this->session->set_flashdata('msg', $this->lable['add_fail']);
            }
        }
        redirect(admin_url($this->_control));
    }
    
    
    function inactive(){
        $id = $this->input->get('id'); 
        $this->users_model->id = $id; 
        $data = array(
            'adminValid' => 0, 
        );
        $status = $this->users_model->updateItem($data);
        if($status){
            $this->session->set_flashdata('alert','success');
            $this->session->set_flashdata('msg', $this->lable['update_succ']); 
        }else {
            $this->session->set_flashdata('alert', 'danger'); 
            $this->session->set_flashdata('msg', $this->lable['update_fail']); 
        }
        redirect(admin_url($this->_control)); 
    }


    function listInactive(){
        $cond = ''; 
        $this->_data['breadcrumb'] = '';
        $this->_data['task']       = "List of admin ";
        $this->_data['alert']      = $this->session->flashdata('alert'); 
        $this->_data['msg']        = $this->session->flashdata('msg');
        
        //$get = http_build_query($_GET);
        
        $more_url = '';
        $page_more_url = '';
        $cond .= " WHERE  adminValid = 0"; 
        $keyword = trim(strip_tags($this->input->get('keyword')));
        
        if($keyword){
            $cond .= " AND ( adminLogin LIKE '%$keyword%' OR adminName LIKE '%$keyword%' )";
            $more_url .= "&keyword=$keyword";
            $page_more_url = "keyword=$keyword";
        }
        
        $this->_data['keyword'] = $keyword; 
        
        
        $this->_data['more_url'] = $more_url;
        
        $totalItems  = $this->users_model->countItems($cond); 
        
        $per_page    = $this->lable['per_item_admin']; 
        $base_url    = admin_url('users/index'); 
        $uri_segment = 4;
        
        $this->load->library('pagination_library'); 
        $this->pagination_library->pagination($base_url, $totalItems,$per_page,$uri_segment, $more_url); 
        $this->_data['links'] = $this->pagination->create_links(); 
        
        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;      
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

        $items = $this->users_model->getItems($cond, $per_page, $start);

        //pre($items); 
        $this->_data['action_url']              = admin_url($this->_control);
        $this->_data['action_url_add']          = admin_url($this->_control.'/add');
        $this->_data['action_url_delete_multi'] = admin_url($this->_control.'/deletemulti');
        $this->_data['items']              = $items; 
        
        $this->parser->parse("users/index.tpl", $this->_data);
    }


    function remove(){
        $id = $this->input->get('id'); 
        $this->users_model->id = $id; 
        $status = $this->users_model->removeItem();
        if($status){
            $this->session->set_flashdata('alert','success');
            $this->session->set_flashdata('msg', $this->lable['delete_succ']); 
        }else {
            $this->session->set_flashdata('alert', 'danger'); 
            $this->session->set_flashdata('msg', $this->lable['delete_fail']); 
        }
        redirect(admin_url($this->_control.'/listinactive'));
    }

    
}