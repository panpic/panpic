<?php
/**
* Controllers Backend language
* Last update 23 August 2018
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 23 August 2018
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends MY_Controller
{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
            
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
		$keyword = $this->input->get('keyword');
		$this->dataLang = $this->lang->load('lang', $this->current_lang);
		
		$this->_data['list'] = $this->lang->language;
		$this->_data['keyword']= $keyword;
		$this->_data['langArr'] = $this->getAllLang();
		
		$this->_data['content'] = 'setup/language';
		$this->parser->parse("layout/index.tpl", $this->_data);
	}


	/**
	 * Add variable
	 */
	public function add(){
		$mess['not_error'] = '0';
		if($this->input->post()) { 
			$data = $this->input->post();
			$lang = $data['lang'];			
			$this->lang->load('lang', $lang);
			$language = $this->lang->language;
			$strLang = "<?php \n";
			$is_update = 0;
			$namekey = $data['name'];
			$value = $data['value'];
			foreach( $language as $k => $v ){
				if($namekey != $k ) {
					$is_update = 0;
					$v = stripslashes($v);
					$v = addslashes($v);
					$strLang .= '$lang[\''.$k.'\']=' . "'$v';\n";
				}else {
					$value = stripslashes($value);
					$value = addslashes($value);
					$strLang .= '$lang[\''.$k.'\']=' . "'$value';\n";
					$is_update = 1;
				}
			}
			if( $is_update == 0 ) {
				$value = stripslashes($value);
				$value = addslashes($value);
				$strLang .= '$lang[\''.$namekey.'\']=' . "'$value';\n";
			}
			
			$this->load->helper('file');
			write_file('./system/language/'.$lang.'/lang_lang.php', $strLang);
			redirect( admin_url('setup'));
		}
	}


	/**
	 * Update variable
	 */
	public function update(){
		$mess['not_error'] = '0';
		if($this->input->post()) { 
			$data = $this->input->post();						
			$objArr = explode("__", $data['obj']);
			if( count( $objArr ) > 1 && $objArr[0] != '' && $objArr[1] != '' ){
				$namekey = $objArr[0];
				$value = $data['value'];
				$lang = $objArr[1];				
					
				$this->lang->load('lang', $lang);
				$language = $this->lang->language;
				$strLang = "<?php \n";
				foreach( $language as $k => $v ){
					if($namekey != $k ) {
						$v = stripslashes($v);
						$v = addslashes($v);
						$strLang .= '$lang[\''.$k.'\']=' . "'$v';\n";
					} else {
						$value = stripslashes($value);
						$value = addslashes($value);
						$strLang .= '$lang[\''.$k.'\']=' . "'$value';\n";
					}
				}

				$this->load->helper('file');
				write_file('./system/language/'.$lang.'/lang_lang.php', $strLang);
			}
		}
		die (json_encode( $mess ));
	}
	

}