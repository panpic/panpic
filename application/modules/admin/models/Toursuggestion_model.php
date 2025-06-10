<?php
/**
* Model Backend Toursuggestion
* Last update 27 Jan 2017
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: PHP Developer
* @since 27 Jan 2017
*/

class Toursuggestion_model extends MY_Model
{
    
    private $_tour_suggestion = 'tour_suggestion';
    private $_tour = 'tour';
    private $_agency = 'agency'; 
    private $_package = 'package'; 
    private $_package_agency = 'package_agency';


    public $tour_id;
    
    
    function getKeyString() { return "c.tour_id = $this->tour_id"; }	
    
    
    /**
     * 
     * @param $tour_id int
     * @return array
     */
    function getItemById(){
        if($this->tour_id == '') return;
        
         $sql = "SELECT a.* FROM $this->_tour_suggestion AS c
                JOIN $this->_tour AS a ON c.tour_id = a.tour_id AND ".$this->getKeyString();
        return $this->db->query($sql)->row_array();
    }
    
    
    /**
     * insert Replace 
     * 
     * @param array $params
     * @return bool
     */
    function replaceInsert($params){
        $sql = "REPLACE tour_suggestion (tour_id, date_add) VALUES (".$params['tour_id'].", '".$params['date_add']."')";
        return $this->db->query($sql);
    }
    
    
    function insertItem($params){
        $this->db->trans_begin();
        
            $this->db->insert($this->_tour_suggestion, $params);
            $primary = $this->db->insert_id();
            
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $primary; 
        }
    }
    
    
    function deleteItem($where) {
        if(!$where) return;
        
        $this->db->where($where); 
        return $this->db->delete($this->_tour_suggestion);
    }
    
    
    function countItems($cond) {
        $sql = "SELECT a.* FROM $this->_tour_suggestion AS c
                JOIN $this->_tour AS a ON c.tour_id = a.tour_id $cond";
        
        return $this->db->query($sql)->num_rows(); 
    }
    
    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT a.* FROM $this->_tour_suggestion AS c
                JOIN $this->_tour AS a ON c.tour_id = a.tour_id $cond ORDER BY c.date_add DESC $limit";
        
        return $this->db->query($sql)->result('array');
    }
    
    /*
    function searchTour($cond) {
        $sql = "SELECT tour_id, title FROM tour $cond AND avail = 1"; //WHERE title LIKE '%đa lat%'
        return $this->db->query($sql)->result('array');
    }
     * 
     */
    
    function searchTour($cond=''){
        $sql = "SELECT t.tour_id , t.title
                FROM  $this->_agency AS  a 
                JOIN $this->_tour AS t
                    ON a.agency_id = t.agency_id $cond AND t.avail = 1 
                        AND NOT EXISTS (SELECT *
                            FROM  $this->_tour_suggestion AS ts 
                            WHERE  t.tour_id = ts.tour_id ) 
                JOIN 
                    (
                         SELECT p.package_id, p.package_type, p.package_name, pa.agency_id,pa.expired_date
                         FROM $this->_package AS p
                         JOIN $this->_package_agency AS pa
                             ON p.package_id = pa.package_id AND p.package_type IN(2,3) AND DATEDIFF(pa.expired_date, now()) >= 0
                     ) AS tp ON a.agency_id = tp.agency_id " ;
        return $this->db->query($sql)->result_array(); 
    }
    
    
}