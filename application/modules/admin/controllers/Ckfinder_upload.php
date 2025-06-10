<?php
/**
* Controllers Backend Blogs
* Last update 12 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 12 Jan 2017
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ckfinder_upload extends MY_Controller{

    private $control;

    public function __construct(){
        parent::__construct();
        $this->control = $this->router->class;
        
        $this->load->library('directoryfile_library');
        $this->load->library('ckfinder');
        
        $pathMedia  = $this->directoryfile_library->directoryFile( $this->config->item('path_media') );
        
        $this->ckfinder->setProjectPath(FCPATH); // Tên project của bạn
        $this->ckfinder->setFolderUpload('media/'.$pathMedia['new_path']); // Cấu hình folder upload
        $this->ckfinder->setCkfinderSourcePath('assets/data/ckfinder'); // Đường dẫn tới source ckfinder
        $this->ckfinder->setAuthentication(true);// Nếu true => cho phép sử dụng ckfinder; ngược lại false thì ko được phép sử dụng   
        
        // Đường dẫn tuyệt đối dẫn đến function connector ở bên dưới      
        $this->ckfinder->setConnectorPath(base_url('admin/'.$this->control.'/connector'));
    }

    
    public function connector() {
        $this->ckfinder->startConnector();
    }

 
    public function html() {
        $this->ckfinder->getHTML();
    }


}