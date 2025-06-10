<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty destination_ids
 * bang.webdeveloper@gmail.com
 *
 * @param string $strIDs 6,8
 * @return int $tour_destination_id
 */
function smarty_modifier_destination_ids($strIDs, $tour_destination_id){ 
    
    if($strIDs == '') return false;
    $test = explode(',', $strIDs);
    
    if ( in_array($tour_destination_id, $test) ) {
        return true;
    }
    
    return false; 
}

?>