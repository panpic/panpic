<?php
/**
 * Controllers Backend Location Destination
 * Last update 29 August 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 29 August 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carcat extends MY_Controller{
	

	// private $_data;
	// private $_pathImg;


    public function __construct(){
        parent::__construct();

        $this->_data['link_upload'] = $this->_link_upload;
        $this->load->model('carcat_model');
        $this->load->library('slim_library');
        $this->load->library('admin_permission');

        $session_admin = $this->_data['user_data'];
        $adminPermission= $session_admin->adminPermission;

        $super_admin = $this->config->item("super_admin");
        if($session_admin->adminRole != $super_admin) {
            if(strpos($adminPermission,4) == false && $adminPermission != 4) {
                if($this->admin_permission->myPermission($this->_control, $adminPermission) == false) {
                    redirect(admin_url('index/notpermission'));
                }
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

        $this->_data['breadcrumb'] = $this->lable['product_size'];
        $this->_data['alert'] = '';

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : 'add';
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        $data = array('name'=>'', 'value'=>'');

        if (!empty($id) && $option == 'edit') {
            $this->carcat_model->id = $id;
            $data = $this->carcat_model->getItemById();
        }

        // echo '<pre>'; print_r($data);
        $this->_data['data'] = $data;
        $this->_data['valid'] = '';

        $this->parser->parse("carcat/index.tpl", $this->_data);
	}

        
    /**
     * Process form add
     */
    function add() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $data = $this->input->post('data');
        $id = $this->input->post('primary');
        $old = $this->input->post('old');

        $option = $this->input->post('option');
        $this->_data['task'] = $this->lable[$option];
        $this->_data['option'] = $option;
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['product_size'];

        $params = array(
            'category'  => $data['category'],
            'date_add'  => $data['date_add'],
        );

        //@ Validation
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
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
            $valid = array('category' => $errors['data[category]']);

            $this->_data['valid'] = $valid;
            $this->_data['alert'] = 'danger';
            $this->_data['msg'] = $msg;
            $this->_data['data'] = $params;

            $this->parser->parse("carcat/index.tpl", $this->_data);
            return;
        }

        if (!empty($id) && $option == 'edit') { //Update

            $this->carcat_model->id = $id;
            $update = $this->carcat_model->updateItem($params);

            if ($update) {

                /*
                if($flag_change_img) {
                    @unlink($this->_path_upload.'/'.$old['path_image']);
                } */

                $back_url = admin_url("carcat/items/");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['edit_succ'];
                $this->_data['data'] = $params;
                $this->parser->parse("carcat/index.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;

            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['edit_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("carcat/index.tpl", $this->_data);
                return;
            }
        } else { //insert

            $insert = $this->carcat_model->insertItem($params);
            if ($insert) {
                $back_url = admin_url("carcat");
                $this->_data['alert'] = 'success';
                $this->_data['msg'] = $this->lable['add_succ'];
                $this->_data['data'] = $params;
                $this->parser->parse("carcat/index.tpl", $this->_data);
                header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                return;
            } else {
                $this->_data['alert'] = 'danger';
                $this->_data['msg'] = $this->lable['add_fail'];
                $this->_data['data'] = $params;
                $this->parser->parse("carcat/index.tpl", $this->_data);
                return;
            }
        }
    }


    /**
     * List items
     *
     */
    function items(){
        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['product_size'];

        $cond = '';
        $totalItems  = $this->carcat_model->countItems($cond);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url('carcat/items');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;

        $this->_data['items'] = $this->carcat_model->items($cond, $per_page, $start);
        $this->parser->parse("carcat/items.tpl", $this->_data);
    }


    function delete() {
        $id = $this->input->get('id');
        $this->_data['breadcrumb'] = $this->lable['product_size'];
        
        if(! $id) {
            redirect(admin_url('carcat/items'));
        }

        $this->carcat_model->deleteItem( array('cat_cat_id'=>$id) );

        $back_url = admin_url("carcat/items");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse("carcat/index.tpl", $this->_data);
        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
        return;

    }
	

}