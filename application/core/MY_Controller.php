<?php
/**
 * Main Controllers
 * Last update 24 August 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 20 August 2018
 */

Class MY_Controller extends CI_Controller
{

    public $page_lang, $base_url,
        $data = array(),
        $_data = array(),
        $_control,
        $_action,
        $_path_upload,
        $_link_upload,
        $lable,
        $current_lang,
        $default_lang;


    function __construct() {
        parent::__construct();

        $this->page_lang = $this->config->item("page_lang");
        $this->default_lang = $this->config->item("default_lang");
        $this->base_url = $this->config->item("base_url");

        $modules = $this->uri->segment(1);
        $lang = $this->input->get('lang');

        // $this->current_lang = ($lang == '') ? 'vi' : $lang;

        $arr_session = $this->session->userdata('arr_session');
        $current_lang = isset($arr_session['current_lang']) ? $arr_session['current_lang'] : '';
        $current_lang = ($lang == '') ? $current_lang : $lang;
        $this->current_lang = ($current_lang == '') ? 'vi' : trim($current_lang);
        $arr_session['current_lang'] = $this->current_lang;
        $this->session->set_userdata('arr_session', $arr_session);

        $this->_data['current_lang'] = $this->current_lang; // currentLang
        // $langObj = (array)@json_decode(file_get_contents($this->base_url.'/api/getlang?lang='.$this->current_lang));
        // $this->lable = $langObj;

        $this->lang->load('lang', $this->current_lang);
        $this->lable = $this->lang->language;

        $this->_data['lable'] = $this->lable;

        switch ($modules)
        {
            case 'admin' :
            {
                $this->load->helper('language');
                //$this->lang->load('admin/common');
                //xu ly cac du lieu khi truy cap vao trang admin
                $this->load->helper('admin');
                $this->_check_login();
                break;
            }
            default:
            {

            }
        }

        $this->_data['admin_cpanel_title'] = $this->lable['admin_cpanel_title'];
        $this->_data['base_url'] = $this->base_url;
        $this->_data['base_tlp_admin'] = $this->config->item("base_tlp_admin");
        $this->_data['base_url_admin'] = $this->config->item("base_url_admin");
        $this->_control = $this->router->class;
        $this->_action = $this->router->method;
        $this->_data['control'] = $this->_control;
        $this->_data['action'] = $this->_action;
        $this->_data['user_data'] = $this->session->userdata('login');

        $this->_path_upload = $this->config->item("path_upload");
        $this->_link_upload = $this->config->item("link_upload");

        $this->_data['path_upload'] = $this->_path_upload;
        $this->_data['link_upload'] = $this->_link_upload;

        $this->_data['LANG_VI'] = LANG_VI;
        $this->_data['LANG_EN'] = LANG_EN;

        $this->_data['page_lang'] = $this->page_lang;
        $this->_data['default_lang'] = $this->default_lang;
        $this->load->library('admin_permission');
        $this->load->library('data_library');

        $this->_data['current_url_lang'] = current_url();

        $this->load->helper('cache_helper');
    }

    /*
     * Kiem tra trang thai dang nhap cua admin
     */
    private function _check_login() {
        $controller = $this->uri->rsegment('1');
        $controller = strtolower($controller);
        $action = $this->uri->rsegment('2');
        $action = strtolower($action);

        $login = $this->session->userdata('login');
        //neu ma chua dang nhap,ma truy cap 1 controller khac login
        if(!$login && $controller != 'login')
        {
            redirect(admin_url('login'));
        }
        //neu ma admin da dang nhap thi khong cho phep vao trang login nua.
        if($login && $controller == 'login' && $action == 'index')
        {
            redirect(admin_url('home'));
        }
    }

    public function getAllLang()
    {
        $this->load->helper('directory');
        $files = directory_map('system/language');
        $arrF = array('\\', '/');
        $arrR = array('', '');
        $langArr = array();
        foreach($files as $dir => $file){
            $dirS = str_replace($arrF, $arrR, $dir);
            if(  strlen($dirS) == 2 ){
                $langArr[] = $dirS;
            }

        }
        return $langArr;
    }

}
