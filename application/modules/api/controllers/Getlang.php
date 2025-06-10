<?php
/**
* Controllers API language lable
* Last update 29 Jun 2019
* 
* @package backend
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 29 Jun 2019
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlang extends CI_Controller{
	
	
	public function __construct(){
		parent::__construct();
	}

	function index(){
		$default_lang = $this->config->item("default_lang");
		$lang = $this->input->get('lang');
		$currentLang = ($lang !='' ) ? $lang : $default_lang;
		$this->lang->load('lang', $currentLang);		
		echo json_encode( $this->lang->language );
	}

}