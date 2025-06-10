<?php
/**
 * Controllers Backend Blog category
 * Last update 14 Jun 2020
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 23 August 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogcat extends MY_Controller{


    public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->model('postcat_model');
        $this->load->library('nestedpostcat_library');
        $this->load->library('admin_permission');

        $this->load->library('slim_library');
        $this->_data['dir_path']  = $this->_path_upload;
        $this->_data['link_upload']  = $this->_link_upload;

        $this->postcat_model->_lang = $this->current_lang;
        $this->postcat_model->page_lang = $this->page_lang;
        $this->postcat_model->default_lang = $this->default_lang;

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
     */
    function index(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->library('form_validation');
        $this->_data['task'] = $this->lable['add'];
        $this->_data['breadcrumb'] = $this->lable['post_category'];
        $this->_data['alert'] = '';

        $data = $this->postcat_model->listItem(0,'all',0);

        $cId = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : 'add';
        $this->_data['option'] = $option;

        if(!empty($cId) && ($option=='edit' || $option=='sub')) {
            $row = $this->postcat_model->getNodeInfo($cId);
            $this->_data['data'] = $row;
            $tpl = 'edit.tpl';
        } else {
            $tpl = 'add.tpl';
        }

        $arrNested = $this->nestedpostcat_library->cmbNested($data, $option, $cId, $row);
        $this->_data['arrNested'] = $arrNested;
        $this->parser->parse("blogcat/$tpl", $this->_data);
    }


    /**
     * Process form add
     */
    function processnested() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $data = $this->postcat_model->listItem(0,'all',0);
        $orderArr = $this->postcat_model->orderGroup($data);
        $row = '';
        $option = $this->input->post('option');
        $params = $this->input->post('data');
        $primary	= $params['post_cat_id'];
        $parents	= $params['parents'];
        $cat_name 	= $params['cat_name'];
        $cat_slug 	= $params['cat_slug'];
        $cat_note 	= $params['cat_note'];
        $seo_title 	= $params['seo_title'];
        $seo_description= $params['seo_description'];
        $posts_no = $params['posts_no'];
        $home_status = $params['home_status'];

        $cId = !empty($primary) ? $primary : '';
        if($option == 'edit' && !empty($cId)){
            $row = $this->postcat_model->getNodeInfo($cId);
            $this->_data['data'] = $row;
            $tpl = 'edit.tpl';
        } else {
            $tpl = 'add.tpl';
        }

        $this->_data['task'] = $this->lable['post_category'];
        $this->_data['option'] = $option;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['post_category'];
        $arrNested = $this->nestedpostcat_library->cmbNested($data, $option, $cId, $row);
        $this->_data['arrNested'] = $arrNested;

        $cat_icon = $this->slim_upload_image();

        $node = array(
            'cat_name'  => addslashes($cat_name),
            'cat_slug'  => trim($cat_slug),
            'cat_icon'  => $cat_icon,
            'posts_no'  => $posts_no,
            'home_status' => $home_status,
            'cat_note'  => addslashes($cat_note),
            'seo_title' => $seo_title,
            'seo_description' => $seo_description
        );

        if ($primary != '' && $option == 'edit') { //Update

            $this->postcat_model->_lang = $this->current_lang;
            $update = $this->postcat_model->updateNode($node, $cId, $parents);

            if ($update) {
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['edit_succ']);
                redirect( admin_url($this->_control."/viewnested") );
            } else {
                $this->session->set_flashdata('alert', 'danger');
                $this->session->set_flashdata('msg', $this->lable['edit_fail']);
                redirect( admin_url("blogcat/?id=$cId&option=edit") );
            }
        } else { //insert
            
            $insert = $this->postcat_model->insertNode($node, $parents);
            if ($insert) {
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['add_succ']);
                redirect( admin_url($this->_control) );
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['add_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("blogcat/$tpl", $this->_data);
                return;
            }
        }
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
        }
        $this->_data['cat_name'] = $cat_name;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['post_category'];
        $total = $this->postcat_model->countItemByCond($cond, 0);

        $limit = 10;
        // load pagination library
        $config = array();
        $config['base_url'] = site_url("admin/blogcat/viewnested/");
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
        $items = $this->postcat_model->itemsByCond($cond, $limit, $offset, 0);
        $this->_data['items'] = $items;

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->parser->parse("blogcat/viewnested.tpl", $this->_data);
    }


    /**
     * Remove physical
     *
     * @param int $id
     * @return void
     */
    function delnested() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->_data['task'] = $this->lable['post_category'];
        $this->_data['breadcrumb'] = $this->lable['post_category'];

        $id = $this->input->get('id');
        $back_url = admin_url($this->_control."/viewnested/");

        if(!empty($id)){
            $status = $this->postcat_model->removeNode($id, 'branch');
            if($status) {
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['delete_succ'];
                $this->parser->parse("blogcat/delnested.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            }else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['delete_fail'];
                $this->parser->parse("blogcat/delnested.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            }
        } else {
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $this->lable['delete_fail'];
            $this->parser->parse("blogcat/delnested.tpl", $this->_data);
            header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
            return;
        }
    }



    function slim_upload_image() {

        $path_image = '';
        $year  = date('Y');
        $month = date('m');
        $day   = date('d');

        $file_path_year = $this->_path_upload.'/'.$year;
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year.'/'. $month;
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month.'/'. $day ;
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

        $new_path = $year.'/'.$month.'/'.$day.'/';
        $images     = $this->slim_library->getImages('path_image');
        $image      = $images[0];
        $new_img    = $image['output']['name'];

        if($new_img) {
            $data_img = $image['output']['data'];
            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name'];

            $old = $this->input->post('old');
            $old_img = $old['path_image'];
            $old_file_name = $this->slim_library->oldImageName($old_img);

            if($old_img != '' && $old_file_name != $filename) {
                unlink( $this->_path_upload.'/'.$old_img );
            }
        }

        return $path_image;
    }


}