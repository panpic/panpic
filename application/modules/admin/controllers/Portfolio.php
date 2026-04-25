<?php
/**
 * Controllers Backend
 * Last update 26 Jul 2021
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 12 Dec 2020
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portfolio extends MY_Controller{


    private $_post_type;
    private $_blog_parent_category;
    private $_cat_portoflio_pos;
    private $_cat_portfolio_services;
    public $path_upload;

    public function __construct(){
        parent::__construct();

        $this->_post_type = POST_TYPE_PORTFOLIO;
        $this->_blog_parent_category = PARENT_CAT_PORTFOLIO;
        $this->_cat_portoflio_pos = PARENT_CAT_PORTFOLIO_POS;
        $this->_cat_portfolio_services = PARENT_CAT_PORTFOLIO_SERVICES;

        $this->load->model('services_model');
        $this->load->model('postcat_model');
        $this->load->library('slim_library');
        $this->load->library('admin_permission');
        $this->load->model('blog_process_translate');
        $this->load->model('blogs_model');
        $this->load->model('gallery_model');

        $this->load->library('webp_lib');
        $this->path_upload = $this->_path_upload;

        $this->services_model->current_lang = $this->current_lang;
        $this->services_model->page_lang = $this->page_lang;
        $this->services_model->default_lang = $this->default_lang;

        $this->_data['ADMIN_BLOG_VERIFY'] = ADMIN_BLOG_VERIFY;
        $this->_data['BLOG_TAB_VIEWALL'] = BLOG_TAB_VIEWALL;
        $this->_data['BLOG_TAB_UNVERIFY'] = BLOG_TAB_UNVERIFY;
        $this->_data['BLOG_TAB_VERIFY'] = BLOG_TAB_VERIFY;
        $this->_data['BLOG_TAB_ACTIVE'] = BLOG_TAB_ACTIVE;
        $this->_data['BLOG_TAB_INACTIVE'] = BLOG_TAB_INACTIVE;
        $this->_data['ACTIVE_DUPLICATE'] = ACTIVE_DUPLICATE;
        $this->_data['SHOW_HOME'] = SHOW_HOME;

        $this->_data['POST_TYPE_SERVICES_GALLERY'] = POST_TYPE_SERVICES_GALLERY;
        $this->_data['OPTION_EDIT'] = OPTION_EDIT;

        $this->load->library('nestedpostcat_library');

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
     */
    function index(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->_data['breadcrumb'] = $this->lable['admin_portfolio'];
        $this->_data['alert'] = '';

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        $items = array();
        $data = array();

        if (!empty($id) && $option == 'edit') {
            $this->services_model->id = $id;
            $cond_image=" AND c.image_type = '$this->_post_type' ";
            $data = $this->services_model->getItemsMultiLangById($cond_image); // getItemById($cond_image);
            $first = $data[0];
            $items = $this->data_library->edit_parse($data);
            // pre($items);

            $sub = 'sub';
            $cId = $first['category_id'];

            /*
            $portfolio_category_id = $first['portfolio_category_id'];
            $portfolio_services_id = $first['portfolio_services_id'];
            $data['slug'] = $data['slug'];
            $portfolio_json = (array)json_decode($data['portfolio_json']);
            */

        } else {
            $data['date_add'] = date('Y-m-d H:i');
            $data['admin_verify'] = ADMIN_BLOG_VERIFY;
        }

        $this->postcat_model->_lang = $this->current_lang;

        $categories = $this->postcat_model->getNodeByParentId($this->_blog_parent_category);
        $arrNested = $this->nestedpostcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        /*
        $categorie_pos = $this->postcat_model->getNodeByParentId($this->_cat_portoflio_pos);
        $posNested = $this->nestedpostcat_library->cmbNested($categorie_pos, $sub, $portfolio_category_id, 1);
        $this->_data['category_pos'] = $posNested;
        */

        // $this->_data['portfolio_json'] = $portfolio_json;
        $this->_data['data'] = $first;
        $this->_data['items'] = $items;
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
        $this->_data['breadcrumb'] = $this->lable['admin_portfolio'];

        $sub = '';
        $cId = '';
        // $portfolio_category_id = '';
        $portfolio_services_id = '';

        if($option == OPTION_EDIT){
            $sub = 'sub';
            $cId = $_data['category_id'];
            // $portfolio_category_id = $_data['portfolio_category_id'];
            // $portfolio_services_id = $_data['portfolio_services_id'];
        }

        $categories = $this->postcat_model->getNodeByParentId( $this->_blog_parent_category );
        $arrNested = $this->nestedpostcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        /*
        $categorie_pos = $this->postcat_model->getNodeByParentId($this->_cat_portoflio_pos);
        $posNested = $this->nestedpostcat_library->cmbNested($categorie_pos, $sub, $portfolio_category_id, 1);
        $this->_data['category_pos'] = $posNested;
        */

        $params = array(
            'category_id'   => $_data['category_id'],
            /*'portfolio_status' => $_data['portfolio_status'],*/
            'portfolio_year'=> date('Y-m-d', strtotime($_data['portfolio_year'])),
            'post_type'     => $this->_post_type,
            'date_add'      => ($_data['date_add'] == '') ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($_data['date_add'])),
            'avail'         => ACTIVE,
            'admin_verify'  => ADMIN_BLOG_VERIFY,
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

        /*
        $this->form_validation->set_rules('data[category_id]', $this->lable['category'], 'required', array(
                'required' => $this->lable['require_field_string']
            ));
        */

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

        if (!empty($id) && $option == OPTION_EDIT) { // Update

            $this->services_model->id = $id;
            $update = $this->services_model->updateItem($_data, $params);

            if ($update) {
                $this->do_slim_upload($id);
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['edit_succ']);

                clear_homepage_cache();

                redirect( admin_url($this->_control."/items/") );
            } else {
                $this->session->set_flashdata('alert', 'danger');
                $this->session->set_flashdata('msg', $this->lable['edit_fail']);
                redirect( admin_url($this->_control."/?id=$id&option=edit") );
            }
        } else {

            $insert = $this->services_model->insertItem($params, $_data);

            if ($insert) {
                $this->do_slim_upload($insert);
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['add_succ']);
                clear_homepage_cache();
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

        $this->services_model->id = $id;

        $cond_img = " AND c.image_type = '$this->_post_type' ";

        $cond_vi = " AND a.blog_id = $id  AND b.lang = '".LANG_VI."' ";
        $_data_vi = $this->services_model->getItemByCond($cond_vi, $cond_img);
        $slug_vi = $this->services_model->get_slug_exist($_data_vi['slug']."-".DUPLICATED);

        $cond_en = " AND a.blog_id = $id  AND b.lang = '".LANG_EN."' ";
        $_data_en = $this->services_model->getItemByCond($cond_en, $cond_img);
        $slug_en = $this->services_model->get_slug_exist($_data_en['slug']."-".DUPLICATED);

        $cond_zh = " AND a.blog_id = $id  AND b.lang = '".LANG_ZH."' ";
        $_data_zh = $this->services_model->getItemByCond($cond_zh, $cond_img);
        $slug_zh = $this->services_model->get_slug_exist($_data_zh['slug']."-".DUPLICATED);
        // pre($_data_zh);

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
            'portfolio_utility' => $_data_vi['portfolio_utility'],
            'short'         => $_data_vi['short'],
            'content'       => $_data_vi['content'],
            'seo_title'     => $_data_vi['seo_title'],
            'seo_description'=> $_data_vi['seo_description'],
        );

        $params_en = array(
            'lang'          => $_data_en['lang'],
            'slug'          => $slug_en,
            'title'         => $_data_en['title'],
            'portfolio_utility'     => $_data_en['portfolio_utility'],
            'short'         => $_data_en['short'],
            'content'       => $_data_en['content'],
            'seo_title'     => $_data_en['seo_title'],
            'seo_description'=> $_data_en['seo_description'],
        );


        $back_url = admin_url($this->_control."/items");
        $insert = $this->services_model->duplicateItem($params, $params_vi, '', '');

        if ($insert) {
            $image_blog = $this->services_model->getImageByBlogId($id, " AND image_type = '$this->_post_type' ");
            $path_image_blog = $image_blog['path_image'];
            $this->copy_image_new_path($path_image_blog, $insert);

            $this->session->set_flashdata('alert', 'success');
            $this->session->set_flashdata('msg', $this->lable['duplicate_success']);
            redirect($back_url);

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
        $tab = ($tab == '') ? BLOG_TAB_ACTIVE : $tab;
        $this->_data['tab'] = $tab;

        $search = array();
        $cond = '';
        $more_url = "&t=$tab";
        $keyword = trim(strip_tags($keyword));
        if($keyword){
            $cond .= " AND (b.title LIKE '%$keyword%' OR b.content LIKE '%$keyword%') ";
            $more_url .= "q=$keyword";
            $search['q'] = $keyword;
        }

        if($category) {
            $cond .= " AND a.category_id = $category ";
            $more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";
            $search['category_id'] = $category;
        }

        $this->_data['search'] = $search;

        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['admin_portfolio'];

        if($tab == BLOG_TAB_UNVERIFY) {
            $cond .= " AND a.admin_verify = 0 ";
        }

        if($tab == BLOG_TAB_VERIFY) {
            $cond .= " AND a.admin_verify = 1 ";
        }
        if($tab == BLOG_TAB_ACTIVE) {
            $cond .= " AND a.avail > 0 ";
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

        $totalItems  = $this->services_model->countItems($cond_total);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url($this->_control.'/items');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $items = $this->services_model->getItems($cond_items, $per_page, $start);
        $this->_data['items'] = $items;

        $categories = $this->postcat_model->getNodeByParentId( $this->_blog_parent_category );
        // pre($categories);
        $this->_data['categories'] = $categories;

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
            $this->services_model->id = $id;
            // $data = $this->services_model->getItemById();
            $this->services_model->updateBlogByFields( array('avail' => 0) );
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
        $post_type = POST_TYPE_SERVICES_GALLERY;

        foreach ($checkAll as $id) {
            $this->services_model->id = $id;
            $data = $this->services_model->getItemById(" AND c.image_type = '$this->_post_type' ");

            @unlink($this->_path_upload.$data['path_image']);
            @unlink($this->_path_upload.$data['path_image_thumb']);
            $this->services_model->deleteItem( array('blog_id'=>$id) );

            // Remove image gallery
            $cond = " AND a.post_type = '$post_type' ";
            $this->gallery_model->_post_type_album_detail = $post_type;
            $gallery = $this->gallery_model->albumGalleryDetail($id, $cond);

            if($gallery) {
                foreach ($gallery as $vl){
                    $gallery_id = $vl['id'];
                    $this->gallery_model->id = $gallery_id;
                    $this->gallery_model->_post_type_album_detai = $post_type;
                    $this->gallery_model->deleteItem();
                    @unlink($this->_path_upload.$vl['path_image']);
                    @unlink($this->_path_upload.$vl['path_image_thumb']);
                }
            }
        }

        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('msg', $this->lable['delete_succ']);
        redirect( admin_url($this->_control."/items/?t=5") );
        $this->parser->parse($this->_control."/items.tpl", $this->_data);
    }

    /**
     * Restore Item
     */
    function restore() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $blog_id = $this->input->get('id');

        if($blog_id && $blog_id > 0){
            $this->services_model->id = $blog_id;
            $this->services_model->updateBlogByFields(array('avail' => 1));
        }

        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('msg', $this->lable['restore_success']);
        redirect( admin_url($this->_control."/items/?t=5") );

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
            $this->services_model->id = $blog_id;
            echo $this->services_model->updateBlogByFields(array('avail'=>$avail));
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
            $this->services_model->id = $blog_id;
            echo $this->services_model->updateBlogByFields( array('admin_verify' => $display_home) );
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
            $this->services_model->id = $blog_id;
            $this->services_model->current_lang = $lang;
            echo $this->services_model->updateBlogTranslateByFields( array('home_status' => $display_home) );
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

            $data_img = $image['output']['data'];
            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name']; //$file['path']

            // Thumbnail jpg
            $path_thumb = $this->do_resize_thumb($path_image, $new_path);

            $webp = $this->webp_lib->convert($this->path_upload.$path_image);
            if($webp->status == ACTIVE){
                unlink($this->path_upload.$path_image);
                $path_image = $new_path.$webp->file;
            }

            $params = array(
                'object_id'     => $blog_id,
                'image_type'    => $this->_post_type,
                'path_image'    => $path_image,
                'path_image_thumb' => $path_image
            );

            if($path_thumb != '') {
                $image_thumb = $new_path.$path_thumb;
                $webp_thumb = $this->webp_lib->convert($this->path_upload.$image_thumb);

                if($webp_thumb->status == ACTIVE){
                    unlink($this->path_upload.$image_thumb);
                    $path_image_thumb = $new_path.$webp_thumb->file;
                }

                if($path_image_thumb) {
                    $params['path_image_thumb'] = $path_image_thumb;
                }
            }

            $old = $this->input->post('old');
            $old_img = $old['path_image'];
            $old_img_thumb = $old['path_image_thumb'];
            $old_file_name = $this->slim_library->oldImageName($old_img);

            if($old_img != '' && $old_file_name != $filename) {
                unlink( $this->_path_upload.'/'.$old_img );
                unlink( $this->_path_upload.'/'.$old_img_thumb );

                $imageOldExist = $this->services_model->getImageByBlogId($blog_id, $cond=" AND image_type = '".$this->_post_type."' ");
                if($imageOldExist != '') {
                    // unlink( $this->_path_upload.'/'.$imageOldExist['path_image_thumb'] );
                    $image_id = $old['image_id'];
					$params['path_image_thumb'] = ($params['path_image_thumb'] == '') ? '' : $params['path_image_thumb'];
                    $this->services_model->updateImage($params, $image_id);
                } else {
                    $this->services_model->insertImage($params);
                }

            } else { // insert
                $this->services_model->insertImage($params);
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

        $resize_w = 297;
        // $resize_h = 223;

        if ($width > $height && $width > $resize_w) {
            $width = $resize_w;
            $resize_height = ($width * $resize_w) / $width;
        } elseif ($height > $width && $height > $resize_w) {
            $width = ($height * $resize_w) / $height;
            $resize_height = $resize_w;
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
            return $image_thumb = $file_info['filename'].THUMB_NAME.'.'.$file_info['extension'];
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
            $this->services_model->insertImage($params);
        }
    }

    /**
     * Slip upload
     *
     * @param object path_image
     * @param array old
     */
    function do_slim_upload_services_process() {

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

            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name']; //$file['path']

            $path_image_thumb = $this->do_resize_thumb($path_image);
            $params = array('path_image' => $path_image);

            if($path_image_thumb != '') {
                $params['path_image_thumb'] = $new_path.$path_image_thumb;
            }

            $old = $this->input->post('old');
            $old_img = $old['path_image'];
            $old_img_thumb = $old['path_image_thumb'];
            $old_file_name = $this->slim_library->oldImageName($old_img);

            if($old_img != '' && $old_file_name != $filename) {
                unlink($this->_path_upload.'/'.$old_img);
                unlink($this->_path_upload.'/'.$old_img_thumb);
            }

            return $params;
        }
    }

    /**
     * Album detail, images gallery and Add more
     * @param int $album_id (blog_id)
     */
    function gallery() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_type = POST_TYPE_SERVICES_GALLERY;
        $album_id = $this->input->get('album');
        $primary = $this->input->get('id');
        $option = $this->input->get('option');

        if($album_id == '') {
            redirect( admin_url($this->_control.'/items') );
        }

        $this->blogs_model->id = $album_id;
        $cond_image=" AND c.image_type = '$post_type' ";
        $album = $this->blogs_model->getItemById($cond_image);

        $cond = " AND a.post_type = '$post_type' ";
        $this->gallery_model->_post_type_album_detail = $post_type;
        $gallery = $this->gallery_model->albumGalleryDetail($album_id, $cond);

        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        if($primary != '' && $option == OPTION_EDIT) {
            $data = $this->gallery_model->albumGalleryDetailById($primary);
            $this->_data['data'] = $data;
        } else {
            $_data['date_add'] = date('Y-m-d H:i:s');
            $this->_data['data'] = $_data;
        }

        $this->_data['gallery'] = $gallery;
        $this->_data['breadcrumb'] = $album['title'];
        $this->_data['alert'] = '';
        $this->_data['album'] = $album;

        if ($this->input->post()) {
            $option = $this->input->post('option');
            $primary = $this->input->post('primary');
            $_data = $this->input->post('data');

            if (!empty($primary) && $option == OPTION_EDIT) { // Update

                $params = $this->gallery_model->builParamsInsert($_data);
                $params['album_id']  = $album_id;
                $params['post_type'] = $post_type;

                $this->gallery_model->id = $primary;
                $update = $this->gallery_model->updateItem($params);

                if ($update) {
                    $this->do_slim_upload_gallery($primary);
                    $this->session->set_flashdata('alert', 'success');
                    $this->session->set_flashdata('msg', $this->lable['edit_succ']);
                    redirect( admin_url($this->_control."/gallery?album=$album_id") );
                } else {
                    $this->session->set_flashdata('alert', 'danger');
                    $this->session->set_flashdata('msg', $this->lable['edit_fail']);
                    redirect( admin_url($this->_control."/gallery?album=$album_id&id=$primary&option=$option") );
                }

            } else {

                $_data['date_add'] = date('Y-m-d H:i:s');
                $_data['album_id']  = $album_id;
                $params = $this->gallery_model->builParamsInsert($_data);
                $params['post_type'] = $post_type;
                $insert = $this->gallery_model->insertItem($params);

                if ($insert) {
                    $this->do_slim_upload_gallery($insert);
                    $this->session->set_flashdata('alert', 'success');
                    $this->session->set_flashdata('msg', $this->lable['add_succ']);
                    redirect( admin_url($this->_control."/gallery?album=$album_id") );
                } else {
                    $this->_data['alert'] = 'danger';
                    $this->_data['msg'] = $this->lable['add_fail'];
                    $this->_data['data'] = $_data;
                    $this->parser->parse($this->_control."/gallery.tpl", $this->_data);
                    return;
                }
            }
        }

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->parser->parse($this->_control."/gallery.tpl", $this->_data);
    }

    /**
     * Remove image gallery detail
     *
     * @param int $id
     */
    function gallery_delete() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $post_type = POST_TYPE_SERVICES_GALLERY;
        $id = $this->input->get('id');
        $album_id = $this->input->get('a');

        if($id == '') {
            redirect( admin_url($this->_control."/gallery?album=$album_id") );
        }

        $cond = " AND a.post_type = '$post_type' ";
        $this->gallery_model->_post_type_album_detail = $post_type;
        $data = $this->gallery_model->albumGalleryDetailById($id);

        $this->gallery_model->id = $id;
        $this->gallery_model->_post_type_album_detail = $post_type;
        $status = $this->gallery_model->deleteItem();
        if($status) {
            @unlink($this->_path_upload.$data['path_image']);
            @unlink($this->_path_upload.$data['path_image_thumb']);

            $this->session->set_flashdata('alert', 'success');
            $this->session->set_flashdata('msg', $this->lable['delete_succ']);
        } else {
            $this->session->set_flashdata('alert', 'danger');
            $this->session->set_flashdata('msg', $this->lable['delete_fail']);
        }

        redirect( admin_url($this->_control."/gallery?album=$album_id") );
    }

    /**
     * Upload gallery images detail
     * @param $blog_id
     */
    function do_slim_upload_gallery($blog_id) {
        $post_type = POST_TYPE_SERVICES_GALLERY;
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
            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name']; //$file['path']

            $path_image_thumb = $this->do_resize_thumb($path_image);
            $params = array(
                'object_id'     => $blog_id,
                'image_type'    => $post_type,
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
                $imageOldExist = $this->blogs_model->getImageByBlogId($blog_id, $cond=" AND image_type = '$post_type' ");
                if($imageOldExist != '') {
                    unlink( $this->_path_upload.'/'.$imageOldExist['path_image_thumb'] );
                    $image_id = $old['image_id'];
					$params['path_image_thumb'] = ($params['path_image_thumb'] == '') ? '' : $params['path_image_thumb'];
                    $this->blogs_model->updateImage($params, $image_id);
                } else {
                    $this->blogs_model->insertImage($params);
                }
            } else { // insert
                $this->blogs_model->insertImage($params);
            }
        }
    }

}
