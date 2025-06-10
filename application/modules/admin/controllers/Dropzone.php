
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dropzone extends MY_Controller {
  
   private $_data;
        private $_control; 
        private $_action;
        private $_pathLogo; 
	
	
	public function __construct(){
            parent::__construct();
            
            $this->_pathImg = $this->config->item('path_thumb');
            $this->_path_thumb = base_url().$this->config->item('dir_thumb');
            
            $this->_data['admin_cpanel_title'] = $this->lable['admin_cpanel_title'];
            $this->_data['base_url']           = $this->config->item("base_url");
            $this->_data['base_tlp_admin']     = $this->config->item("base_tlp_admin");
            $this->_data['base_url_admin']     = $this->config->item("base_url_admin");
            $this->_data['lable']              = $this->lable;
            $this->_data['user_data']          = $this->session->userdata('login');
            
            $this->_control                 = $this->router->class;
            $this->_action                  = $this->router->method; 
            $this->_pathLogo                = $this->config->item('path_logo');
            $this->_data['current_control'] = $this->_control; 
            $this->_data['current_method']  = $this->_action;
            $this->_data['tour_id']   = 25; 

            $back_url = admin_url($this->_control.'/add');
            
            
	}
 
    public function index() {
        //echo $targetPath = $this->_pathLogo. '/uploads/';die; 
        $this->parser->parse('dropzone_view.tpl', $this->_data);
    }
    
    public function upload() {
        
        
        if (!empty($_FILES)) {
        $tempFile = $file['tmp_name'];
        $fileName = $file['name'];
        $targetPath = $this->_pathLogo. '/uploads/';
        $targetFile = $targetPath . $fileName ;
        move_uploaded_file($tempFile, $targetFile);
        // if you want to save in db,where here
        // with out model just for example
        // $this->load->database(); // load database
        // $this->db->insert('file_table',array('file_name' => $fileName));
        } 
        
        
    }
    
    
    function uploadmulti() {
        
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        $datas = array();
        
        $file_path_year = $this->_pathImg.'/'. $year;
		if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }
		
		$file_path_month = $file_path_year .'/'.  $month;
		if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

		$file_path_day = $file_path_month .'/'.  $day ; 
		if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

		$new_path = $year.'/'.$month.'/'.$day.'/';
         
        
        $this->load->library('upload_library');
        $upload_list = $this->upload_library->upload_file($file_path_day,'image_list');
         
        
    }
}
 
