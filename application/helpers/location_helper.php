<?php
//tao ra cac link trong admin
function geo_location($obj){
    
    $geo = $obj['geoplugin_city'];
    
    if(!$obj) return 2;
    
    $location = array(
        'Ho Chi Minh City'  => 2,
        'Hanoi'             => 3
    );
    
    if(!empty($location[$geo])) {
        return $location[$geo];
    } else{
        return 4;
    }
    
    
}
