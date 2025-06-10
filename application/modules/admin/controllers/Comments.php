<?php
/**
 * Controllers Backend
 * Last update 31 August 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 31 August 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends MY_Controller{


    public function __construct(){
        parent::__construct();

        $this->load->model('comments_model');
        $this->load->library('slim_library');
        $this->load->library('admin_permission');

        $this->_data['ADMIN_BLOG_VERIFY'] = ADMIN_BLOG_VERIFY;
        $this->_data['BLOG_TAB_VIEWALL'] = BLOG_TAB_VIEWALL;
        $this->_data['BLOG_TAB_UNVERIFY'] = BLOG_TAB_UNVERIFY;
        $this->_data['BLOG_TAB_VERIFY'] = BLOG_TAB_VERIFY;
        $this->_data['BLOG_TAB_ACTIVE'] = BLOG_TAB_ACTIVE;
        $this->_data['BLOG_TAB_INACTIVE'] = BLOG_TAB_INACTIVE;
        $this->_data['BLOG_TAB_MEMBER'] = BLOG_TAB_MEMBER;

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
     * Form add  
     * 
     */
    function index(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->_data['breadcrumb'] = $this->lable['blog'];
        $this->_data['alert'] = '';

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        $data = array();

        if (!empty($id) && $option == 'edit') {
            $this->comments_model->id = $id;
            $data = $this->comments_model->getItemById();
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

        $this->parser->parse("comments/index.tpl", $this->_data);
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
        $this->_data['breadcrumb'] = $this->lable['blog'];

        if($option == OPTION_EDIT){
            $sub = 'sub';
            $cId = $_data['category'];
        }

        $this->load->library('nestedtourcat_library');
        $categories = $this->tourcat_model->getNodeByParentId( $this->_blog_parent_category );
        $arrNested = $this->nestedtourcat_library->cmbNested($categories, $sub, $cId, 1);
        $this->_data['categories'] = $arrNested;

        $params = array(
            'category'       => $_data['category'],
            'title'          => addslashes($_data['title']),
            'short'          => addslashes($_data['short']),
            'content'        => addslashes($_data['content']),
            'date_add'       => $_data['date_add'],
            'seo_title'      => trim(strip_tags($_data['seo_title'])),
            'seo_description'=> trim(strip_tags($_data['seo_description'])),
            'admin_verify'   => $_data['admin_verify']
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

            $this->parser->parse("comments/index.tpl", $this->_data);
            return;
        }

        if (!empty($id) && $option == OPTION_EDIT) { //Update

            $slug = $this->comments_model->get_slug_exist($params_slug['slug'], $id);
            $params_slug['slug'] = $slug;
                
            $this->comments_model->id = $id;
            $update = $this->comments_model->updateItem($params, $params_slug);

            if ($update) {
                $this->do_slim_upload($id);
                $back_url = admin_url("comments/items/");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['edit_succ'];
                $this->parser->parse("comments/index.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['edit_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("comments/index.tpl", $this->_data);
                return;
            }

        } else { //insert

            $slug = $this->comments_model->get_slug_exist($params_slug['slug']);
            $params_slug['slug'] = $slug;
            $insert = $this->comments_model->insertItem($params, $params_slug);

            if ($insert) {
                $this->do_slim_upload($insert);
                $back_url = admin_url("comments");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['add_succ'];
                $this->parser->parse("comments/index.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['add_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("comments/index.tpl", $this->_data);
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
		$tab = $this->input->get('t');
        $tab = ($tab == '') ? 1 : $tab;
        $this->_data['tab'] = $tab;

        $cond = '';
        $more_url = '';
        $keyword = trim(strip_tags($keyword));
        if($keyword){
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " (c.title LIKE '%{$keyword}%' OR s.comments LIKE '%{$keyword}%') ";
            $more_url .= "q=$keyword";
            $this->_data['search'] = $keyword;
        }
        
        if($category) {
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " c.category = $category ";
            $more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";
            $this->_data['cat'] = $category;
        }

        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['blog'].' / '. $this->lable['comment'];
        
        if($tab == BLOG_TAB_UNVERIFY) {
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " s.comment_verify = 0 ";
        }

        if($tab == BLOG_TAB_VERIFY) {
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " s.comment_verify = 1 ";
        }
        if($tab == BLOG_TAB_ACTIVE) {
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " s.avail = 1 ";
        }

        if($tab == BLOG_TAB_INACTIVE) {
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " s.avail = 0 ";
        }


        $cond = ($cond != '') ? " WHERE $cond " : '';
        $totalItems  = $this->comments_model->countItems($cond);
        $per_page    = $this->lable['per_item_admin']; 
        $base_url    = admin_url('comments/items');
        $uri_segment = 4;
        $this->load->library('pagination_library'); 
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url, $more_url); 
        $this->_data['links'] = $this->pagination->create_links();
        
        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;      
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $this->_data['items'] = $this->comments_model->getItems($cond, $per_page, $start);
        
        $this->parser->parse("comments/items.tpl", $this->_data);
    }
	
    
    /**
     * Delete to Recycle bin
     * @return void
     */
    function deletemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        $checkAll = $this->input->post('checkAll');
        
        foreach ($checkAll as $id) {
            $this->comments_model->id = $id;
            $this->comments_model->updateByFields( array('avail' => 0) );
        }
        
        $back_url = admin_url("comments/items/");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse("comments/items.tpl", $this->_data);
        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
        return; 
    }


    function removemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $checkAll = $this->input->post('checkAll');

        foreach ($checkAll as $id) {
            $this->comments_model->id = $id;
            // $data = $this->comments_model->getItemById();
            // @unlink($this->_path_upload.'/'.$data['path_image']);
            // @unlink($this->_path_upload.'/'.$data['path_image_thumb']);
            $this->comments_model->deleteItem( array('id'=>$id) );
        }

        $back_url = admin_url("comments/items/");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse("comments/items.tpl", $this->_data);
        header("refresh:". $this->lable['timewait'].";url=".$back_url."");
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
        $avail = ($avail == 1) ? 0 : 1;
        
        if($primary != '') {
            $this->comments_model->id = $primary;
            echo $this->comments_model->updateByFields(array('avail'=>$avail));
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
        $primary = $this->input->post_get('id');
        $display_home = $this->input->post_get('d');
        $display_home = ($display_home == 1) ? 1 : 0;
        
        if($primary != '') {
            echo $this->comments_model->id = $primary;
            echo $this->comments_model->updateByFields( array('comment_verify' => $display_home) );
            return;
        }
        
        echo 0;
        return;
    }


    
}