<?php

/**

* Controllers Backend Blogs

* Last update 8 Mar 2017

* 

* @package backend

* @copyright PANPIC

* @author contact@panpic.vn

* @author pos: PHP Developer

* @since 8 Mar 2017

*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Banks extends MY_Controller{

	





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



        $this->_pathImg = $this->config->item('path_thumb');

        $this->_data['dir_path']  = $this->_pathImg;

        $this->_data['dir_thumb']  = $this->_data['base_url'].$this->config->item('dir_thumb');



        $this->load->model('banks_model');

        $session_admin            = $this->session->userdata('login');
        $this->_data['user_data'] = $session_admin;
        $adminPermission          = $session_admin->adminPermission;
        $super_admin = $this->config->item("super_admin");

        $this->load->library('admin_permission');

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



        $this->_data['breadcrumb'] = $this->lable['banks'];

        $this->_data['alert'] = '';



        $_data = $this->input->post('data');

        $bank_id = $this->input->post_get('bank_id');

        $option = $this->input->get('option');

        $option = !empty($option) ? $option : 'add';



        if (!empty($bank_id) && $option == 'edit') {

           

            $data = $this->banks_model-> getItemById($bank_id);

        }



        $this->_data['option'] = $option;

        $this->_data['data'] = $data;

        $this->parser->parse("banks/index.tpl", $this->_data);

    }



        

   function items() 

   {

      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));



        $this->_data['breadcrumb'] = $this->lable['banks'];

        $this->_data['alert'] = '';



        $keyword = $this->input->get('keyword');

        $more_url = '';

        $search = '';

        $cond = '';

        if($keyword != '')

        {

            $keyword = trim($keyword);

            $cond = " bank_name LIKE  '%{$keyword}%' OR bank_id LIKE '%{$keyword}%'";

            $search = $keyword;

            $more_url = "keyword = $keyword";

        }

        $this->_data['search'] = $search;

        $cond = ($cond != '') ? "WHERE avail = 1 AND $cond" : ' WHERE avail = 1 ';



        // $item = $this->banks_model->items($cond);

        // $this->_data['item'] = $item;

      

        $totalItems = $this->banks_model->countItem($cond);

        $per_page = 5;

        $base_url = admin_url('banks/items');

        $uri_segment = 4;

        $this->load->library('pagination_library');

        $this->pagination_library->pagination($base_url,$totalItems,$per_page,$uri_segment,$more_url);

        $this->_data['links'] = $this->pagination->create_links();



        $curpage = $this->input->get('per_page');

        $offset = ($curpage) ? $curpage : 0;      

        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

         

        $this->_data['item'] = $this->banks_model->items($cond, $per_page, $start);



        $this->parser->parse("banks/items.tpl", $this->_data);

   } 

     



    function add()

    {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));



        $_data = $this->input->post('data');

        $bank_id = $this->input->post('bank_id');

        $option = $this->input->post('option');



        $params = array(

             'bank_name' => $_data['bank_name'],

             'bank_info' => $_data['bank_info'],

             'date_add' => $_data['date_add'],

        );



      

        if(!empty($bank_id) && $option == 'edit')

        {

            $update = $this->banks_model->updateItem($bank_id,$params);



            if($update){



                $back_url = admin_url("banks/items/");

                $this->_data['alert'] = 'success';

                $this->_data['msg'] = $this->lable['edit_succ'];

                $this->parser->parse("banks/index.tpl", $this->_data);

                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                return;

            }

            else{

                $this->_data['alert'] = 'danger';

                $this->_data['msg'] = $this->lable['edit_fail'];

                $this->_data['data'] = $params;

                $this->parser->parse("banks/index.tpl", $this->_data);

                return; 

            }

        }

        else

        {

             $insert = $this->banks_model->insertItem($params);



            if($insert)

            {

                $back_url = admin_url("banks/items");

                $this->_data['alert'] = 'success';

                $this->_data['msg'] = $this->lable['add_succ'];

                $this->parser->parse("banks/index.tpl", $this->_data);    

                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                    return;

            }

            else

            {

                $this->_data['alert'] = 'danger';

                $this->_data['msg'] = $this->lable['add_fail'];

                $this->_data['data'] = $params;

                $this->parser->parse("banks/index.tpl", $this->_data);

                return;

            }

        }



    }



    function deletemulti()

    {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));



        $checkAll = $this->input->post('checkAll');



        foreach($checkAll as $bank_id)

        {

            $data = $this->banks_model->getItemById($bank_id);

            $this->banks_model->deleteItem( array('bank_id'=>$bank_id) );

        }



        $back_url = admin_url("banks/items");

        $this->_data['alert'] = 'success';

        $this->_data['msg'] = $this->lable['delete_succ'];

        $this->parser->parse("banks/items.tpl", $this->_data);    

        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

        return; 

    }



}