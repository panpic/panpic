<?php
/**
 * Controllers Backend Banner
 * Last update 23 Nov 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 16 Nov 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends MY_Controller{


    public $path_upload;

	public function __construct(){
		parent::__construct();

		$this->_data['dir_path']  = $this->_path_upload;
		$this->_data['link_upload']  = $this->_link_upload;

		$this->load->model('banner_model');
		$this->load->library('slim_library');
		$this->load->library('admin_permission');

        $this->load->library('webp_lib');
        $this->path_upload = $this->_path_upload;

		$this->banner_model->current_lang = $this->current_lang;
		$this->banner_model->page_lang = $this->page_lang;
		$this->banner_model->default_lang = $this->default_lang;

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

		$this->_data['breadcrumb'] = $this->lable['banner'];
		$this->_data['alert'] = '';

		$id = $this->input->get('id');
		$option= $this->input->get('option');
		$option = !empty($option) ? $option : OPTION_ADD;
		$this->_data['option'] = $option;
		$this->_data['task'] = $this->lable[$option];

		$data = array();

		if (!empty($id) && $option == 'edit') {
			$this->banner_model->id = $id;
			$cond = "";
			$data = $this->banner_model->getItemById($cond);
		} else {
			$data['date_add'] = date('Y-m-d H:i');
		}

		$categories = $this->banner_model->blogCategories(" WHERE avail = 1");
		$this->_data['categories'] = $categories;

		$this->_data['data'] = $data;
		$this->_data['valid'] = '';

		$this->_data['alert'] = $this->session->flashdata('alert');
		$this->_data['msg'] = $this->session->flashdata('msg');

		if (!empty($id) && $option == 'edit') {
			$this->parser->parse("banner/edit.tpl", $this->_data);
		} else {
			$this->parser->parse("banner/add.tpl", $this->_data);
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
		$this->_data['breadcrumb'] = $this->lable['banner'];

		$categories = $this->banner_model->blogCategories(" WHERE avail = 1");
		$this->_data['categories'] = $categories;

		$params = array(
			'category_id' 	=> $_data['category_id'],
			'banner_clip'   => $_data['banner_clip'],
			'banner_link'	=> $_data['banner_link'],
            'date_add'      => ($_data['date_add'] == '') ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($_data['date_add'])),
			'avail'         => ADMIN_BLOG_VERIFY
		);

		//@ Validation
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		/*
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
        */

		if ($option == 'edit') {
			$msg = $this->lable['edit_fail'];
			$tpl = 'edit.tpl';
		} else {
			$msg = $this->lable['add_fail'];
			$tpl = 'add.tpl';
		}

		/*
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

			$this->parser->parse("banner/$tpl", $this->_data);
			return;
		}
        */

		$params['banner_file'] = $this->do_slim_upload();

		if (!empty($id) && $option == OPTION_EDIT) { // Update

			$params_translate = array(
				'title'	=> addslashes($_data[$this->current_lang]['title']),
				'short' => addslashes($_data[$this->current_lang]['short']),
                'content' => addslashes($_data[$this->current_lang]['content']),
				'link_click' => $_data[$this->current_lang]['link_click']
			);


			$this->banner_model->id = $id;
			$update = $this->banner_model->updateItem($params_translate, $params);

			if ($update) {
				$this->session->set_flashdata('alert', 'success');
				$this->session->set_flashdata('msg', $this->lable['edit_succ']);
				redirect( admin_url("banner/items") );
			} else {
				unlink( $this->_path_upload.'/'.$params['banner_file'] ); // remove banner just upload
				$this->_data['alert'] = 'danger';
				$this->_data['msg'] = $this->lable['edit_fail'];
				$this->_data['data'] = $params;
				$this->parser->parse("banner/$tpl", $this->_data);
				return;
			}
		} else { // insert

		    $insert = $this->banner_model->insertItem($params, $_data);

			if ($insert) {
				$this->session->set_flashdata('alert', 'success');
				$this->session->set_flashdata('msg', $this->lable['add_succ']);
				redirect( admin_url("banner") );
			} else {
				unlink( $this->_path_upload.'/'.$params['banner_file'] ); // remove banner just upload
				$this->_data['alert'] = 'danger';
				$this->_data['msg'] = $this->lable['add_fail'];
				$this->_data['data'] = $params;
				$this->parser->parse("banner/$tpl", $this->_data);
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
			redirect(admin_url('banner/items'));
		}

		$this->banner_model->id = $id;

		$cond_img = " AND c.image_type = '$this->_post_type' ";

		$cond_vi = " AND a.banner_id = $id  AND b.lang = '".LANG_VI."' ";
		$_data_vi = $this->banner_model->getItemByCond($cond_vi, $cond_img);

		/*
		$cond_en = " AND a.banner_id = $id  AND b.lang = '".LANG_EN."' ";
		$_data_en = $this->banner_model->getItemByCond($cond_en, $cond_img);
        */

		$banner_file = $this->copy_image_new_path($_data_vi['banner_file']);

		$params = array(
			'category_id'   => $_data_vi['category_id'],
			'user_id'		=> $_data_vi['user_id'],
			'banner_clip'	=> $_data_vi['banner_clip'],
			'banner_file'	=> $banner_file,
			'banner_link'	=> $_data_vi['banner_link'],
			'date_add'      => date('Y-m-d H:i:s'),
			'avail'         => DUPLICATED_AVAIL
		);


		$params_vi = array(
			'lang'          => $_data_vi['lang'],
			'title'         => $_data_vi['title'],
			'short'         => $_data_vi['short'],
		);

		$params_en = '';
		/*
		array(
			'lang'          => $_data_en['lang'],
			'title'         => $_data_en['title'],
			'short'         => $_data_en['short'],
		);
        */

		$insert = $this->banner_model->duplicateItem($params, $params_vi, $params_en);

		if ($insert) {
			$this->session->set_flashdata('alert', 'success');
			$this->session->set_flashdata('msg', $this->lable['duplicate_success']);
			redirect( admin_url("banner/items") );
		} else {
			$this->session->set_flashdata('alert', 'danger');
			$this->session->set_flashdata('msg', $this->lable['duplicate_fail']);
			redirect( admin_url("banner/items") );
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

		$cond = '';
		$more_url = "&t=$tab";
		$keyword = trim(strip_tags($keyword));
		if($keyword){
			$cond .= " AND b.title LIKE '%$keyword%' ";
			$more_url .= "q=$keyword";
			$this->_data['search'] = $keyword;
		}

		if($category) {
			$cond .= " AND a.category_id = '$category' ";
			$more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";
			$this->_data['cat'] = $category;
		}

		$this->_data['alert'] = '';
		$this->_data['breadcrumb'] = $this->lable['banner'];

		if($tab == BLOG_TAB_ACTIVE) {
			$cond .= " AND a.avail = 1 ";
		}

		if($tab == BLOG_TAB_INACTIVE) { // Recycle bin
			$cond .= " AND (a.avail = 0 || a.avail = 2) ";
		}

		$cond_items = " $cond ";
		$cond_total = " $cond ";

		$totalItems  = $this->banner_model->countItems($cond_total);
		$per_page    = $this->lable['per_item_admin'];
		$base_url    = admin_url('banner/items');
		$uri_segment = 4;
		$this->load->library('pagination_library');
		$this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
		$this->_data['links'] = $this->pagination->create_links();

		$curpage = $this->input->get('per_page');
		$offset = ($curpage) ? $curpage : 0;
		$start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
		$items = $this->banner_model->getItems($cond_items, $per_page, $start);
		$this->_data['items'] = $items;

        $categories = $this->banner_model->blogCategories(" WHERE avail = 1");
        $this->_data['categories'] = $categories;

		$this->_data['alert'] = $this->session->flashdata('alert');
		$this->_data['msg'] = $this->session->flashdata('msg');

		$this->parser->parse("banner/items.tpl", $this->_data);
	}

	/**
	 * Delete to Recycle bin
	 * @return void
	 */
	function deletemulti() {
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

		$checkAll = $this->input->post('checkAll');
		foreach ($checkAll as $id) {
			$this->banner_model->id = $id;
			$this->banner_model->updateBlogByFields( array('avail' => 0) );
		}

		$this->session->set_flashdata('alert', 'success');
		$this->session->set_flashdata('msg', $this->lable['delete_succ']);
		redirect( admin_url("banner/items") );
		return;
	}

	/**
	 * Remove physical item
	 */
	function removemulti() {
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

		$checkAll = $this->input->post('checkAll');

		foreach ($checkAll as $id) {

			$this->banner_model->id = $id;
			$data = $this->banner_model->getItemById("");
			$delete = $this->banner_model->deleteItem( array('banner_id'=>$id) );
			if($delete) {
				@unlink($this->_path_upload.$data['banner_file']);
			}
		}

		$this->session->set_flashdata('alert', 'success');
		$this->session->set_flashdata('msg', $this->lable['delete_succ']);
		redirect( admin_url("banner/items") );
		return;
	}

    /**
     * Restore Item
     *
     * @param int $id
     */
    function restore() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $blog_id = $this->input->get('id');

        if($blog_id && $blog_id > 0){
            $this->banner_model->id = $blog_id;
            $this->banner_model->updateBlogByFields(array('avail' => 1));
        }

        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('msg', $this->lable['restore_success']);
        redirect( admin_url($this->_control."/items/?t=5"));
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
            $this->banner_model->id = $blog_id;
            // $this->blogs_model->current_lang = $lang;
            echo $this->banner_model->updateBlogByFields( array('home_status' => $display_home) );
            return;
        }

        echo 0;
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
		$primary = $this->input->post('id');
		$avail = $this->input->post('s');

		if($primary != '') {
			$this->banner_model->id = $primary;
			echo $this->banner_model->updateBlogByFields(array('avail'=>$avail));
			return;
		}

		echo 0;
		return;
	}

	function do_slim_upload() {
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
			$path_image = $new_path.$file['name'];

            $webp = $this->webp_lib->convert($this->path_upload.$path_image);
            if($webp->status == ACTIVE){
                unlink($this->path_upload.$path_image);
                $path_image = $new_path.$webp->file;
            }

			$old = $this->input->post('old');
			$old_img = $old['path_image'];
			if($old_img != '') {
				unlink( $this->_path_upload.'/'.$old_img );
			}
		} else {
			$old = $this->input->post('old');
			$path_image = $old['path_image'];
		}

		return $path_image;
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
	function copy_image_new_path($old_image) {
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
		$pic_new = date('his').'-'.$pic;
		$dest_path = $this->_path_upload.'/'.$new_path.$pic_new;

		if($pic) {
			@copy($file_path, $dest_path);
			$path_image = $new_path.$pic_new;
		}

		return $path_image;
	}

}