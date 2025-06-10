<?php

class Sortagency_library {

    var $CI = ''; 
    
    
    function __construct()
    {
        $this->CI = & get_instance();
    }
 
    function mySort($url_params='') {
        
        $arr = array(
            'name_desc' => ' ORDER BY a.agency_name DESC',
            'name_asc'  => ' ORDER BY a.agency_name ASC',
            
            'id_desc'   => ' ORDER BY a.agency_id DESC',
            'id_asc'    => ' ORDER BY a.agency_id ASC',
            
            'date_desc'   => ' ORDER BY tp.expired_date DESC',
            'date_asc'    => ' ORDER BY tp.expired_date ASC',
            
            'num_desc'  => ' ORDER BY t.total DESC', 
            'num_asc'   => ' ORDER BY t.total ASC',
            
            'tax_desc'  => ' ORDER BY a.tax_number DESC ',
            'tax_asc'   => ' ORDER BY a.tax_number ASC ',
            
            
        );
        if($url_params != '') return $arr[$url_params];
        
    }
    
    
    
    function tourSort($url_params=''){
        $arr = array(
            'name_desc' => ' ORDER BY a.agency_name DESC',
            'name_asc'  => ' ORDER BY a.agency_name ASC',
            
            'title_desc' => ' ORDER BY t.title DESC',
            'title_asc'  => ' ORDER BY t.title ASC',
            
            'id_desc'   => ' ORDER BY t.tour_id DESC',
            'id_asc'    => ' ORDER BY t.tour_id ASC',
            
            'date_desc'   => ' ORDER BY t.date_add DESC',
            'date_asc'    => ' ORDER BY t.date_add ASC',
            
            'view_desc'   => ' ORDER BY viewed.view_count DESC',
            'view_asc'    => ' ORDER BY viewed.view_count ASC',
            
            'phone_desc'   => ' ORDER BY phoned.phone_count DESC',
            'phone_asc'    => ' ORDER BY phoned.phone_count ASC',
            
            'call_desc'   => ' ORDER BY called.call_count DESC',
            'call_asc'    => ' ORDER BY called.call_count ASC',
            
            
        ); 
        
        if($url_params != '') return $arr[$url_params];
    }
    
    
    
}

