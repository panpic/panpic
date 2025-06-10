<?php
/**
* Controllers Backend login
* Last update 12 Nov 2018
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 12 Nov 2018
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller{
	

	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('login_model');
	}


    /**
     * Form login
     */
	public function index(){
        $this->_data['error'] = '';

        if( $this->input->post() ) {
            $this->form_validation->set_rules('login' ,'login', 'callback_check_login');
            if($this->form_validation->run()) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $password = md5($password);
                $where = array('adminLogin' => $username , 'adminPass' => $password);
                $userInfo = $this->login_model->get_info_user($where);

                $this->session->set_userdata('login',$userInfo);
                redirect(admin_url('index'));
            }
        }

        $this->parser->parse("login/index.tpl", $this->_data);
	}


	/*
     * Kiem tra username va password co chinh xac khong
     */
    function check_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password);
        $where = array('adminLogin' => $username , 'adminPass' => $password);
        if($this->login_model->check_exists($where)) {
            return true;
        }
        
        $this->form_validation->set_message(__FUNCTION__, 'User name / Password is not matched');
        return false;
    }


    /*
	* Kiểm tra đã đăng nhập hay chưa
	*/
    private function _user_is_login() {
    	$user_data = $this->session->userdata('login');
        //neu chua login
    	if(!$user_data) {
    		return false;
    	}
    	return true;
    }


    /*
    * Phuong thuc dang xuat
    */
    public function logout() {
        if($this->_user_is_login()) {
           //neu thanh vien da dang nhap thi xoa session login
           $this->session->unset_userdata('login');
        }
        $this->session->set_flashdata('flash_message', 'Đăng xuất thành công');
        redirect();
    }


}