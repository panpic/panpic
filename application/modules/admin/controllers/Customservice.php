<?php
/**
 * Controllers Backend
 * Last update 5 Oct 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 5 Oct 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customservice extends MY_Controller{


    private $_post_type;
    private $_blog_parent_category;

    public function __construct(){
        parent::__construct();

        $this->_post_type = POST_TYPE_CUSTOMSERVICE;
        $this->_blog_parent_category = PARENT_CAT_CUSTOMSERVICE;
            
        $this->_data['dir_path']  = $this->_path_upload;
        $this->_data['link_upload']  = $this->_link_upload;

        $this->load->model('blogs_model');
        $this->load->model('tourcat_model');
        $this->load->library('slim_library');
        $this->load->library('admin_permission');

        $this->_data['ADMIN_BLOG_VERIFY'] = ADMIN_BLOG_VERIFY;
        $this->_data['BLOG_TAB_VIEWALL'] = BLOG_TAB_VIEWALL;
        $this->_data['BLOG_TAB_ACTIVE'] = BLOG_TAB_ACTIVE;
        $this->_data['BLOG_TAB_INACTIVE'] = BLOG_TAB_INACTIVE;

        $this->_data['ACTIVE_DUPLICATE'] = ACTIVE_DUPLICATE;

        $session_admin = $this->_data['user_data'];
        $adminPermission= $session_admin->adminPermission;

        // echo $adminPermission;
        // echo $this->_control;
        // die;

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

        $this->_data['breadcrumb'] = $this->lable['customer_service'];
        $this->_data['alert'] = '';

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        $data = array();

        if (!empty($id) && $option == 'edit') {
            $this->blogs_model->id = $id;
            $data = $this->blogs_model->getItemById(" AND c.image_type = '$this->_post_type' ");
            $data['slug'] = $data['slug'];
            $sub = 'sub';
            $cId = $data['category'];
        } else {
            $data['date_add'] = date('Y-m-d H:i');
            $data['admin_verify'] = ADMIN_BLOG_VERIFY;
        }
        
        $this->load->library('nestedtourcat_library');
        $categories = $this->tourcat_model->getNodeByParentId( $this->_blog_parent_category );
        $arrNested = $this->nestedtourcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        $this->_data['data'] = $data;
        $this->_data['valid'] = '';

        $this->parser->parse("customservice/index.tpl", $this->_data);
    }

        
    /**
     * Process form add
     */
    function add() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $_data = $this->input->post('data');
        $id = $this->input->post('primary');

        $option = $this->input->post('option');
        $option = ($option == '') ? OPTION_ADD : $option;
        $this->_data['task'] = $this->lable[$option];
        $this->_data['option'] = $option;
        $this->_data['breadcrumb'] = $this->lable['customer_service'];

        if($option == OPTION_EDIT){
            $sub = 'sub';
            $cId = $_data['category'];
        }

        $this->load->library('nestedtourcat_library');
        $categories = $this->tourcat_model->getNodeByParentId( $this->_blog_parent_category );
        $arrNested = $this->nestedtourcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        $params = array(
            'category'          => $_data['category'],
            'title'             => addslashes($_data['title']),
            'short'             => addslashes($_data['short']),
            'content'           => addslashes($_data['content']),
            'date_add'          => $_data['date_add'],
            'seo_title'         => trim(strip_tags($_data['seo_title'])),
            'seo_description'   => trim(strip_tags($_data['seo_description'])),
            'admin_verify'      => ADMIN_BLOG_VERIFY,
            'post_type'         => POST_TYPE_CUSTOMSERVICE,
            'avail'             => ADMIN_BLOG_VERIFY
        );

        $params_slug['slug'] = url_convert($_data['slug']);
        
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
        
        if($this->form_validation->run() == FALSE) {

            if ($option == 'edit') {
                $msg = $this->lable['edit_fail'];
            } else {
                $msg = $this->lable['add_fail'];
            }

            $errors = $this->form_validation->error_array();

            $valid = array(
                'title' => $errors['data[title]'],
                'category' => $errors['data[category]']
            ); 

            $this->_data['valid'] = $valid;
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $msg;
            $this->_data['data'] = $params;

            $this->parser->parse("customservice/index.tpl", $this->_data);
            return;
        }

        if (!empty($id) && $option == OPTION_EDIT) { //Update

            $slug = $this->blogs_model->get_slug_exist($params_slug['slug'], $id);
            $params_slug['slug'] = $slug;
                
            $this->blogs_model->id = $id;
            $update = $this->blogs_model->updateItem($params, $params_slug);

            if ($update) {
                $this->do_slim_upload($id);
                $back_url = admin_url("customservice/items/");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['edit_succ'];
                $this->parser->parse("customservice/index.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['edit_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("customservice/index.tpl", $this->_data);
                return;
            }

        } else { //insert

            $slug = $this->blogs_model->get_slug_exist($params_slug['slug']);
            $params_slug['slug'] = $slug;
            $insert = $this->blogs_model->insertItem($params, $params_slug);

            if ($insert) {
                $this->do_slim_upload($insert);
                $back_url = admin_url("customservice");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['add_succ'];
                $this->parser->parse("customservice/index.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['add_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("customservice/index.tpl", $this->_data);
                return;
            }
        }
    }


    function duplicate() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $id = $this->input->get('id');
        if (!$id) {
            redirect(admin_url('blogs/items/'));
        }

        $this->blogs_model->id = $id;
        $_data = $this->blogs_model->getItemById(" AND c.image_type = '$this->_post_type' ");

        $slug = $this->blogs_model->get_slug_exist($_data['slug']);

        $params_slug['slug'] = $slug;

        $params = array(
            'category'            => $_data['category'],
            'title'               => $_data['title'],
            'short'               => $_data['short'],
            'content'             => $_data['content'],
            'date_add'            => date('Y-m-d H:i:s'),
            'seo_title'           => $_data['seo_title'],
            'seo_description'     => $_data['seo_description'],
            'post_type'           => $this->_post_type,
            'avail'               => ACTIVE_DUPLICATE,
            'admin_verify'        => ADMIN_BLOG_VERIFY,
        );

        $back_url = admin_url("customservice/items/");

        $insert = $this->blogs_model->insertItem($params, $params_slug);

        if ($insert) {

            $image_blog = $this->blogs_model->getImageByBlogId($id, " AND image_type = '".$this->_post_type."' ");
            $path_image_blog = $image_blog['path_image'];
            $this->copy_image_new_path($path_image_blog, $insert);

            $this->copy_image_new_path($insert);
            $this->_data['alert'] = 'success';
            $this->_data['msg'] = $this->lable['duplicate_success'];
            $this->parser->parse("blogs/index.tpl", $this->_data);
            header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
            return;
        } else {
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $this->lable['duplicate_fail'];
            $this->parser->parse("blogs/index.tpl", $this->_data);
            header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
            return;
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
		$tab = $this->input->get('t');
        $tab = ($tab == '') ? 1 : $tab;
        $this->_data['tab'] = $tab;

        $cond = '';
        $more_url = "&t=$tab";
        $keyword = trim(strip_tags($keyword));
        if($keyword){
            $cond .= " AND (c.title LIKE '%{$keyword}%' OR c.content LIKE '%{$keyword}%') ";
            $more_url .= "q=$keyword";
            $this->_data['search'] = $keyword;
        }
        
        if($category) {
            $cond .= " AND c.category = $category ";
            $more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";
            $this->_data['cat'] = $category;
        }

        // $this->_data['more_url'] = $more_url;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['customer_service'];
        
        if($tab == BLOG_TAB_UNVERIFY) {
            $cond .= " AND c.admin_verify = 0 ";
        }

        if($tab == BLOG_TAB_VERIFY) {
            $cond .= " AND c.admin_verify = 1 ";
        }
        if($tab == BLOG_TAB_ACTIVE) {
            $cond .= " AND c.avail = 1 ";
        }
        if($tab == BLOG_TAB_INACTIVE) {
            $cond .= " AND c.avail = 0 ";
        }

        $cond_items = " AND i.image_type = '$this->_post_type' WHERE c.post_type = '$this->_post_type' $cond GROUP BY c.id ";
        $cond_total = " WHERE c.post_type = '$this->_post_type' $cond ";

        $totalItems  = $this->blogs_model->countItems($cond_total);
        $per_page    = $this->lable['per_item_admin']; 
        $base_url    = admin_url('customservice/items/');
        $uri_segment = 4;
        $this->load->library('pagination_library'); 
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();
        
        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;      
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $this->_data['items'] = $this->blogs_model->getItems($cond_items, $per_page, $start);
        
        $this->parser->parse("customservice/items.tpl", $this->_data);
    }
	
    
    /**
     * Delete to Recycle bin
     * @return void
     */
    function deletemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        $checkAll = $this->input->post('checkAll');
        
        foreach ($checkAll as $id) {
            $this->blogs_model->id = $id;
            $data = $this->blogs_model->getItemById();
            $this->blogs_model->updateByFields( array('avail' => 0) );
        }
        
        $back_url = admin_url("customservice/items/");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse("customservice/items.tpl", $this->_data);
        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
        return; 
    }


    function removemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $checkAll = $this->input->post('checkAll');
        $event_type = POST_TYPE_CUSTOMSERVICE;

        foreach ($checkAll as $id) {
            $this->blogs_model->id = $id;
            $data = $this->blogs_model->getItemById(" AND c.image_type = '$event_type' ");
            @unlink($this->_path_upload.'/'.$data['path_image']);
            @unlink($this->_path_upload.'/'.$data['path_image_thumb']);
            $this->blogs_model->deleteItem( array('id'=>$id) );
        }

        $back_url = admin_url("customservice/items/");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse("customservice/items.tpl", $this->_data);
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
            $this->blogs_model->id = $blog_id;
            echo $this->blogs_model->updateByFields(array('avail'=>$avail));
            return;
        }
        
        echo 0;
        return;
    }
    
    
    /**
     * Ajx update display home
     * 
     * @param int $id
     * @param int $d
     * @return bool
     */
    function updateVerify() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $blog_id = $this->input->post_get('id');
        $display_home = $this->input->post_get('d');
        $display_home = ($display_home == 1) ? 1 : 0;
        
        if($blog_id != '') {
            echo $this->blogs_model->id = $blog_id;
            echo $this->blogs_model->updateByFields( array('admin_verify' => $display_home) );
            return;
        }
        
        echo 0;
        return;
    }


    /**
     * Slip upload
     *
     * @param object path_image
     * @param array old
     * @param $blog_id
     */
    function do_slim_upload($blog_id) {
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

        if($new_img){
            $data_img   = $image['output']['data'];
            $flag_change_img = 0;

            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name']; //$file['path']

            $path_image_thumb = $this->do_resize_thumb($path_image);
            $params = array(
                'object_id'     => $blog_id,
                'image_type'    => POST_TYPE_CUSTOMSERVICE,
                'path_image'    => $path_image
            );

            if($path_image_thumb != '') {
                $params['path_image_thumb'] = $new_path.$path_image_thumb;
            } else {
                $params['path_image_thumb'] = '';
            }

            $old = $this->input->post('old');
            $old_img = $old['path_image'];
            $old_file_name = $this->slim_library->oldImageName($old_img);

            if($old_img != '' && $old_file_name != $filename) {
                unlink( $this->_path_upload.'/'.$old_img );
                $imageOldExist = $this->blogs_model->getImageByBlogId($blog_id, $cond=" AND image_type = '".$this->_post_type."' ");
                if($imageOldExist != '') {
                    unlink( $this->_path_upload.'/'.$imageOldExist['path_image_thumb'] );
                    $image_id = $old['image_id'];
					$params['path_image_thumb'] = ($params['path_image_thumb'] == '') ? '' : $params['path_image_thumb'];
                    $this->blogs_model->updateImage($params, $image_id);
                } else {
                    $this->blogs_model->insertImage($params);
                }
                $flag_change_img = 1;
            } else { // insert
                $this->blogs_model->insertImage($params);
            }
        }
    }


    /**
     * Resize image thumb
     * small size format
     *
     * @param $file_image
     * @return string
     */
    function do_resize_thumb($file_image) {
        if ($file_image == '') return;

        $path_image = $this->_path_upload.$file_image;
        $file_size = getimagesize($path_image);
        $width = $file_size[0];
        $height = $file_size[1];
        $no_resize = 0;

        if ($width > $height && $width > BLOG_IMG_RESIZE_THUMB) {
            $width = BLOG_IMG_RESIZE_THUMB;
            $resize_height = ($width * BLOG_IMG_RESIZE_THUMB) / $width;
        } elseif ($height > $width && $height > BLOG_IMG_RESIZE_THUMB) {
            $width = ($height * BLOG_IMG_RESIZE_THUMB) / $height;
            $resize_height = BLOG_IMG_RESIZE_THUMB;
        } else { // not resize
            $no_resize = 1;
        }

        if ($no_resize == 0) { // Resize image
            $configs = array(
                'source_image'  => $path_image,
                'new_image'     => $path_image,
                'width'         => $width,
                'height'        => $resize_height,
                'maintain_ratio'=> TRUE,
                'quality'       => 100,
                'upload_path'   => $path_image,
                'image_library' => 'gd2',
                'create_thumb'  => TRUE,
                'maintain_ratio'=> TRUE
            );

            $this->load->library('image_lib');
            $this->image_lib->initialize($configs);
            $this->image_lib->resize();

            $file_info = pathinfo($configs['new_image']);
            return $image_thumb = $file_info['filename'] .THUMB_NAME.'.'.$file_info['extension'];
        }
    }


    /**
     * Copy image
     *
     * @param string path $old_image
     * @param int primary $blog_id
     * @return bool|string
     */
    function copy_image_new_path($old_image, $blog_id) {
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
        $file_path = $this->_path_upload.'/'.$old_image;
        // $dest_path = $this->_path_upload.'/'.$new_path;

        $pathinfo = pathinfo($file_path);
        $pic = $pathinfo['basename'];

        $pic_new = date('ymd-his').'-'.$pic;
        $dest_path = $this->_path_upload.'/'.$new_path.$pic_new;

        if($pic) {

            @copy($file_path, $dest_path);
            $path_image = $new_path.$pic_new;
            $params = array(
                'object_id'     => $blog_id,
                'image_type'    => $this->_post_type,
                'path_image'    => $path_image,
            );

            $this->blogs_model->insertImage($params);
        }
    }


}