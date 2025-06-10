<?php

/**

* Controllers Backend posting_request

* Last update 11 Jan 2017

* 

* @package backend

* @copyright PANPIC

* @author 

* @author position: PHP Developer

* @since 11 Jan 2017

*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Posting_request extends MY_Controller{

	

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

            

            $this->load->model('Posting_request_model');  

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

     * Danh sach posting_request

     * @return void

     */

	function index($start=0){

           

            $this->_data['task'] = "Posting Request";

            $this->_data['breadcrumb'] = '';

            $this->_data['alert'] = '';

            $status= $this->input->get('s');

            $keyword = $this->input->get('keyword');

            $more_url = '';

            $search['value'] = '';

            $cond = '';

            if($keyword != '') {

                $keyword = trim($keyword);

                $cond = "AND b.agency_name LIKE '%$keyword%'";

                $search['value'] = $keyword;

                $more_url .= "keyword=$keyword";

            }

            $this->_data['search'] = $search;



            if($status != '')

            {

                $cond .= " AND a.status = $status ";

            }



            $cond .= ' AND a.avail = 1 ';



            $totalItems  = $this->Posting_request_model->countItem($cond);

            $per_page    = $this->lable['per_item_admin']; 

            $base_url    = admin_url('posting_request'); 

            $uri_segment = 4;

            $this->load->library('pagination_library'); 

            $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url); 

            $this->_data['links'] = $this->pagination->create_links(); 

            $curpage = $this->input->get('per_page');

            $offset = ($curpage) ? $curpage : 0;      

            $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

            $this->_data['items'] = $this->Posting_request_model->fetch_items($cond, $per_page, $start);

            

            //pre($this->_data['items']); 

            

            //load notifaction 

            $this->_data['alert'] = $this->session->flashdata('alert'); 

            $this->_data['msg']   = $this->session->flashdata('msg');

            

            // $this->_data['items'] = $this->Callme_model->fetch_items($cond,$limit,$offset);

            

            $this->parser->parse("posting_request/items.tpl", $this->_data);

              

         



	}     

    function deletemulti() {

        $checkAll = $this->input->post('checkAll');

        $params = array(

            'avail' => 0

            );

        foreach ($checkAll as $id) {

            $status = $this->Posting_request_model->updateItem($id,$params);

        }

        // redirect 

        $this->session->set_flashdata('alert','success');

        $this->session->set_flashdata('msg', $this->lable['delete_succ']);



        redirect(admin_url('posting_request')); 

    }

    

     /**

     * Recycle bin

     *

     * @param int $avail = 1

     * @return void

     */

    function inactive($status=0)

    {

          $this->_data['task'] = "Posting Request";

            $this->_data['breadcrumb'] = '';

            $this->_data['alert'] = '';

            $status= $this->input->get('s');

            $keyword = $this->input->get('keyword');

            $more_url = '';

            $search['value'] = '';

            $cond = '';

            if($keyword != '') {

                $keyword = trim($keyword);

                $cond = "AND b.agency_name LIKE '%$keyword%'";

                $search['value'] = $keyword;

                $more_url .= "keyword=$keyword";

            }

            $this->_data['search'] = $search;



            if($status != '')

            {

                $cond .= " AND a.status = $status ";

            }



            $cond .= ' AND a.avail = 0 ';



            $totalItems  = $this->Posting_request_model->countItem($cond);

            $per_page    =5;// $this->lable['per_item_admin']; 

            $base_url    = admin_url('posting_request/inactive'); 

            $uri_segment = 4;

            $this->load->library('pagination_library'); 

            $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url); 

            $this->_data['links'] = $this->pagination->create_links(); 

            $curpage = $this->input->get('per_page');

            $offset = ($curpage) ? $curpage : 0;      

            $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

            $this->_data['items'] = $this->Posting_request_model->fetch_items($cond, $per_page, $start);

            

            //load notifaction 

            $this->_data['alert'] = $this->session->flashdata('alert'); 

            $this->_data['msg']   = $this->session->flashdata('msg');

            

            $this->parser->parse("posting_request/inactive.tpl", $this->_data);

              

              

    }



       function active()

       {

        $checkAll = $this->input->post('checkAll');

        $params = array(

            'avail' =>1,

            );

        foreach($checkAll as $id)

        {

            $status=$this->Posting_request_model->updateItem($id,$params);

        }

        if($status)

        {

            $this->session->set_flashdata('alert','success');

            $this->session->set_flashdata('msg', $this->lable['request_succ']);

        }

         redirect(admin_url('posting_request'));

       }



     /**

         * detail call me

         * 

         * @param int $id

         * @return void

         */

        function detail() {

            $this->load->model('tourcat_model'); 

            $this->_data['task'] = "Posting_request";

            $this->_data['breadcrumb'] = $this->lable['general_variable'];

            $this->_data['alert'] = '';



            $id = $this->input->get('id');

            $item = $this->Posting_request_model->getItemById($id);

            // pre($item);   

            $this->_data['item'] = $item;



            $tour_categories = $this->tourcat_model->itemsByCond(" AND c.level =1");



            $this->_data['tour_categories'] = $tour_categories;

            $this->_data['post_status'] = $this->Posting_request_model->post_status;

            //pre($this->_data['post_status']);

            $this->parser->parse("posting_request/detail.tpl", $this->_data);

        }



    /**

     * Ajax update status

     *

     * @param int $id

     * @param int $status

     * @return void

     */

    function updatestatus() {

        $id = $this->input->post('id');

        $status = $this->input->post('st');

        // $status = ($status == 0) ? 1 : 0;

        $params = array(

            'status' => $status

        );

        

        $update = $this->Posting_request_model->updateItem($id, $params);



        if($update) {

            echo 1;

            return ;

        } else {

            echo 0;

            return ;

        }



    }



    function downloadFile() {

        $filename = $this->input->get('f');

        $aryFile = explode(',', $filename);

        $path_download = $this->config->item('path_download');

        $file = $path_download.'/'.$filename; // Đường dẫn 



        $file_extension = $aryFile[count($aryFile)-1];



        if ($file == "") {

        echo "<script>alert('Bạn muốn down file gì?.');</script>";

        exit;

        }

        elseif (!is_file($file)) {

        echo "<script>alert('Không tìm thấy file?.".$filename."');</script>";

        exit;

        };

        switch ($file_extension) {

        case "pdf": $ctype="application/pdf"; break;

        case "exe": $ctype="application/octet-stream"; break;

        case "zip": $ctype="application/zip"; break;

        case "rar": $ctype="application/x-rar-compressed"; break;

        case "doc": $ctype="application/msword"; break;

        case "xls": $ctype="application/vnd.ms-excel"; break;

        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;

        case "gif": $ctype="image/gif"; break;

        case "png": $ctype="image/png"; break;

        case "jpeg":

        case "jpg": $ctype="image/jpg"; break;

        default: $ctype="application/force-download";

        }

        header("Pragma: public");

        header("Expires: 0");

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        header("Cache-Control: private",false);

        header("Content-Type: $ctype");



        header("Content-Disposition: attachment; filename=\"".basename($file)."\";" );

        header("Content-Transfer-Encoding: binary");

        header("Content-Length: ".filesize($file));

        readfile("$file");

        exit();

         }



        

         /**

         * remove one item from inactive

         * @return void

         */

        

        function removeOne()

        {

            $id = $this->input->get('id');

            $this->Posting_request_model->id=$id;

            $this->Posting_request_model->deleteItem( array('id'=>$id) );



            $this->session->set_flashdata('alert','success');

            $this->session->set_flashdata('msg', $this->lable['delete_succ']);



            redirect(admin_url('posting_request/inactive'));

        }





        function  removeMulti()

        {

            $checkAll=$this->input->post('checkAll');

            foreach($checkAll as $id)

            {

                $this->Posting_request_model->id =$id;

                $this->Posting_request_model->deleteItem(array('id'=>$id));



            }

            $this->session->set_flashdata('alert','success');

            $this->session->set_flashdata('msg', $this->lable['delete_succ']);

            redirect(admin_url('posting_request/inactive'));

        }

       

}