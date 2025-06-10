<?php

/**

* Controllers Backend Special management

* Last update 03 Mar 2017

* 

* @package backend

* @copyright PANPIC

* @author contact@panpic.vn

* @author pos: PHP Developer

* @since 03 Mar 2017

*/



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Special extends MY_Controller{

	



    private $_data;

    private $_pathImg;





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

        $this->_data['dir_thumb'] = $this->_data['base_url'].$this->config->item('dir_thumb');



        $this->load->model('special_model');

        $this->load->library('Slim_library');

        $this->load->model('general_model');

        $this->load->library('general_library');

        

        $this->load->model('tourdestination_model');

        $this->load->library('nestedtourdestination_library');

        $this->load->library('admin_permission');

        $session_admin          = $this->session->userdata('login');
        $this->_data['user_data'] = $session_admin;
        $adminPermission= $session_admin->adminPermission;

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



        $this->_data['breadcrumb'] = $this->lable['special_management'];

        $this->_data['alert'] = '';



        $id = $this->input->get('id');

        $option= $this->input->get('option');

        $option = !empty($option) ? $option : 'add';

        $this->_data['option'] = $option;

        $this->_data['task'] = $this->lable[$option];



        $data = array();



        if (!empty($id) && $option == 'edit') {

            $this->special_model->id = $id;

            $data = $this->special_model->getItemById();

            // $data_slug = $this->special_model->getSlugById();

            // $data['slug'] = $data_slug['slug'];

            

        }

        

		// $row = $this->special_model->getDestinationById($data['destination_id']);

		

        $row = $this->tourdestination_model->getNodeInfo($data['destination_id']);

        $dataTourdestination = $this->tourdestination_model->listItem(0,'all',0);

        $arrNested = $this->nestedtourdestination_library->cmbNested($dataTourdestination, 'sub', $data['destination_id'], $row);

        

        

        //pre($arrNested);

        

        $this->_data['arrNested'] = $arrNested;

        

        // $this->_data['categories'] = $this->special_model->blogCategories();

        $general = $this->general_model->selectItems("'des_suggest'"); 

        

        

        $this->_data['data'] = $data;

        $this->_data['general'] = $general;

        $this->_data['valid'] = '';



        $this->parser->parse("special/index.tpl", $this->_data);

    }



        

    /**

     * Process form add

     */

    function add() {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));



        $_data = $this->input->post('data');

        $id = $this->input->post('primary');

        $old = $this->input->post('old');



        $option = $this->input->post('option');

        $this->_data['task'] = $this->lable[$option];

        $this->_data['option'] = $option;

        $this->_data['breadcrumb'] = $this->lable['special_management'];

        

        $destination_id = $_data['destination_id'];

        

        $dataTourdestination = $this->tourdestination_model->listItem(0,'all',0);

        $arrNested = $this->nestedtourdestination_library->cmbNested($dataTourdestination, $option, $destination_id, '');

        $this->_data['arrNested'] = $arrNested;

        

        $general = $this->general_model->selectItems("'des_suggest'"); 

        $this->_data['general'] = $general;

        

        $params = array(

            'destination_id'=> $destination_id,

            'title'         => addslashes($_data['title']),

            'category'      => $_data['category'],

            'latitude'      => $_data['latitude'],

            'longtitude'    => $_data['longtitude'],

        );

        

        $year  = date('Y'); 

        $month = date('m'); 

        $day   = date('d'); 



        $file_path_year = $this->_pathImg.'/'. $year;

        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }



        $file_path_month = $file_path_year .'/'.  $month;

        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }



        $file_path_day = $file_path_month .'/'.  $day ; 

        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}



        $new_path = $year.'/'.$month.'/'.$day.'/';



        $images     = $this->slim_library->getImages('path_image');

        $image      = $images[0];

        $new_img    = $image['output']['name'];

        

        if($new_img){

            $data_img   = $image['output']['data'];

            $flag_change_img = 0;

            $old_img = $this->slim_library->oldImageName($old['path_image']);

            

            if($new_img != $old_img) { // check if not change image

                $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);

                $params['path_image'] = $new_path.$file['name']; //$file['path'] 

                $flag_change_img = 1;

                

            }

            

                

            

        }

        

        

        //@ Validation

        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');



        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('data[title]', $this->lable['title'], 'required', array(

                'required' => $this->lable['require_field_string']

            ));

        

        $this->form_validation->set_rules('data[category]', $this->lable['category'], 'required', array(

            'required' => $this->lable['require_field_string']

        ));

        

        $error_destination = '';

        if($destination_id <= 1) {

            $error_destination = $this->lable['tour_destination'].' '.$this->lable['invalid'];

        }

        

        if($this->form_validation->run() == FALSE || $error_destination != '') {



            if ($option == 'edit') {

                $msg = $this->lable['edit_fail'];

            } else {

                $msg = $this->lable['add_fail'];

            }



            $errors = $this->form_validation->error_array();



            $valid = array(

                'destination_id' => $error_destination,

                'title' => $errors['data[title]'],

                'category' => $errors['data[category]']

            ); 



            $this->_data['valid'] = $valid;

            $this->_data['alert'] = 'danger';

            $this->_data['msg'] = $msg;

            $this->_data['data'] = $params;



            $this->parser->parse("special/index.tpl", $this->_data);

            return;

        }



        if ( !empty($id) && $option == 'edit' ) { //Update



            $this->special_model->id = $id;

            $update = $this->special_model->updateItem($params);



            if ($update) {



                if($flag_change_img) { @unlink($this->_pathImg.'/'.$old['path_image']); }

                

                $back_url = admin_url("special/items/");

                $this->_data['alert'] = 'success';

                $this->_data['msg'] = $this->lable['edit_succ'];

                // $this->_data['data'] = $params;

                $this->parser->parse("special/index.tpl", $this->_data);

                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                return; 

            } else {

                $this->_data['alert'] = 'danger';

                $this->_data['msg'] = $this->lable['edit_fail'];

                $this->_data['data'] = $params;

                $this->parser->parse("special/index.tpl", $this->_data);

                return;

            }



        } else { //insert



            $insert = $this->special_model->insertItem($params);



            if ($insert) { 

                $back_url = admin_url("special/");

                $this->_data['alert'] = 'success';

                $this->_data['msg'] = $this->lable['add_succ'];

                // $this->_data['data'] = $params;

                $this->parser->parse("special/index.tpl", $this->_data);    

                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

                return; 

            } else {

                $this->_data['alert'] = 'danger';

                $this->_data['msg'] = $this->lable['add_fail'];

                $this->_data['data'] = $params;

                $this->parser->parse("special/index.tpl", $this->_data);

                return;

            }

        }



    }





    /**

     * List items

     * 

     */ 

    function items($start=0){

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $keyword = $this->input->get('q');

        $category = $this->input->get('cat');

        

        $cond = '';

        $more_url = '';

        $keyword = trim(strip_tags($keyword));

        if($keyword){

            $cond .= " AND c.title LIKE '%{$keyword}%'";

            $more_url .= "q=$keyword";

            $this->_data['search'] = $keyword;

        }

        

        /*

        if($category) {

            $cond .= " AND c.category = $category ";

            $more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";

            $this->_data['cat'] = $category;

        }

        */

        

        // $this->_data['more_url'] = $more_url;

        $this->_data['alert'] = '';

        $this->_data['breadcrumb'] = $this->lable['special_management'];

        // $this->_data['categories'] = $this->special_model->blogCategories();

        

        $totalItems  = $this->special_model->countItems($cond); 

        $per_page    = $this->lable['per_item_admin']; 

        $base_url    = admin_url('special/items'); 

        $uri_segment = 4;

        $this->load->library('pagination_library'); 

        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url); 

        $this->_data['links'] = $this->pagination->create_links();

        

        $curpage = $this->input->get('per_page');

        $offset = ($curpage) ? $curpage : 0;      

        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

        

        $this->_data['items'] = $this->special_model->getItems($cond, $per_page, $start);



        $this->parser->parse("special/items.tpl", $this->_data);

    }

	

    

    /**

     * Remove physical data

     * @return void

     */

    function deletemulti() {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        

        $checkAll = $this->input->post('checkAll');

        

        foreach ($checkAll as $id) {

            

            $this->special_model->id = $id;

            $data = $this->special_model->getItemById();

            @unlink($this->_pathImg.'/'.$data['path_image']);

            

            $this->special_model->deleteItem( array('id'=>$id) );

        }

        

        $back_url = admin_url("special/items/");

        $this->_data['alert'] = 'success';

        $this->_data['msg'] = $this->lable['delete_succ'];

        $this->parser->parse("special/items.tpl", $this->_data);    

        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");

        return; 

    }

    

    

    /**

     * Ajx update avail

     * 

     * @param int $id

     * @param int $s

     * 

     * @return bool

     */

    function update_status() {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $blog_id = $this->input->post('id');

        $avail = $this->input->post('s');

        $avail = ($avail == 1) ? 0 : 1;

        

        if($blog_id != '') {

            $this->special_model->id = $blog_id;

            echo $this->special_model->updateByFields(array('avail'=>$avail));

            return;

        }

        

        echo 0;

        return;

    }

    

   



}