<?php
/**
 * Class Parse data content
 * Last update 6 Feb 2021
 *
 * @package AZB
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: Panpic's PHP team
 * @since 6 Feb 2021
 */

class Data_library {

    public $CI = '';

    function __construct(){
        $this->CI = & get_instance();
    }


    function edit_parse($arr) {
        $temp = array();
        if($arr) {
            foreach ($arr as $vl) {
                $temp[$vl['lang']] = $vl;
            }
        }

        return $temp;
    }


}