<?php

/**
 * Controllers Backend
 * Last update Jan 13 2016
 * 
 * @package Backend
 * @copyright PANPIC
 * @author Panpic.vn
 * @author pos: PHP Developer
 * @version 1.0
 * @since Sep 14 2016
 */
class Myfile extends MY_Controller {
    
    private $_file_ext = "jpg,jpeg,gif,png";
    private $_pathImg;
    private $_path_thumb;
            
     public function __construct(){
        parent::__construct();
        
        $this->_pathImg = $this->config->item('path_thumb');
        $this->_path_thumb = base_url($this->config->item('dir_thumb'));
        
        $this->load->model('fileupload_model');
        $this->load->helper(array('url','html','form'));
    }
    

    /**
     * 
     * Form add
     * @return void
     */
    function index()
    {
        //nothing
    }

    /**
     * Upload file
     *
     * @param object $_POST['file']
     * @param int $object_id
     * @param string $object_type
     */
    function upload() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        $object_id   = $id = $this->input->post_get('object_id');
        $object_type = $this->input->post_get('object_type');
        $day_id      = $this->input->post_get('day_id'); 
        $day_id      = ($day_id == '') ? 0 : $day_id;
        
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $datas = array();

        //if ($object_id) {

        $file_path_year = $this->_pathImg.'/'. $year;
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year .'/'.  $month;
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month .'/'.  $day ; 
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

        $new_path = $year.'/'.$month.'/'.$day.'/';

        $prefex       = date("ymd-hs");
        $tempFile     = $_FILES['file']['tmp_name'];
        $new_filename = $prefex.'-'.$_FILES["file"]["name"];
        $targetFile   = $file_path_day.'/'.$new_filename;

        $file_size    = $_FILES['file']['size'];
        
        //echo $file_size; die; 
        $file_type    = $_FILES['uploaded_file']['type'];
        $path_image   = $new_path.$new_filename;

        move_uploaded_file($tempFile, $targetFile);

        $image  = array(
            'path_image' => $path_image,
            'date_add'   => date("Y-m-d H:i:s"),
            'image_type' => $object_type,
            'object_id'  => $object_id,
            'day_id'     => $day_id, 
        ); 

        $last_id = $this->fileupload_model->insertImage($image);

        if ($last_id) { // get file
            $this->fileupload_model->image_id = $last_id;
            $image = $this->fileupload_model->getImageByImageId();

            $fileclass = new stdClass();
            $imageName = $this->_path_thumb.$image['path_image'];

            $fileclass->image_id    = $last_id;
            $fileclass->name        = $file['image_id']; //$image['path_image'];
            $fileclass->size        = $file_size;
            $fileclass->type        = $file_type;
            $fileclass->delete_url  = $imageName.'?_method=DELETE&image_id='.$last_id;
            $fileclass->delete_type = 'DELETE';
            $fileclass->error       = 'null';
            $fileclass->url         = $imageName;

            $datas[] = $fileclass;
            
        } 

        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($datas);
       //}
    }

    /**
     * Remove image & clear data
     *
     * @param string $image_id int
     * @param string $dir_path;
     */
    function delete() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $image_id = $this->input->post_get('files');
        
        $this->fileupload_model->dir_path = $this->_pathImg;
        $this->fileupload_model->image_id = $image_id;
        $del  = $this->fileupload_model->removeImage();
        
        echo true; //json_encode($success);
    }

    /**
     * List file upload
     *
     * @param int $object_id
     * @param string $object_type
     */
    function view() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $result = array();
        $image_url = $this->_path_thumb;
        $object_id = $this->input->post_get('object_id');
        $day_id    = $this->input->post_get('day_id'); 
        $day_id    = ($day_id == '') ? 0 : $day_id;
        
        $this->fileupload_model->cond = " object_id = $object_id AND day_id = $day_id";
        
        $files = $this->fileupload_model->getFilesByCond();

        if ($files) {
            foreach ($files as $file) {
                $name = $file['title'];
                $path_image = $file['path_image'];
                
                $file_path = $this->_pathImg.DS.$path_image;
                
                $obj['image_id']    = $file['image_id'];
                $obj['name']        = $file['image_id']; //$path_image;
                $obj['size']        = file_exists($file_path) ? filesize($file_path) : '';
                $obj['delete_url']  = $file_path .'?_method=DELETE&image_id='.$file['image_id'];
                $obj['delete_type'] = 'DELETE';
                $obj['error']       = 'null';
                $obj['url']         = $image_url.$path_image; //$image_url.$year.'/'.$name;
                $result[]           = $obj;
            }
        }
        
        header('Content-type: text/json');
        header('Content-type: application/json');
        
        echo json_encode($result);
    }

    /**
     * Update main file
     */
    function mainfile() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $name = $this->input->post_get('file_main');
        $type = $this->input->post_get('type');
        $tour_id = $this->input->post_get('tour_id');

        if ($name) {
            $this->_model->file_name = $name;
            $row = $this->fileupload_model->getImageByFilename();

            if ($row) {
                $type = ($type == 1) ? 'M' : '';
                $this->fileupload_model->updatePos(" path_image ='' ", " object_id='" . $tour_id . "' ");
                $this->fileupload_model->updatePos(" path_image = '$type' ", " image_id='" . $row['image_id'] . "' ");
            }
        }
    }

    /**
     * Check image file is main
     */
    function maincheck() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $name = $this->input->post_get('file_main');

        if ($name) {
            $this->fileupload_model->file_name = $name;
            $row = $this->fileupload_model->getImageByFilename();

            if ($row['image_type'] == 'td') {
                echo 1;
                return;
            }
        }

        echo 0;
        return;
    }
    
    function test() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        
        $file_path_year = $this->_pathImg."/$year/";
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year.$month.'/';
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month.$day.'/';
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE); } 
        $new_path = $year.'/'.$month.'/'.$day.'/';
            
                
        $image = array(); 
        $this->load->library('upload_library');
        $upload_list = $this->upload_library->upload_file($file_path_day, 'file');

        prev($upload_list);


        $this->parser->parse("tour/test.tpl", $this->_data);
    }
    
}
