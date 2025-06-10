<?php
/**
* Controllers Backend login
* Last update 03 Mar 2017
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 11 Jan 2017
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Experience extends MY_Controller{
	
    
	private $_data;
        private $_control; 
        private $_action;
        private $_pathLogo; 
        private $_pathThumb; 
	
	
    public function __construct(){
        parent::__construct();
        $this->load->model('experience_model'); 
        $this->load->library('Slim_library'); 

        $this->_data['admin_cpanel_title'] = $this->lable['admin_cpanel_title'];
        $this->_data['base_url']           = $this->config->item("base_url");
        $this->_data['base_tlp_admin']     = $this->config->item("base_tlp_admin");
        $this->_data['base_tlp_front']     = $this->config->item("base_tlp_front");
        
        $this->_data['base_url_admin']     = $this->config->item("base_url_admin");
        $this->_data['lable']              = $this->lable;
        $this->_data['user_data']          = $this->session->userdata('login');

        $this->_control                 = $this->router->class;
        $this->_action                  = $this->router->method; 
        $this->_pathLogo                = $this->config->item('path_logo');
        $this->_pathThumb               = $this->config->item('path_thumb'); 
        
        $this->_dirThumb                = $this->config->item('base_url').$this->config->item('dir_thumb'); 

        $this->_data['pathThumb']       = $this->_dirThumb;
        $this->_data['current_control'] = $this->_control; 
        $this->_data['current_method']  = $this->_action; 

        $back_url = admin_url($this->_control.'/add');

        $this->load->model('general_model');
        $this->load->library('general_library');
        $this->load->library('user_agent');
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


    function index(){
        $this->_data['breadcrumb'] = '';
        $this->_data['task']       = "List of agencies";
        $this->_data['alert']      = $this->session->flashdata('alert'); 
        $this->_data['msg']        = $this->session->flashdata('msg');
        $cond = ''; 
        $more_url = ''; 
        //$cond .= " AND a.avail = 1"; 
        $keyword = trim(strip_tags($this->input->get('q')));
        
        if($keyword){
            $cond .= " AND ( t.title LIKE '%{$keyword}%' OR t.tour_sku LIKE '%{$keyword}%' OR t.short_description LIKE '%{$keyword}%'  ) ";
            $more_url .= "&keyword=$keyword";
        }
        
        $this->_data['keyword'] = $keyword; 
        
        $totalItems  = $this->experience_model->countItems($cond);
        
            
        $per_page    = $this->lable['per_item_admin']; 
        $base_url    = admin_url('experience/index'); 
        $uri_segment = 4;
        $this->load->library('pagination_library'); 
        $this->pagination_library->pagination($base_url, $totalItems,$per_page,$uri_segment,$more_url); 
        $this->_data['links'] = $this->pagination->create_links(); 
        
        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;      
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

        $items = $this->experience_model->getItems($cond, $per_page, $start);
        
        $this->_data['items'] = $items; 
        $this->parser->parse("experience/index.tpl", $this->_data);
    }

    function add(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->_data['breadcrumb'] = '';
        $this->_data['task']       = "List of experience image";
        $this->_data['alert']      = $this->session->flashdata('alert'); 
        $this->_data['msg']        = $this->session->flashdata('msg');

        $tour_id = $this->input->get('id'); 
        $images = ''; 
        
        
        
        if($tour_id){
            $infoTour = $this->experience_model->getInfoTour($tour_id);
            $images  = $this->experience_model->getImageByItem($tour_id);
        }
        
        //pre($images);
        $infoTour = !empty($infoTour) ? $infoTour : '';  
        
        $this->_data['data_image'] = $images;
        $this->_data['infoTour'] = $infoTour;
        
        $this->parser->parse("experience/add.tpl", $this->_data);

    }
        
     
    
    function uploadImage(){
            
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 
            $this->load->library('Slim_library'); 

            $year  = date('Y'); 
            $month = date('m'); 
            $day   = date('d'); 

            $file_path_year = $this->_pathThumb.'/'. $year;
            if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

            $file_path_month = $file_path_year .'/'.  $month;
            if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

            $file_path_day = $file_path_month .'/'.  $day ; 
            if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

            $new_path = $year.'/'.$month.'/'.$day.'/';

            try {
                $images = $this->slim_library->getImages('image');
            } catch (Exception $e) {
                $this->slim_library->outputJSON(SlimStatus::Failure);
                return;
            }
            // if no images found
            if (count($images) === 0) {
                $this->slim_library->outputJSON(SlimStatus::Failure);
                return;
            }

            // should always be one file (when posting async)
            $image = $images[0];
            
            //$meta = json_encode($image['meta']); 
            $meta = $image['meta']; 
            
            $tour_id  = $meta->tourId;
            $image_id = $meta->id;
            $infoImage = $this->experience_model->getInfoItem($image_id);
            
           // $new_img = $image['input']['name']; 
            $old_img = $this->slim_library->oldImageName($infoImage['path_image']);
            $new_img = ($old_img == $image['input']['name']) ? substr($old_img, 14) : $image['input']['name']; 
            
            
            
            $file  = $this->slim_library->saveFile($image['output']['data'], $new_img, $file_path_day);
            
            $_data = array(
                'image_id'          => $image_id, 
                'path_image'        => $new_path.$file['name'], 
                'object_id'         => $tour_id, 
                'image_type'        => 'exp',
            );
            
            $status = $this->experience_model->insertImage($_data);
            if($status == $image_id){ 
                @unlink($this->_pathThumb.'/'.$infoImage['path_image']);
            }
            echo $status;         
    }
    
    
    function form_image(){
        $tour_id = $this->input->post('tour_id'); 
        $this->_data['tour_id'] = $tour_id; 
        $temp = $this->parser->parse("experience/form_image.tpl", $this->_data, TRUE);
        echo $temp; die; 
        //$this->parser->parse("experience/form_image.tpl", $this->_data);
    }
    
    
    /**
     * 
     */
    function autocomplete() {
        
        $key =  $this->input->post_get('term');
        
        if($key) {
            $list1 = $this->experience_model->searchTour(" AND t.title LIKE '%$key%' ");

            foreach($list1 as $value){
                $item1['tour_id'] = $value['tour_id'];
                $item1['title'] = $value['title'];
                $result[] = $item1; 
            }

            die(json_encode($result));
        }
    }
    
    function removeImage(){
        $image_id = $this->input->post('image_id'); 
        $infoImage = $this->experience_model->getInfoItem($image_id);
        $status = $this->experience_model->removeImage($image_id);
        if($status){
            @unlink($this->_pathThumb.'/'.$infoImage['path_image']);
            echo 1; return; 
        }      
    }
    
    
    /*
    function deleteImage(){
        $image_id = $this->input->post('id'); 
        $infoImage = $this->experience_model->getInfoItem($image_id);
        
        $stauts = $this->experience_model->delImage($image_id);
        
        if($stauts){
            @unlink($this->_pathThumb . '/' . $infoImage['path_image']);
        }
        var_dump($stauts);
        
    }
     * 
     */
        
       
        
       


      

}
