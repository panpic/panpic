<?php
/**
* Model Backend language
* Last update 16 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 16 Jan 2017
*/

class Experience_model extends MY_Model
{
    //tour_services
    var $table = 'tour';
    public $tour_id              = '0'; 
    public $_pathThumb           = ''; 
    private $_images             = 'images';
    private $_tour               = 'tour';
    private $_tour_starting_date = 'tour_starting_date';
    private $_tour_dayofweek     = 'tour_dayofweek';
    private $_tour_transport     = 'tour_transport';
    private $_tour_pickup_points = 'tour_pickup_points';
    private $_tour_hotel         = 'tour_hotel';
    private $_tour_services      = 'tour_services';
    private $_tour_moreinfo      = 'tour_moreinfo';
    private $_tour_schedule_day  = 'tour_schedule_day';
    private $_call_me_back       = 'call_me_back';
    private $_agency             = 'agency';
    private $_call_back_request  = 'call_back_request';
    private $_hits               = 'hits';
    private $_tour_category      = 'tour_category';
    private $_tour_category_desc = 'tour_category_desc';
    
    //tour_category_desc
    function table_tour_category_desc(){ return $this->_tour_category_desc; }
    
    function table_tour_category(){ return $this->_tour_category; }
    
    function table_images(){ return $this->_images; }
    
    function table_tour(){ return $this->_tour;}
    
    function table_tour_starting_date(){ return $this->_tour_starting_date;}
   
    function table_tour_dayofweek(){ return $this->_tour_dayofweek;}
    
    function table_tour_transport(){ return $this->_tour_transport;}
    
    function table_tour_pickup_points(){ return $this->_tour_pickup_points;}
    
    function table_tour_hotel(){ return $this->_tour_hotel;}
    
    function table_tour_services(){ return $this->_tour_services;}
    
    function table_tour_moreinfo(){ return $this->_tour_moreinfo;}
    
    function table_tour_schedule_day(){ return $this->_tour_schedule_day;}
    
    function table_call_me_back(){ return $this->_call_me_back;}
    
    function table_agency(){ return $this->_agency;}
    
    function table_call_back_request(){ return $this->_call_back_request;}
    
    function table_hits(){ return $this->_hits;}
    
    
    function countItems($cond){
        $sql = "SELECT t.tour_id, t.title, t.tour_sku, t.slug FROM {$this->table_tour()} AS t"
        . " JOIN {$this->table_images()} AS im "
            . " ON t.tour_id = im.object_id AND image_type = 'exp' $cond GROUP BY im.object_id ";
        return $this->db->query($sql)->num_rows();
        
    }
    
    function getItems($cond ='', $num ='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT t.tour_id, t.title, t.tour_sku, t.slug FROM {$this->table_tour()} AS t"
        . " JOIN {$this->table_images()} AS im "
            . " ON t.tour_id = im.object_id AND image_type = 'exp' $cond GROUP BY im.object_id $limit";
        $query =  $this->db->query($sql)->result_array();
        $tmp = array(); 
        foreach($query as $row){
            $row['listImage'] = $this->getImageByItem($row['tour_id']);
            $tmp[] = $row; 
        }
        return $tmp; 
    }
    
    /**
     * @param 
     * @return list image by tour_id & image_type = 'exp'
     */
    
    function getImageByItem($tour_id){
        $sql = "SELECT image_id, object_id, image_type, path_image FROM {$this->table_images()} "
        . " WHERE object_id = $tour_id AND image_type = 'exp' ";
        return $this->db->query($sql)->result_array(); 
    }
    
    /*
    function insertImageExp($data='', $tour_id=''){
        if(!$data) return ; 
        $this->db->trans_begin(); 
        $total = sizeof($data['images']);
        
        for($i=0; $i < $total ; $i++){
            $images = array(
                'object_id' => $tour_id, 
                'image_type' => 'exp',
                'path_image' => $data['images'][$i],
                'image_id'   => $data['image_id'][$i],
            ); 
            $image_id = $data['image_id'][$i];
            if(empty($image_id)){
                $this->db->insert($this->table_images(), $images); 
            } else {
                $this->db->update($this->table_images(), $images, array('image_id' => $image_id));
            } 
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $tour_id ; 
        } 
        
    }
     * 
     */
    
    /**
     * 
     * @param type $data
     * @return type
     */
    function insertImage($data){
        $image_id = $data['image_id']; 
        if(empty($image_id)){
            $this->db->insert($this->table_images(), $data);
            return $this->db->insert_id(); 
        } else {
            $this->db->update($this->table_images(), $data, array('image_id' => $image_id));
            return $image_id; 
        }
        
    }
    
    
    /**
     * 
     * @param type $cond
     * @return type
     */
    function searchTour($cond) {
        $sql = "SELECT t.tour_id, t.title FROM ".$this->table_tour()." AS t 
                JOIN ".$this->table_images()." AS img 
                ON t.tour_id = img.object_id AND t.avail = 1 $cond
                AND NOT EXISTS (
                    SELECT * FROM ".$this->table_images()." AS ima WHERE t.tour_id = ima.object_id AND ima.image_type = 'exp'  
                )
                GROUP BY t.tour_id "; 
        return $this->db->query($sql)->result('array');
    }
    
    function getInfoTour($tour_id=''){
        $this->db->select('tour_id,title'); 
        $query = $this->db->get_where($this->table_tour(), array('tour_id' => $tour_id)); 
        return $query->row_array(); 
    }
    
    function getInfoItem($id){
        $query = $this->db->get_where($this->table_images(), array('image_id' => $id)); 
        return $query->row_array(); 
    }
    
    function removeImage($id){
        return $this->db->delete($this->table_images(), array('image_id' => $id)); 
    }
    
    
    
  
    
    
}