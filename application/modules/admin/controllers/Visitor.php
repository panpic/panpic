<?php

/**

* Controllers Backend visitor

* Last update 10 Jan 2017

* 

* @package backend

* @copyright PANPIC

* @author 

* @author position: PHP Developer

* @since 10 Jan 2017

*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Visitor extends MY_Controller{

	

	private $_data;

	

	

	public function __construct(){

            parent::__construct();

            

            $this->_data['admin_cpanel_title'] = $this->lable['admin_cpanel_title'];

            $this->_data['base_url'] = $this->config->item("base_url");

            $this->_data['base_tlp_admin'] = $this->config->item("base_tlp_admin");

            $this->_data['base_url_admin'] = $this->config->item("base_url_admin");

            $this->_data['current_control'] = $this->router->class;

            $this->_data['current_method'] = $this->router->method; // phuong thuc dang dung





            $this->_data['lable'] = $this->lable;

            $this->_data['user_data'] = $this->session->userdata('login');

            

            $this->load->model('Visitor_model');  

            $this->load->helper('url');

            $this->load->library('pagination');

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

     * Danh sach visitor

     * @return void

     */

	function index($start=0){

            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

            $this->_data['task'] = "Visitor management";

            $this->_data['breadcrumb'] = '';

            $this->_data['alert'] = '';

            

            $keyword = $this->input->get('keyword');

            $more_url = '';

            $search['value'] = '';

            $cond='';

            if($keyword != '')

            {

                  $keyword = trim($keyword);

                  $cond  = "  first_name LIKE '%$keyword%' OR middle_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' ";

                  $search['value'] =$keyword;

                  $more_url = "keyword = $keyword";

            }

            $this->_data['search'] = $search;

            $cond = ($cond != '') ? "WHERE avail = 1 AND $cond" : ' WHERE avail = 1 ';

             

            $curpage = $this->input->get('per_page');

            $curpage = (int)$curpage;

            // load pagination library 

            $totalItems  = $this->Visitor_model->countItem($cond);

            $per_page    = 5;//$this->lable['per_item_admin']; 

            $base_url    = admin_url('visitor'); 

            $uri_segment = 4;

            $this->load->library('pagination_library'); 

            $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url); 

            $this->_data['links'] = $this->pagination->create_links(); 



            $curpage = $this->input->get('per_page');

            $offset = ($curpage) ? $curpage : 0;      

            $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;



            $this->_data['items'] = $this->Visitor_model->fetch_items($cond, $per_page, $start);

            //pre($this->_data['items']);

            //load notifaction 

            $this->_data['alert'] = $this->session->flashdata('alert'); 

            $this->_data['msg']   = $this->session->flashdata('msg');



           // $this->_data['items'] = $this->Visitor_model->fetch_items($cond,$limit, $offset);

            $this->parser->parse("visitor/items.tpl", $this->_data);         

	}





      function deletemulti()

      {

            $checkAll = $this->input->post('checkAll');

            $params = array(

                'avail' => 0,

                );

            foreach ($checkAll as $id) {

                $status = $this->Visitor_model->updateItem($id,$params);

            }

            if($status)

            {

            $this->session->set_flashdata('alert','success');

            $this->session->set_flashdata('msg', $this->lable['delete_succ']);

            }     

            redirect(admin_url('visitor')); 

      }



    /**

     * Recycle bin

     *

     * @param int $avail = 1

     * @return void

     */

    

    function inactive($start=0)

    {

      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

          $this->_data['task'] = "Visitor management";

            $this->_data['breadcrumb'] = '';

            $this->_data['alert'] = '';

            

            $keyword = $this->input->get('keyword');

            $more_url = '';

            $search['value'] = '';

            $cond='';

            if($keyword != '')

            {

                  $keyword = trim($keyword);

                  $cond  = "  first_name LIKE '%$keyword%' OR middle_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' ";

                  $search['value'] =$keyword;

                  $more_url = "keyword = $keyword";

            }

            $this->_data['search'] = $search;

            $cond = ($cond != '') ? "WHERE avail = 0 AND $cond" : ' WHERE avail = 0 ';

             

            $curpage = $this->input->get('per_page');

            $curpage = (int)$curpage;

            // load pagination library 

            $totalItems  = $this->Visitor_model->countItem($cond);

            $per_page    = 5;//$this->lable['per_item_admin']; 

            $base_url    = admin_url('visitor/inactive'); 

            $uri_segment = 4;

            $this->load->library('pagination_library'); 

            $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url); 

            $this->_data['links'] = $this->pagination->create_links(); 



            $curpage = $this->input->get('per_page');

            $offset = ($curpage) ? $curpage : 0;      

            $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;



            $this->_data['items'] = $this->Visitor_model->fetch_items($cond, $per_page, $start);

            //pre($this->_data['items']);

            //load notifaction 

            $this->_data['alert'] = $this->session->flashdata('alert'); 

            $this->_data['msg']   = $this->session->flashdata('msg');



           // $this->_data['items'] = $this->Visitor_model->fetch_items($cond,$limit, $offset);

            $this->parser->parse("visitor/inactive.tpl", $this->_data);     

    }



        function active()

        {

            $checkAll = $this->input->post('checkAll');

            $params = array(

                 'avail' => 1,

                );

            foreach($checkAll as $id)

            {

                $status=$this->Visitor_model->updateItem($id,$params);

            }

            if($status)

            {

                $this->session->set_flashdata('alert','success');

                $this->session->set_flashdata('msg', $this->lable['request_succ']);

            }

             redirect(admin_url('visitor'));

        }

     /**

         * remove one item from inactive

         * @return void

         */

        function removeOne()

        {

            $id  = $this->input->get('id');

            $this->Visitor_model->id = $id;

            $this->Visitor_model->deleteItem( array('id'=>$id) );

            

            $this->session->set_flashdata('alert','success');

            $this->session->set_flashdata('msg', $this->lable['delete_succ']);



            redirect(admin_url('visitor/inactive')); 

       }

       

       /**

        * remove multi items from inative

        * @return void

        */

       function removeMulti()

        {

            $checkAll = $this->input->post('checkAll');

            foreach($checkAll as $id)

             {

                $this->Visitor_model->id = $id;

                $this->Visitor_model->deleteItem( array('id'=>$id) );

             } 

            $this->session->set_flashdata('alert','success');

            $this->session->set_flashdata('msg', $this->lable['delete_succ']);



           redirect(admin_url('visitor/inactive')); 

       }

       

       /**

         *  export to excel 

         */

        function sendNewLetter(){

            $visitor_id  = $this->input->post('checkAll');

            $back_url = $this->_data['base_url_admin'].'/'.$this->_data['current_control']; 

            if(!$visitor_id ) redirect($back_url) ; 

            

            header("Content-Type: application/vnd.ms-excel");

            header("Content-Disposition: attachment; filename=Visitor-".date('d-m-Y').".xls");

            header("Pragma: no-cache");

            header("Expires: 0");

            

            if(($key = array_search(1, $visitor_id)) !== false) {

                unset($visitor_id[$key]);

            }

            $ids = implode(',', $visitor_id); 

            

            $cond = "WHERE FIND_IN_SET( id, '$ids')";

            $items = $this->Visitor_model->fetch_items($cond);

            $this->_data['items'] = $items; 

            $this->parser->parse("visitor/sendnewletter.tpl", $this->_data);

            

        }

       





       

    

     



   

      



}