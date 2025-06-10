<?php

/**
* Optimize Agceny modules
* Last update 4 Jan 2017
* 
* @package backend user
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 4 Jan 2017 
* 
*/

Class USER_Controller extends CI_Controller
{
    //bien gui du lieu sang ben view
    public $data = array();
    
    public $lable;

            
    function __construct()
    {
        //ke thua tu CI_Controller
        parent::__construct();
        
        $modules = $this->uri->segment(1);
        
        $this->load->model('lang_model');
        $this->lable = $this->lang_model->items();
        

        switch ($modules)
        {
            case 'user' :
                {
                    $this->load->helper('language');

                    //xu ly cac du lieu khi truy cap vao modules User
                    $this->load->helper('user');

                    $this->_check_login();

                    break;
                }
            default:
                {
                    
                }
            
        }
    }
    
    
    /*
     * Kiem tra trang thai dang nhap cua Agency
     */
    private function _check_login() {

        $controller = $this->uri->rsegment('1');
        $controller = strtolower($controller);
        
        $login = $this->session->userdata('agency');
        //neu ma chua dang nhap,ma truy cap 1 controller khac login
        if(!$login && $controller != 'signin' && $controller != 'signup')
        {
            redirect(user_url('signin'));
        }

        //neu ma admin da dang nhap thi khong cho phep vao trang login nua.
        if($login && $controller == 'signin')
        {
            redirect(user_url(''));
        }

        /*
		if($controller == 'logout') {
			session_destroy();  
			redirect(user_url(''));	
		}
        */
    }

    
}
