<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clas custom Validate
 * Last update 12 Sep 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: PHP Developer team
 * @since 12 Sep 2018
 */

class Myform_validation extends CI_Form_validation {

    protected $CI;

    function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
    }


    function check_japan_space($str) {
        if( empty(trim(mb_convert_kana($str, "s", 'UTF-8'))) ){
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function check_min_string_japan($str) {
        if(mb_strwidth($str,'UTF-8')/2 <= MAX_STRING_JAPAN) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function check_email_format($email) {
        $status = filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
        if(! $status) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function check_empty_string($str) {
        if(! $str) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function check_is_object($obj){
        if(is_object($obj)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


}