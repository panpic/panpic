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

class Tour_model extends MY_Model
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
    private $_tour_suggestion = 'tour_suggestion';
    //tour_suggestion
    
    function table_tour_suggestion(){ return $this->_tour_suggestion; }
    
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
    
    
     public function get_slug_exist($slug, $tour_id='') {
        $cond = ($tour_id != '') ? " AND tour_id <> $tour_id " : '';
        
        $sql = "SELECT slug FROM ".$this->table_tour()." WHERE slug = '$slug' $cond";
        $exist_slug = $this->db->query($sql)->row()->slug;
        
        if($exist_slug) {
            $exist_slug .= '-1';
            return $this->get_slug_exist($exist_slug);
        }
        
        return $slug;
    }
    
    
    //tour_hotel
    /**
     * @return array
     */
    function getPackage(){
        return $this->db->get($this->table_package())->result_array(); 
    }
    
    /**
     * 
     * @param type $cond
     * @param type $num
     * @param type $offset
     * @return list items
     */
    function getItems($cond='', $num='', $offset='', $order_by=''){
        
        $order_by = !empty($order_by)  ? $order_by   : ' ORDER BY t.date_add DESC ';
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
         
        $sql = " SELECT 
                    t.*, 
                    a.agency_name, a.agency_id, a.slug AS a_slug,
                    viewed.view_count,
                    called.call_count,
                    phoned.phone_count
            FROM ".$this->table_tour()." AS t  
            JOIN ".$this->table_agency()." AS a 
                ON a.agency_id = t.agency_id $cond
                    
            LEFT JOIN ( 
                    SELECT h2.tour_id, SUM(h2.rating_index) AS view_count  
                    FROM ".$this->table_hits()." AS h2
                    JOIN ".$this->table_tour()." AS t2
                    ON t2.tour_id = h2.tour_id AND h2.types = 1 
                    GROUP BY h2.tour_id
            ) AS viewed ON t.tour_id = viewed.tour_id

            LEFT JOIN ( 
                    SELECT h3.tour_id, SUM(h3.rating_index) AS call_count 
                    FROM ".$this->table_hits()." AS h3
                    JOIN ".$this->table_tour()." AS t3
                    ON t3.tour_id = h3.tour_id AND h3.types = 4
                    GROUP BY h3.tour_id
            ) AS called ON t.tour_id = called.tour_id

            LEFT JOIN ( 
                    SELECT h4.tour_id, SUM(h4.rating_index) AS phone_count 
                    FROM ".$this->table_hits()." AS h4
                    JOIN ".$this->table_tour()." AS t4
                    ON t4.tour_id = h4.tour_id AND h4.types = 5 
                    GROUP BY h4.tour_id
            ) AS phoned ON t.tour_id = phoned.tour_id

            GROUP BY (t.tour_id)
            $order_by $limit";
                    
        
        return $this->db->query($sql)->result_array(); 
        
        
    }
    
    function countItems($cond=''){
        
        $sql = "SELECT t.tour_id FROM {$this->table_tour()} AS t "
        . " JOIN {$this->table_agency()} AS a"
            . " ON a.agency_id = t.agency_id  $cond "
        . " LEFT JOIN {$this->table_call_me_back()} AS c "
            . " ON t.tour_id = c.tour_id ";
        
        return $this->db->query($sql)->num_rows();  
    }
    
    
    function insertTour($tour_data='',$cover=''){
        $this->db->trans_begin(); 
        
        $tour_id = $tour_data['tour_id'];
        
        if(empty($tour_id)){
            $this->db->insert($this->table_tour(), $tour_data);
            $tour_id = $this->db->insert_id(); 
            $cover['object_id'] = $tour_id; 
            $this->db->insert($this->table_images(), $cover); 
            // update field
            $sku = $this->config->item('tour_sku').'-'.$tour_id;
            $this->db->update($this->table_tour(),array('tour_sku'=>$sku),array('tour_id'=>$tour_id) );
        } else {
            $this->db->update($this->table_tour(), $tour_data, array('tour_id'=>$tour_id));
            $this->db->update($this->table_images(), $cover,array('image_id' => $cover['image_id']));
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $tour_id ; 
        }    
    }
    
    function insertTourStep2($tour,$starting='',$transport='', $dayofweek=''){
        $this->db->trans_begin(); 
        $tour_id = $starting['tour_id'];
        $starting_date_id = $starting['starting_date_id'];
        $transport_id = $transport['id'];
        $day_id       = $dayofweek['id'];
        
        $this->db->update($this->table_tour(), $tour,array('tour_id' => $tour_id));
        
        if(empty($starting_date_id)){
            $this->db->insert($this->table_tour_starting_date(), $starting);
            $this->db->insert($this->table_tour_transport(), $transport);
            $starting_date_id = $this->db->insert_id();
            $dayofweek['starting_date_id'] = $starting_date_id;
            $this->db->insert($this->table_tour_dayofweek(), $dayofweek);
        } else {
            $this->db->update($this->table_tour_starting_date(), $starting, array('starting_date_id'=>$starting_date_id)); 
             $this->db->update($this->table_tour_transport(), $transport, array('id'=>$transport_id));
            $this->db->update($this->table_tour_dayofweek(), $dayofweek, array('id' => $day_id));  
            
        } 
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $tour_id ; 
        } 
        
        
    }
    
    function insertTourStep3($data='', $tour_id=''){
        if(!$data) return ; 
        $this->db->trans_begin(); 
        $tt_image = sizeof($data['image_id']);
        $tt_des = sizeof($data['description']);
        $total = ($tt_image > $tt_des) ? $tt_image : $tt_des; 
        
        for($i=0; $i < $total ; $i++){
            $images = array(
                'object_id' => $tour_id, 
                'description'=> addslashes($data['description'][$i]),
                'image_id'   => $data['image_id'][$i],
            ); 
            $image_id = $data['image_id'][$i];
//            if(empty($image_id)){
//                $this->db->insert($this->table_images(), $images); 
//            } else {
                $this->db->update($this->table_images(), $images, array('image_id' => $image_id));
                //echo $this->db->last_query(), '<br/>'; 
//            } 
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $tour_id ; 
        } 
        
    }
    
    function insertTourStep4($data,$tour_id){
        if(!$data) return ; 
        $this->db->trans_begin(); 
        $tt_image = sizeof($data['address']);
        $total = $tt_image; 
        
        for($i=0; $i < $total ; $i++){
            $point = array(
                'tour_id'    => $tour_id, 
                'address'    => $data['address'][$i],
                'latitude'   => $data['latitude'][$i],
                'longtitude' => $data['longtitude'][$i], 
                'pickup_id'  => $data['pickup_id'][$i],
            ); 
            
            $pickup_id = $data['pickup_id'][$i];
            
            if(empty($pickup_id)){
                $this->db->insert($this->table_tour_pickup_points(), $point); 
            } else {
                $this->db->update($this->table_tour_pickup_points(), $point, array('pickup_id' =>$pickup_id)); 
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
    
    function insertTourStep5($data,$tour_id){
        if(!$data) return ; 
        $this->db->trans_begin(); 
        $tt_image = sizeof($data['name']);
        $total = $tt_image;
        
        for($i=0; $i < $total ; $i++){
            $hotel = array(
                'tour_id'    => $tour_id,
                'name'       => $data['name'][$i],
                'address'    => $data['address'][$i],
                'stars'      => $data['stars'][$i],
                'latitude'   => $data['latitude'][$i],
                'longtitude' => $data['longtitude'][$i],  
                'hotel_id'   => $data['hotel_id'][$i],  
            ); 
            $hotel_id = $data['hotel_id'][$i]; 
            if(empty($hotel_id)){
                $this->db->insert($this->table_tour_hotel(), $hotel); 
            } else {
                $this->db->update($this->table_tour_hotel(), $hotel, array('hotel_id'=>$hotel_id)); 
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
    
    function insertTourStep6($data,$tour_id){
        if(!$data) return ; 
        $this->db->trans_begin(); 
        $id = $data['id'];
        
        if(empty($id)){
            $this->db->insert($this->table_tour_services(), $data); 
        } else {
            $this->db->update($this->table_tour_services(), $data, array('id'=>$id));
        } 
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $tour_id ; 
        }
    }
    
    function insertTourStep7($data='',$tour_id=''){
        $this->db->trans_begin(); 
        
        $day_id = $data['day_id']; 
        
        if(empty($day_id) && !empty($tour_id)){
            $this->db->insert($this->table_tour_schedule_day(),$data);
            $last_id = $this->db->insert_id();
            $day_image = array(
                'day_id'  => $last_id,
            ); 
            $this->db->update($this->table_images(),$day_image,array('day_id'=>0, 'object_id' => $tour_id));
        } else {
            $this->db->update($this->table_tour_schedule_day(), $data, array('day_id'=>$day_id) );
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $tour_id ; 
        }
    }
    
    function  insertTourStep8($data_info='', $data_tour='', $tour_id ){
        $this->db->trans_begin(); 
        $id = $data_info['id']; 
        
        if(empty($id)){
            $this->db->insert($this->table_tour_moreinfo(), $data_info);
            $this->db->update($this->table_tour(), $data_tour, array('tour_id'=>$tour_id)); 
        } else {
            $this->db->update($this->table_tour_moreinfo(), $data_info, array('id'=>$id));
            $this->db->update($this->table_tour(), $data_tour, array('tour_id'=>$tour_id)); 
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return TRUE ; 
        }
    }
    
    function getInfoTour(){
        if(!$this->tour_id) return ; 
        $sql = "SELECT t.*, im.image_id, im.object_id, im.path_image "
            . " FROM {$this->table_tour()} AS t  "
            . " JOIN {$this->table_images()} AS im "
                . " ON t.tour_id = im.object_id AND t.tour_id = {$this->tour_id} AND im.image_type = 'tc' ";
        return $this->db->query($sql)->row_array(); 
        
    }
    
    function getInfoStep2(){
        if(!$this->tour_id) return ; 
        $sql = " SELECT t.short_description, t.tour_location_id, ts.*,   tr.* FROM {$this->table_tour()} AS t 
        JOIN 
        (
            SELECT s.*, d.starting_date_id AS d_id, d.id AS day_id, d.has_monday, d.has_tuesday, d.has_wednesday, d.has_thursday, d.has_friday, d.has_saturday, d.has_sunday  FROM  {$this->table_tour_starting_date()} AS s 
            LEFT JOIN {$this->table_tour_dayofweek()} AS d 
                    ON  d.starting_date_id = s.starting_date_id
        ) AS ts 
                ON ts.tour_id = t.tour_id 
        JOIN  {$this->table_tour_transport()} AS tr 
            ON tr.tour_id = t.tour_id AND t.tour_id = $this->tour_id"; 
            
        return $this->db->query($sql)->row_array();    
            
    }
    
    function getInfoStep3(){
        if(!$this->tour_id) return ; 
        $query = $this->db->get_where($this->table_images(), array('object_id'=>$this->tour_id, 'image_type' => 't'));
        return $query->result_array(); 
        
    }
    
    function getInfoStep4(){
        if(!$this->tour_id) return ; 
        $query = $this->db->get_where($this->table_tour_pickup_points(), array('tour_id'=>$this->tour_id));
        return $query->result_array(); 
    }
    
    function getInfoStep5(){
        if(!$this->tour_id) return ; 
        $query = $this->db->get_where($this->table_tour_hotel(), array('tour_id'=>$this->tour_id));
        return $query->result_array(); 
    }
    
    function getInfoStep6(){
        if(!$this->tour_id) return ; 
        $query = $this->db->get_where($this->table_tour_services(), array('tour_id'=>$this->tour_id));
        return $query->row_array(); 
    }
    
    function getScheduleDays($tour_id) {
        $sql = "SELECT * FROM tour_schedule_day 
            WHERE tour_id = $tour_id ORDER BY day_id ASC";
        
        return $arr = $this->db->query($sql)->result('array');
        
        /*
        $tmp = '';
        foreach ($arr as $vl) {
            $tmp[$vl['sub_day']] = $vl;
        }
        
        return $tmp;
        */
    }
    
    function getInfoStep8(){
        if(!$this->tour_id) return ; 
        $query = $this->db->get_where($this->table_tour_moreinfo(), array('tour_id'=>$this->tour_id));
        return $query->row_array(); 
    }
    
    function countScheduleDays($tour_id=''){
        $this->db->where('tour_id', $tour_id);
        return $this->db->count_all_results($this->table_tour_schedule_day());
    }
    
    function deleteScheduleDay($day_id=''){
       
        $this->db->delete($this->table_tour_schedule_day(), array('day_id' => $day_id));
        return TRUE; 
    }
    
     function checkSlugExist($slug){
        
        $this->db->where('slug',$slug); 
        $query = $this->db->get($this->table_tour());
        //return $this->db->last_query();die;  
        if($query->num_rows() > 0){
            return FALSE;
        } else {
            return TRUE; 
        }
    }
    
    function updateByFields($params) {
        if($this->tour_id == '') return;
        return $this->db->update($this->table_tour(),$params, array('tour_id'=>$this->tour_id));
        
    }
    
    function getListImages(){
        
        if ($this->tour_id == 'path_image') return; 
        $this->db->select('path_image'); 
        $query = $this->db->get_where($this->table_images(), array('object_id' => $this->tour_id));
        return $query->result_array(); 
        
    }
    
    function getInfoStarting(){
        if ($this->tour_id == '') return; 
        $query = $this->db->get_where($this->table_tour_starting_date(), array('tour_id'=>$this->tour_id)); 
        return $query->row_array(); 
        
    }
    
    function removeItem(){
        if ($this->tour_id == '') return ;
        $this->db->trans_begin(); 
        
        $listImages = $this->getListImages();
        
        foreach($listImages as $image ){
            @unlink($this->_pathThumb .'/'.$image['path_image']);
        }
        
        $starting = $this->getInfoStarting(); 
        $this->db->delete($this->table_tour(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_hotel(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_images(), array('object_id' => $this->tour_id));
        $this->db->delete($this->table_tour_starting_date(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_dayofweek(), array('starting_date_id' => $starting['starting_date_id'])); 
        $this->db->delete($this->table_tour_pickup_points(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_hotel(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_services(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_transport(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_schedule_day(), array('tour_id' => $this->tour_id));
        $this->db->delete($this->table_tour_moreinfo(), array('tour_id' => $this->tour_id));
        $sql = "DELETE FROM {$this->table_tour_suggestion()} WHERE tour_id = $this->tour_id "; 
        $this->db->query($sql); 
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return TRUE ; 
        } 
        
            
    }
    
    function removeField($table, $where){
        return $this->db->delete($table, $where);
        //echo $this->db->last_query(); 
    }
    
    
    function getTourCat($level = 0){
        
        $sql = "SELECT tcd.cat_name, tcd.tour_cat_id FROM {$this->table_tour_category()} AS tc "
            . " JOIN {$this->table_tour_category_desc()} AS tcd "
                . " ON tc.tour_cat_id = tcd.tour_cat_id " ;
        if($level != 0 ) $sql .= " AND tc.level = $level ";
        return $this->db->query($sql)->result_array(); 
    }
    
    /**
     * get infor image by id
     */
    function getInfoImageById($image_id){
        $query = $this->db->get_where($this->table_images(), array('image_id' => $image_id)); 
        return $query->row_array(); 
        
    }
    
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
    
    function removeImage($image_id){
        return $this->db->delete($this->table_images(), array('image_id' => $image_id)); 
    }
    
    function getListTour($cond){
        $sql = "SELECT a.email, a.phone, a.agency_name, t.tour_sku, t.title FROM {$this->table_tour()} t "
            . " JOIN {$this->table_agency()} a "
                . " ON a.agency_id = t.agency_id $cond ";
        return $this->db->query($sql)->result_array(); 
        
    }
    
    
    
    
    
  
    
    
}