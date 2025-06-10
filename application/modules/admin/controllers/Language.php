<?php

/**

* Controllers Backend Lang variable

* Last update 10 Jan 2017

* 

* @package backend

* @copyright PANPIC

* @author contact@panpic.vn

* @author pos: PHP Developer

* @since 3 Jan 2017

*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Language extends MY_Controller{

	



	private $_data;

	

	

	public function __construct(){

            parent::__construct();

            

            $this->_data['admin_cpanel_title'] = $this->lable['admin_cpanel_title'];

            $this->_data['base_url'] = $this->config->item("base_url");

            $this->_data['base_tlp_admin'] = $this->config->item("base_tlp_admin");

            $this->_data['base_url_admin'] = $this->config->item("base_url_admin");

            $this->_data['current_control'] = $this->router->class; // class dang dung

            $this->_data['current_method'] = $this->router->method; // phuong thuc dang dung

            $this->_data['lable'] = $this->lable;

            $this->_data['user_data'] = $this->session->userdata('login');



            

            $this->load->model('language_model');

            $this->load->library('admin_permission');
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

     * Form add  

     * 

     */

	function index(){

            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

            $this->load->library('form_validation');

            $this->_data['task'] = $this->lable['add'];

            $this->_data['breadcrumb'] = $this->lable['general_variable'];

            $this->_data['alert'] = '';



            $id = $this->input->get('id');

            $option= $this->input->get('option');

            $option = !empty($option) ? $option : 'add';

            $this->_data['option'] = $option;



            $data = array('name'=>'', 'value'=>'');

             

            if (!empty($id) && $option == 'edit') {

                $this->language_model->name = $id;

                $data = $this->language_model->getItemById();

            }

            

            

            $this->_data['data'] = $data;

            

            // $this->load->view('language/index', $this->_data);

            $this->parser->parse("language/index.tpl", $this->_data);

	}



        

        /**

         * Process form add

         */

        function add() {

            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

            $data = $this->input->post('data');

            $name = $data['name'];

            $value = $data['value'];



            $option = $this->input->post('option');

            $this->_data['task'] = $this->lable['add'];

            $this->_data['option'] = $option;

            $this->_data['alert'] = '';

            $this->_data['breadcrumb'] = $this->lable['general_variable'];



            $params = array('name' => $name, 'value' => addslashes($value));

            

            //@ Validation

            

            $this->load->helper(array('form', 'url'));

            $this->load->library('form_validation');

            

            $this->form_validation->set_error_delimiters('', '');

            $this->form_validation->set_rules('data[name]', 'Tên biên', 'required', array(

                    'required' => 'Vui lòng nhập %s'

                ));

            

            if ($option != 'edit') {

                $this->form_validation->set_rules('name', 'Tên biên', 'callback_check_name_exist');

            }

            

            

            $this->form_validation->set_rules('data[value]', 'Giá trị', 'required', array(

                    'required' => 'Vui lòng nhập %s'

                )

            );

            

            if($this->form_validation->run() == FALSE) {

                

                if ($option == 'edit') {

                    $msg = $this->lable['edit_fail'];

                } else {

                    $msg = $this->lable['add_fail'];

                }



                $this->_data['alert'] = 'danger';

                $this->_data['msg'] = $msg;

                $this->_data['data'] = $params;

                

                $this->parser->parse("language/index.tpl", $this->_data);

                return;

            }

            



            if (!empty($name) && $option == 'edit') { //Update

                

                $this->language_model->name = $name;

                $update = $this->language_model->updateItem(array('value'=>$value));

                

                if ($update) {

                    

                    $back_url = $this->config->item("base_url_admin")."/language/items/";

                    $this->_data['alert'] = 'success';

                    $this->_data['msg'] = $this->lable['edit_succ'];

                    $this->_data['data'] = $params;

                    $this->parser->parse("language/index.tpl", $this->_data);

                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return;

                    

                } else {

                    $this->_data['alert'] = 'danger';

                    $this->_data['msg'] = $this->lable['edit_fail'];

                    $this->_data['data'] = $params;

                    $this->parser->parse("language/index.tpl", $this->_data);

                    return;

                }

                

                

            } else { //insert

                

                $insert = $this->language_model->insertItem($params);



                if ($insert) {

                    

                    $back_url = $this->config->item("base_url_admin")."/language/";

                    $this->_data['alert'] = 'success';

                    $this->_data['msg'] = $this->lable['add_succ'];

                    $this->_data['data'] = $params;

                    $this->parser->parse("language/index.tpl", $this->_data);    

                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return;

                    

                } else {

                    $this->_data['alert'] = 'danger';

                    $this->_data['msg'] = $this->lable['add_fail'];

                    $this->_data['data'] = $params;

                    // $this->load->view('language/index', $this->_data);

                    $this->parser->parse("language/index.tpl", $this->_data);

                    return;

                }

            }

            

        }

        

        

        /**

         * List items

         * 

         */ 

        function items(){

            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

            // $this->load->library('form_validation');

            $this->_data['alert'] = '';

            $this->_data['breadcrumb'] = $this->lable['general_variable'];



            // $this->load->view('language/items', $this->_data);

            $this->parser->parse("language/items.tpl", $this->_data);

        }

	



        /**

         * 

         * Only call back 

         */

        function check_name_exist() {

            $data = $this->input->post('data');

            $exist = $this->language_model->checkNameExist( $data['name'] );

            

            if($exist) {

                $this->form_validation->set_message('check_name_exist', $this->lable['variable_has_exist']);

                return FALSE;

            } else return TRUE;

             

        }





      



}