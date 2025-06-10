<?php
/**
 * Model Admin_Fileupload
 * Last update Sep 14 2016
 * 
 * @package Admin/file upload
 * @copyright Xaytot
 * @author Panpic technology
 * @author position: PHP Developer
 * @version 1.0
 * @since Sep 14 2016
 */

class Fileupload_model extends CI_Model {
	
	
	public $dir_path;
        
        private $_table_images = 'images';
        public $image_type = 'ts'; //tour schedule
        public $image_id;
        public $cond;
        public $file_name;
        
        
        
        function __construct() {
            
            // $this->dir_path = $this->config->item('path_thumb');
        }
        
	
        function tableImages(){
            return $this->_table_images;
        }
	
	function image_id() {
            return ' image_id = "'.$this->image_id.'" ';
        }
        
	
	/**
	 * Get image by image_id
	 *
	 * @param $this->image_id
	 * @return array row
	 */
	function getImageByImageId() {
            if($this->image_id == '') return;

            $sql = "SELECT * FROM ".$this->tableImages()." WHERE image_id = ".$this->image_id;
            return $this->db->query($sql)->row_array();
	}
	
	/**
	 * Get image by image-name
	 *
	 * @param string $this->file_name
	 * @return array row
	 */
	function getImageByFilename() {
		if($this->file_name == '') return ;
		
		$sql = "SELECT * FROM ".$this->tableImages()." WHERE path_image = '$this->file_name'";
		return $this->db->query($sql)->row_array();
	}
	
	
	/**
	 * 
	 * Get image by object Id
	 * 
	 * @param $this->primary; ($object_id)
	 * @return array mix;
	 */
	function getFilesByObject() {
            if($this->object_id == '') return ;
            $sql = "SELECT * FROM ".$this->tableImages()." WHERE object_id = $this->object_id ";
            return $this->db->query($sql)->result('array');
	}
		
	
	/**
	 * 
	 * Get item by condition
	 * 
	 * @param string $this->cond
	 * @return array mix
	 */
	function getFilesByCond(){
				
            if( $this->cond == '') return ;
            
            $sql = "SELECT * FROM ".$this->tableImages()." WHERE $this->cond ";
            return $this->db->query($sql)->result('array');
		
	}
        
	/**
	 * update somes fields
	 *
	 * @param string $fields
	 * @return bool
	 */
	function updatePos($fields, $cond){
		$sql = "UPDATE ".$this->tableImages()." SET $fields WHERE $cond";
		$result = $this->db->query($sql)->row_array();
                
		if($result) return true;
		else return false;		
	}
	
	
	
	
	/**
	 * 
	 * Insert images
         * 
	 * @param array row $params
	 * @param array row $imagesLink
	 */
	function insertImage($params){
            
            $this->db->insert( $this->tableImages(), $params);
            return $this->db->insert_id();
            
            /*
            $this->db->trans_begin();
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback(); 
                return FALSE; 
            } else {
                $this->db->trans_commit(); 
                return $last_id; 
            }    
            */
	}
	
	
	/**
	 * 
	 * Upadate images & imagesLinks
	 * @param array row $params
	 */
	function updateImage($params){
            
            $this->db->where('image_id', $this->image_id);
            return $this->db->update($this->tableImages(), $params);
            
	}
	
	
	/**
	 * Remove & clear data
	 * unlink file
	 */
	function removeImage() {
		
            $image = $this->getImageByImageId();
            
            $file_image = $this->dir_path.$image['path_image'];

            $this->deleteImage(array('image_id' => $image['image_id'] ));

            if(file_exists($file_image)) {
                @unlink($file_image);
            }
		
	}
	
	
	/**
	 * Delete physical image
	 *
	 */
	function deleteImage($where){
            
            if(!$where) return;

            $this->db->where($where); 
            return $this->db->delete( $this->tableImages() );
            
	}
	
	
}

//END class