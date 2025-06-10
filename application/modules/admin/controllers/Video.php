<?php
/**
 * Controllers Backend
 * Last update 6 Aug 2019
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 6 Aug 2019
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends MY_Controller{

    private $_post_type;
    private $_blog_parent_category;

    public function __construct(){
        parent::__construct();

        $this->_post_type = POST_TYPE_VIDEO;
        $this->_blog_parent_category = PARENT_CAT_VIDEO;

        $this->_data['dir_path']  = $this->_path_upload;
        $this->_data['link_upload']  = $this->_link_upload;
        $this->_data['category_id'] = $this->_blog_parent_category;

        $this->load->model('blogs_model');
        $this->load->model('postcat_model');
        $this->load->library('slim_library');
        $this->load->library('admin_permission');

        $this->blogs_model->current_lang = $this->current_lang;
        $this->blogs_model->page_lang = $this->page_lang;
        $this->blogs_model->default_lang = $this->default_lang;

        $this->_data['ADMIN_BLOG_VERIFY'] = ADMIN_BLOG_VERIFY;
        $this->_data['BLOG_TAB_VIEWALL'] = BLOG_TAB_VIEWALL;
        $this->_data['BLOG_TAB_UNVERIFY'] = BLOG_TAB_UNVERIFY;
        $this->_data['BLOG_TAB_VERIFY'] = BLOG_TAB_VERIFY;
        $this->_data['BLOG_TAB_ACTIVE'] = BLOG_TAB_ACTIVE;
        $this->_data['BLOG_TAB_INACTIVE'] = BLOG_TAB_INACTIVE;
        $this->_data['ACTIVE_DUPLICATE'] = ACTIVE_DUPLICATE;

        $session_admin = $this->_data['user_data'];
        $adminPermission= $session_admin->adminPermission;
        $super_admin = $this->config->item("super_admin");
        if($session_admin->adminRole != $super_admin) {
            if($this->admin_permission->myPermission($this->_control, $adminPermission) == false) {
                redirect(admin_url('index/notpermission'));
            }
        }
    }


    /**
     * Form add / edit
     *
     */
    function index(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->_data['breadcrumb'] = $this->lable['video_library'];
        $this->_data['alert'] = '';

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        $data = array();

        if (!empty($id) && $option == 'edit') {
            $this->blogs_model->id = $id;
            $cond_image=" AND c.image_type = '$this->_post_type' ";
            $data = $this->blogs_model->getItemById($cond_image);
            $data['slug'] = $data['slug'];
            $sub = 'sub';
            $cId = $data['category_id'];
        } else {
            $data['date_add'] = date('Y-m-d H:i');
            $data['admin_verify'] = ADMIN_BLOG_VERIFY;
        }

        $this->load->library('nestedpostcat_library');
        $this->postcat_model->_lang = $this->current_lang;
        $categories = $this->postcat_model->getNodeByParentId( $this->_blog_parent_category );
        $arrNested = $this->nestedpostcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        $this->_data['data'] = $data;
        $this->_data['valid'] = '';

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        if (!empty($id) && $option == 'edit') {
            $this->parser->parse($this->_control."/edit.tpl", $this->_data);
        } else {
            $this->parser->parse($this->_control."/add.tpl", $this->_data);
        } 
    }


    /**
     * Process add / edit
     */
    function add() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $_data = $this->input->post('data');
        $id = $this->input->post('primary');

        $option = $this->input->post('option');
        $option = ($option == '') ? OPTION_ADD : $option;
        $this->_data['task'] = $this->lable[$option];
        $this->_data['option'] = $option;
        $this->_data['breadcrumb'] = $this->lable['video_library'];

        if($option == OPTION_EDIT){
            $sub = 'sub';
            $cId = $_data['category_id'];
        }

        $this->load->library('nestedpostcat_library');
        $categories = $this->postcat_model->getNodeByParentId( $this->_blog_parent_category );
        $arrNested = $this->nestedpostcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        $params = array(
            'category_id'   => $_data['category_id'],
            'post_type'     => $this->_post_type,
            'avail'         => ADMIN_BLOG_VERIFY,
            'admin_verify'  => $_data['admin_verify']
        );

        //@ Validation
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        if($id != '') {
            $this->form_validation->set_rules("data[$this->current_lang][title]", $this->lable['title'], 'required', array(
                'required' => $this->lable['require_field_string']
            ));
        } else {
            $this->form_validation->set_rules("data[$this->default_lang][title]", $this->lable['title'], 'required', array(
                'required' => $this->lable['require_field_string']
            ));
        }

        $this->form_validation->set_rules('data[category_id]', $this->lable['category'], 'required', array(
            'required' => $this->lable['require_field_string']
        ));

        if ($option == 'edit') {
            $msg = $this->lable['edit_fail'];
            $tpl = 'edit.tpl';
        } else {
            $msg = $this->lable['add_fail'];
            $tpl = 'add.tpl';
        }

        if($this->form_validation->run() == FALSE) {

            $errors = $this->form_validation->error_array();

            if($id != '') {
                $title_error = $errors["data[$this->current_lang][title]"];
            } else {
                $title_error = $errors["data[$this->default_lang][title]"];
            }
            $valid = array(
                'title' => $title_error,
                'category_id' => $errors['data[category_id]']
            );

            $this->_data['valid'] = $valid;
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $msg;
            $this->_data['data'] = $_data;

            $this->parser->parse($this->_control."/$tpl", $this->_data);
            return;
        }

        if (!empty($id) && $option == OPTION_EDIT) { //Update

            $params_translate = array(
                'title'       => addslashes($_data[$this->current_lang]['title']),
                'short'       => addslashes($_data[$this->current_lang]['short']),
                'content'     => addslashes($_data[$this->current_lang]['content']),
                'seo_title'   => trim(strip_tags($_data[$this->current_lang]['seo_title'])),
                'seo_description'=> trim(strip_tags($_data[$this->current_lang]['seo_description']))
            );

            $slug = url_convert($_data[$this->current_lang]['slug']);
            $slug = $this->blogs_model->get_slug_exist($slug, $id);
            $params_translate['slug'] = $slug;
            $params = array('date_add' => $_data['date_add']);

            $this->blogs_model->id = $id;
            $update = $this->blogs_model->updateItem($params_translate, $params);

            if ($update) {
                $this->do_slim_upload($id);
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['edit_succ']);
                redirect( admin_url($this->_control."/items/") );
            } else {
                $this->session->set_flashdata('alert', 'danger');
                $this->session->set_flashdata('msg', $this->lable['edit_fail']);
                redirect( admin_url($this->_control."/?id=$id&option=edit") );
            }
        } else { //insert

            $params['date_add'] = date('Y-m-d H:i:s');
            $insert = $this->blogs_model->insertItem($params, $_data);

            if ($insert) {
                $this->do_slim_upload($insert);
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['add_succ']);
                redirect( admin_url($this->_control) );
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['add_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse($this->_control."/$tpl", $this->_data);
                return;
            }
        }
    }


    /**
     * Duplicate item
     */
    function duplicate() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $id = $this->input->get('id');
        if (!$id) {
            redirect(admin_url($this->_control.'/items'));
        }

        $this->blogs_model->id = $id;

        $cond_img = " AND c.image_type = '$this->_post_type' ";

        $cond_vi = " AND a.blog_id = $id  AND b.lang = '".LANG_VI."' ";
        $_data_vi = $this->blogs_model->getItemByCond($cond_vi, $cond_img);
        $slug_vi = $this->blogs_model->get_slug_exist($_data_vi['slug']."-".DUPLICATED);

        $cond_en = " AND a.blog_id = $id  AND b.lang = '".LANG_EN."' ";
        $_data_en = $this->blogs_model->getItemByCond($cond_en, $cond_img);
        $slug_en = $this->blogs_model->get_slug_exist($_data_en['slug']."-".DUPLICATED);

        $params = array(
            'category_id'   => $_data_vi['category_id'],
            'post_type'     => $this->_post_type,
            'date_add'      => date('Y-m-d H:i:s'),
            'avail'         => DUPLICATED_AVAIL,
            'admin_verify'  => $_data_vi['admin_verify']
        );

        $params_vi = array(
            'lang'          => $_data_vi['lang'],
            'slug'          => $slug_vi,
            'title'         => $_data_vi['title'],
            'short'         => $_data_vi['short'],
            'content'       => $_data_vi['content'],
            'seo_title'     => $_data_vi['seo_title'],
            'seo_description'=> $_data_vi['seo_description'],
        );

        $params_en = ''; /* array(
            'lang'          => $_data_en['lang'],
            'slug'          => $slug_en,
            'title'         => $_data_en['title'],
            'short'         => $_data_en['short'],
            'content'       => $_data_en['content'],
            'seo_title'     => $_data_en['seo_title'],
            'seo_description'=> $_data_en['seo_description'],
        ); */

        $back_url = admin_url($this->_control."/items");
        $insert = $this->blogs_model->duplicateItem($params, $params_vi, $params_en);

        if ($insert) {
            $image_blog = $this->blogs_model->getImageByBlogId($id, " AND image_type = '$this->_post_type' ");
            $path_image_blog = $image_blog['path_image'];
            $this->copy_image_new_path($path_image_blog, $insert);
            $this->_data['alert'] = 'success';
            $this->_data['msg'] = $this->lable['duplicate_success'];
            $this->parser->parse($this->_control."/alert.tpl", $this->_data);
            header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
            return;
        } else {
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $this->lable['duplicate_fail'];
            $this->parser->parse($this->_control."/alert.tpl", $this->_data);
            header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
            return;
        }
    }


    /**
     * List items
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
            $cond .= " AND (b.title LIKE '%$keyword%' OR b.content LIKE '%$keyword%') ";
            $more_url .= "q=$keyword";
            $this->_data['search'] = $keyword;
        }

        if($category) {
            $cond .= " AND a.category = $category ";
            $more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";
            $this->_data['cat'] = $category;
        }

        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['video_library'];

        if($tab == BLOG_TAB_UNVERIFY) {
            $cond .= " AND a.admin_verify = 0 ";
        }

        if($tab == BLOG_TAB_VERIFY) {
            $cond .= " AND a.admin_verify = 1 ";
        }
        if($tab == BLOG_TAB_ACTIVE) {
            $cond .= " AND a.avail = 1 ";
        }

        if($tab == BLOG_TAB_INACTIVE) { // Recycle bin
            $cond .= " AND (a.avail = 0 || a.avail = 2) ";
        }

        /*
        if($tab == BLOG_TAB_MEMBER) {
            $cond .= " AND a.member_id > 0 ";
        }
        */

        $cond_items = " AND i.image_type = '$this->_post_type' WHERE a.post_type = '$this->_post_type' $cond ";
        $cond_total = " WHERE a.post_type = '$this->_post_type' $cond ";

        $totalItems  = $this->blogs_model->countItems($cond_total);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url($this->_control.'/items');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $items = $this->blogs_model->getItems($cond_items, $per_page, $start);
        $this->_data['items'] = $items;

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->parser->parse($this->_control."/items.tpl", $this->_data);
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
            // $data = $this->blogs_model->getItemById();
            $this->blogs_model->updateBlogByFields( array('avail' => 0) );
        }

        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('msg', $this->lable['delete_succ']);
        redirect( admin_url($this->_control."/items") );

        /*
        $back_url = admin_url($this->_control."/items");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse($this->_control."/items.tpl", $this->_data);
        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
        return;
        */
    }


    /**
     * Remove Item
     */
    function removemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $checkAll = $this->input->post('checkAll');

        foreach ($checkAll as $id) {
            $this->blogs_model->id = $id;
            $data = $this->blogs_model->getItemById(" AND c.image_type = '$this->_post_type' ");
            @unlink($this->_path_upload.$data['path_image']);
            @unlink($this->_path_upload.$data['path_image_thumb']);
            $this->blogs_model->deleteItem( array('blog_id'=>$id) );
        }

        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('msg', $this->lable['delete_succ']);
        redirect( admin_url($this->_control."/items/?t=5") );

        /*
        $back_url = admin_url($this->_control."/items");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse($this->_control."/items.tpl", $this->_data);
        header("refresh:".$this->lable['timewait'].";url=".$back_url."");
        return;
        */
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
            echo $this->blogs_model->updateBlogByFields(array('avail'=>$avail));
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
            $this->blogs_model->id = $blog_id;
            echo $this->blogs_model->updateBlogByFields( array('admin_verify' => $display_home) );
            return;
        }

        echo 0;
        return;
    }


    /**
     * Ajx update show home
     *
     * @param int $id
     * @param int $d
     * @return bool
     */
    function show_home() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $blog_id = $this->input->post_get('id');
        $display_home = $this->input->post_get('d');
        $lang = $this->input->post_get('l');

        $display_home = ($display_home == 1) ? 1 : 0;

        if($blog_id != '') {
            $this->blogs_model->id = $blog_id;
            $this->blogs_model->current_lang = $lang;
            echo $this->blogs_model->updateBlogTranslateByFields( array('home_status' => $display_home) );
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
                'image_type'    => $this->_post_type,
                'path_image'    => $path_image,
            );

            if($path_image_thumb != '') {
                $params['path_image_thumb'] = $new_path.$path_image_thumb;
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
        // $file_info = pathinfo($path_image);
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
        } else {
            // not resize
            $no_resize = 1;
        }

        if ($no_resize == 0) {
            // Resize image
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
                'maintain_ratio'=> TRUE,
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

        $pathinfo = pathinfo($file_path);
        $pic = $pathinfo['basename'];
        $pic_new = date('ymd-his').'-'.$pic;
        $dest_path = $this->_path_upload.'/'.$new_path.$pic_new;

        if($pic) {
            @copy($file_path, $dest_path);
            $path_image = $new_path.$pic_new;

            $params = array(
                'object_id' => $blog_id,
                'image_type'=> $this->_post_type,
                'path_image'=> $path_image,
            );
            $this->blogs_model->insertImage($params);
        }
    }


}