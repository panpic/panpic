<?php

/**

* Controllers Backend General variable define

* Last update 10 Jan 2017

* 

* @package backend

* @copyright PANPIC

* @author contact@panpic.vn

* @author pos: PHP Developer

* @since 10 Jan 2017

*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class General extends MY_Controller{

	

    

        private $_data;



	    private $_control;

        private $_method;



        public function __construct(){

            parent::__construct();

            

            $this->_data['admin_cpanel_title'] = $this->lable['admin_cpanel_title'];

            $this->_data['base_url'] = $this->config->item("base_url");

            $this->_data['base_tlp_admin'] = $this->config->item("base_tlp_admin");

            $this->_data['base_url_admin'] = $this->config->item("base_url_admin");

            

            $this->_control = $this->router->class; // class dang dung

            $this->_method = $this->router->method; // phuong thuc dang dung

            

            $this->_data['current_control'] = $this->_control;

            $this->_data['current_method'] = $this->_method;

            $this->_data['lable'] = $this->lable;

            $this->_data['user_data'] = $this->session->userdata('login');



            $this->load->helper('url');

            $this->load->library('pagination');

            $this->load->model('general_model');

            $this->load->library('general_library');

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

            

            $this->_data['task'] = $this->lable['general'];

            $this->_data['alert'] = '';

            $this->_data['valid'] = array('name'=>'');

            $this->_data['breadcrumb'] = $this->lable['general'];

        

            $id = $this->input->get('id');

            $option = $this->input->get('option');

            $option = !empty($option) ? $option : 'add';

            $task = $this->input->get('t');

            

            if( !empty($id) && $option=='edit' ) {			

                $this->general_model->primary = $id;

                $data = $this->general_model->getItemById();



                $multi = array();

                

                $sub = $this->input->post('sub');

                if($task == 'del' && !empty($sub)) {

                    $this->general_model->primary = $sub;

                    $this->general_model->deleteItem();				

                    redirect( admin_url("general/index/?id=$id&option=$option"), 'refresh');

                }

                

                $general = $this->general_library->general();

                $this->_data['heading'] = $this->lable['edit'].' '.$general[$data['type']];



            } else {

                $data = array();

                $multi = array();

                $heading = $this->lable['add'];

            }

            

            

            $this->_data['data'] = $data;

            $this->_data['multi'] = $multi;

            $this->_data['option'] = $option;

            

            $this->parser->parse("general/index.tpl", $this->_data);

	}



        

        /**

         * Process form add

         */

        function add() {

            

            $row = '';

            $primary    = $this->input->post('primary');

            $option     = $this->input->post('option');		

            $name	= $this->input->post('name');

            $type 	= $this->input->post('custom_type');

            $c_name	= $this->input->get('b');

            $time	= time();

            

            $this->_data['task'] = $this->lable['general'];

            $this->_data['option'] = $option;

            $this->_data['alert'] = '';

            $this->_data['breadcrumb'] = $this->lable['general'];



            if(!empty($primary) && $option == 'edit') {

                $this->general_model->primary = $primary;

                $row = $this->general_model->getItemById();

                $this->_data['data'] = $row;			

                $this->_data['heading'] = $this->lable['update'].' '.$this->lable[$this->_control];

            }

            

            $data = array('type'=> $type, 'last_update'=> $time); 



            $desc = array('name'=> addslashes($name));

            

            $back_url = admin_url("general/items/#$c_name");

            

            if (!empty($primary) && $option == 'edit') { //Update

                

                $this->general_model->primary = $primary;

    		$update = $this->general_model->updateItem($data, $desc);

                

                if ($update) {

                    $this->_data['alert'] = 'success';

                    $this->_data['msg'] = $this->lable['edit_succ'];

                    $this->parser->parse("general/nogrant.tpl", $this->_data);

                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return; 

                } else {

                    $this->_data['alert'] = 'danger';

                    $this->_data['msg'] = $this->lable['edit_fail'];

                    $this->parser->parse("general/nogrant.tpl", $this->_data);

                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return;

                }

                

            } else { //insert

                

                $data['date_add'] = $time;

    		$insert = $this->general_model->insertItem($data, $desc);



                if ($insert) {

                    $this->_data['alert'] = 'success';

                    $this->_data['msg'] = $this->lable['add_succ'];

                    $this->parser->parse("general/nogrant.tpl", $this->_data);    

                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return;

                    

                } else {

                    $this->_data['alert'] = 'danger';

                    $this->_data['msg'] = $this->lable['add_fail'];

                    $this->parser->parse("general/nogrant.tpl", $this->_data);

                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return;

                }

            }

            

        }

        

        

        /**

         * List items

         * 

         */ 

        function items(){

            

            $this->_data['task'] = $this->lable['general'];

            $this->_data['alert'] = '';

            $this->_data['valid'] = array('name'=>'');

            $this->_data['breadcrumb'] = $this->lable['general'];

            

            $this->general_model->cond = " AND c.avail=1 ";

		

		

            $total = $this->general_model->counterItems();

            $limit = 5;

            // load pagination library 

            $config = array();

            $config['base_url'] = site_url("admin/callme");

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

            // $config['suffix'] ='&' . http_build_query($_GET, '', "&");



            $this->pagination->initialize($config);

            $this->_data["links"] = $this->pagination->create_links();  



            $curpage = $this->input->get('per_page');

            $offset = ($curpage) ? $curpage : 0;      

            $offset = ($offset > 0) ? (($offset - 1) * $limit) : $offset;

            

            $general = $this->general_library->general();

            $items = $this->general_model->getItems();

            

            $tmp = array();

            foreach ($items as $key=>$vl) {

                $type = $vl['type'];

                if(array_key_exists($type, $general)) {        		

                    $tmp[$type][] = array('name'=>$general[$type], 'record'=> $vl);        		

                }

            } 

            

            $this->_data['preset_general'] = $general;

            $this->_data['items'] = $tmp;

            

            $this->parser->parse("general/items.tpl", $this->_data);

            

//            $test = $this->general_model->selectItems("'hotel'");

//            echo '<pre>';

//            print_r($test);

            

        }

	

      



}