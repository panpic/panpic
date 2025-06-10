<?php
/**
* Controllers Backend Location Destination
* Last update 28 August 2018
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 28 August 2018
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destination extends MY_Controller{


    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->model('tourdestination_model');
        $this->load->library('nestedtourdestination_library');

        $this->_data['dir_path']  = $this->_path_upload;
        $this->_data['link_upload']  = $this->_link_upload;

        $this->_data['ACTIVE_DUPLICATE'] = ACTIVE_DUPLICATE;

        $this->_pathImg = $this->config->item('path_category');
        $this->_data['dir_path']  = base_url().$this->config->item('dir_category');
        $this->load->library('Slim_library');

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
        $this->load->library('form_validation');

        $data = $this->tourdestination_model->listItem(0,'all',0);
                
        $cId = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : 'add';
        $this->_data['option'] = $option;

        $this->_data['breadcrumb'] = $this->lable['agency'];
        $this->_data['alert'] = '';

        if(!empty($cId) && ($option=='edit' || $option=='sub')) {			
            $row = $this->tourdestination_model->getNodeInfo($cId);
            $this->_data['data'] = $row;
            $this->_data['task'] = $this->lable['edit'];
        } else {
            $this->_data['task'] = $this->lable['add_new'];
        }
        
        $arrNested = $this->nestedtourdestination_library->cmbNested($data, $option, $cId, $row);
        $this->_data['arrNested'] = $arrNested;
        
        $this->parser->parse("destination/addnested.tpl", $this->_data);
    }

        
    /**
     * Process form add
     */
    function processnested() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $data = $this->tourdestination_model->listItem(0,'all',0);
        $orderArr = $this->tourdestination_model->orderGroup($data);
        $row = '';

        $option = $this->input->post('option');
        $params = $this->input->post('data');
        $old = $this->input->post('old');
        
        $primary	= $params['tour_destination_id'];
        $parents	= $params['parents'];
        $cat_name 	= $params['cat_name'];
        $slug 	    = $params['slug'];
        $cat_name_unicode   = $params['cat_name_unicode'];
        $cat_name_lable     = $params['cat_name_lable'];
	    $starting_latitude  = $params['starting_latitude'];
        $starting_longtitude= $params['starting_longtitude'];
        $home = $params['home'];
        $link_gmap = $params['link_gmap'];

        $seo_title 	= $params['seo_title'];
        $seo_description= $params['seo_description'];
        $cId = !empty($primary) ? $primary : '';
        
        if($option == 'edit' && !empty($cId)){
            $row = $this->tourdestination_model->getNodeInfo($cId);
            $this->_data['data'] = $row;
        }

        $this->_data['task'] = $this->lable['tour_category'];
        $this->_data['option'] = $option;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['tour_category'];

        $arrNested = $this->nestedtourdestination_library->cmbNested($data, $option, $cId, $row);
        $this->_data['arrNested'] = $arrNested;

        $node = array(
            'cat_name'          => addslashes($cat_name),
            'slug'              => $slug,
            'cat_name_unicode'  => $cat_name_unicode,
            'cat_name_lable'    => addslashes($cat_name_lable),

            'link_gmap'         => $link_gmap,
            'home'              => $home,
            'starting_latitude' => $starting_latitude,
            'starting_longtitude'=> $starting_longtitude,
            'seo_title'         => $seo_title,
            'seo_description'   => addslashes($seo_description)
        );

        $banner_file = $this->upload('path_image');
        if($banner_file != '') {
            $node['cat_icon'] = $banner_file;
        }

        if (!empty($cat_name) && $option == 'edit') { //Update

            $update = $this->tourdestination_model->updateNode($node, $cId, $parents);

            if ($update) { 

                $back_url = admin_url($this->_control."/viewnested");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['edit_succ'];
                $this->_data['data'] = $params;
                $this->parser->parse("destination/addnested.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return; 
            } else { 
                // if($flag_change_img) { @unlink($this->_pathImg.'/'.$node['cat_icon']); }
                
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['edit_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("destination/addnested.tpl", $this->_data);
                return;
            }

        } else { //insert 
            $insert = $this->tourdestination_model->insertNode($node, $parents); 
            if ($insert) { 
                $back_url = admin_url($this->_control."/");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['add_succ'];
                $this->_data['data'] = $params;
                $this->parser->parse("destination/addnested.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return; 
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['add_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("destination/addnested.tpl", $this->_data);
                return;
            }
        }
        
    }


    function duplicate() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $id = $this->input->get('id');
        if (!$id) {
            redirect(admin_url('destination/viewnested/'));
        }

        $params = $this->tourdestination_model->getNodeInfo($id);

        $random = substr(md5(mt_rand()), 0, 7);
        $slug = $params['slug']."-$random";
        $parents	= $params['parents'];

        $node = array(
            'cat_name'          => stripslashes($params['cat_name']),
            'slug'              => $slug,
            'cat_name_unicode'  => $params['cat_name_unicode'],
            'cat_name_lable'    => stripslashes($params['cat_name_lable']),
            'cat_icon'          => $params['cat_icon'],
            'link_gmap'         => $params['link_gmap'],
            'starting_latitude' => $params['starting_latitude'],
            'starting_longtitude'=> $params['starting_longtitude'],
            'seo_title'         => $params['seo_title'],
            'seo_description'   => stripslashes($params['seo_description'])
        );

        $insert = $this->tourdestination_model->insertNode($node, $parents);
        if ($insert) {
            $this->_data['alert'] = 'success';
            $this->_data['msg'] = $this->lable['duplicate_success'];
        } else {
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $this->lable['duplicate_fail'];
        }

        $back_url = admin_url("destination/viewnested/");
        $this->parser->parse("destination/addnested.tpl", $this->_data);
        header("refresh:".$this->lable['timewait'].";url=".$back_url."");
        return;
    }

        
    /**
     * List items
     * 
     */ 
    function viewnested(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $cat_name = $this->input->get('cat_name');
        $keySearch = '';
        $cond = '';
        $search = '';
        if($cat_name != '') {
            $cond = " AND dscr.cat_name LIKE'%$cat_name%' ";
            $keySearch = "cat_name=".$cat_name;
            $this->_data['search'] = array('cat_name' => $cat_name);
        }

        $this->_data['heading'] = $this->lable['agency'];
        $this->_data['cat_name'] = $cat_name;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['tour_category'];

        $total = $this->tourdestination_model->countItemByCond($cond, 0);

        $limit = 10;
        // load pagination library 
        $config = array();
        $config['base_url'] = site_url("admin/destination/viewnested");
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
        $config['cur_tag_open'] = '<li citemsByCondlass="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        // $config['suffix'] ='&' . http_build_query($_GET, '', "&");

        $this->pagination->initialize($config);
        $this->_data["links"] = $this->pagination->create_links();  

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;      
        $offset = ($offset > 0) ? (($offset - 1) * $limit) : $offset;

        $items = $this->tourdestination_model->itemsByCond($cond, $limit, $offset, 0);
        $this->_data['items'] = $items;
        $this->parser->parse("destination/viewnested.tpl", $this->_data);
    }
	

    /**
     * Remove physical
     * 
     * @param int $id
     * @return void
     */
    function delnested() {
         
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->_data['task'] = $this->lable['tour_category'];
        $this->_data['breadcrumb'] = $this->lable['tour_category'];
        
        $id = $this->input->get('id');

        $back_url = admin_url($this->_control."/viewnested/");
        
        if(!empty($id)){

            $status = $this->tourdestination_model->removeNode($id, 'branch');
            
            if($status) {
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['delete_succ'];
                $this->parser->parse("destination/delnested.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            }else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['delete_fail'];
                $this->parser->parse("destination/delnested.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            }

        } else {			
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $this->lable['delete_fail'];
            $this->parser->parse("destination/delnested.tpl", $this->_data);
            header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
            return;			
        }
     }



    private function upload($fileName) {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $fileNameNew = '';

        $file_path_year = $this->_path_upload.'/'. $year;
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year .'/'.  $month;
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month .'/'.  $day ;
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE); }

        $new_path = $year.'/'.$month.'/'.$day.'/';
        $images     = $this->slim_library->getImages($fileName);
        $image      = $images[0];
        $new_img    = $image['output']['name'];

        $old = $this->input->post('old');

        if($new_img){
            $data_img   = $image['output']['data'];
            $flag_change_img = 0;
            $old_img = $this->slim_library->oldImageName($old[$fileName]);
            if($new_img != $old_img) { // check if not change image
                $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
                $params[$fileName] = $new_path.$file['name']; //$file['path']
                $flag_change_img = 1;
            }
        }

        $image_bg   = $this->slim_library->getImages($fileName);
        $img_bg     = $image_bg[0];
        $new_img_bg = $img_bg['output']['name'];

        if($new_img_bg){
            $data_img_bg    = $img_bg['output']['data'];
            $old_fileName = $this->slim_library->oldImageName($old[$fileName]);
            if($new_img_bg != $old_fileName) {
                $file_bg = $this->slim_library->saveFile($data_img_bg, $new_img_bg, $file_path_day);
                $fileNameNew = $new_path.$file_bg['name'];
            }
        }

        return $fileNameNew;
    }


}