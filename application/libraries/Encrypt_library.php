<?php
/**
 * Class Encrypt Decrypt
 * Last update 8 Sep 2018
 *
 * @package AZB
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: Panpic's PHP team
 * @since 8 Sep 2018
 */

class Encrypt_library {

    var $CI = '';
    private $_custom_encrypt_key;
    private $_custom_encrypt_secret;

    function __construct(){
        $this->CI = & get_instance();
        $this->_custom_encrypt_key = $this->CI->config->item("custom_encrypt_key");
        $this->_custom_encrypt_secret = $this->CI->config->item("custom_encrypt_secret");
    }


    function encrypt_decrypt($string, $action='encrypt') {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = $this->_custom_encrypt_key;
        $secret_iv = $this->_custom_encrypt_secret;
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }


}