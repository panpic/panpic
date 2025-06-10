<?php
/**
* Controllers Backend Members users
* Last update 20 Sep 2018
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 20 Sep 2018
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends MY_Controller{
	


	public function __construct(){
        parent::__construct();
        $this->load->model('members_model');
        $this->load->library('admin_permission');

            $this->_data['dir_path']  = $this->_path_upload;
            $this->_data['link_upload']  = $this->_link_upload;

        $back_url = admin_url($this->_control.'/add');
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
     * List members
     *
     * @param int $start
     */
	function index($start=0){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            $this->_data['breadcrumb'] = $this->lable['members'];

            $keyword = $this->input->get('q');
            $tab = $this->input->get('t');
            $tab = ($tab == '') ? 1 : $tab;
            $this->_data['tab'] = $tab;

            $cond = '';
            $more_url = '';
            $keyword = trim(strip_tags($keyword));
            if($keyword){
                    $cond .= " (email LIKE '%{$keyword}%' OR last_name LIKE '%{$keyword}%' OR first_name LIKE '%{$keyword}%') ";
                    $more_url .= "q=$keyword";
                    $this->_data['search'] = $keyword;
            }

            if($tab == 2) {
                    $cond .= ($cond != '') ? " AND " : $cond;
                    $cond .= " avail = 1 ";
            }

            if($tab == 3) {
                    $cond .= ($cond != '') ? " AND " : $cond;
                    $cond .= " avail = 0 ";
            }


        $cond = ($cond != '') ? " WHERE $cond " : '';
        $totalItems  = $this->members_model->countItems($cond);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url('members');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $items = $this->members_model->getItems($cond, $per_page, $start);
        $this->_data['items'] = $items;
        // pre($items);

        $this->parser->parse("members/index.tpl", $this->_data);
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
            $user_id = $this->input->post('id');
            $avail = $this->input->post('s');
            $avail = ($avail == 1) ? 0 : 1;

            if($user_id != '') {
                    $this->members_model->id = $user_id;
                    echo $this->members_model->updateByFields(array('avail'=>$avail));
                    return;
            }

            echo 0;
            return;
    }

    
}