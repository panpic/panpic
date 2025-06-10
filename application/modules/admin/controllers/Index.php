<?php
/**
 * Controllers Backend
 * Last update 24 August 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 22 August 2018
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Index extends MY_Controller{



	public function __construct(){
        parent::__construct();
        $this->load->model('statistics_model');
    }

	

	function index(){ 
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        $this->_data['task'] = $this->lable['Dashboard'];
        $this->_data['breadcrumb'] = 'Dashboard';
        $this->_data['alert'] = '';

        $this->parser->parse("index/index.tpl", $this->_data);
	}



	function notpermission() {
		
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->_data['task'] = $this->lable['add'];
        $this->_data['breadcrumb'] = 'Dashboard';
        $this->_data['alert'] = '';

        $this->parser->parse("index/permission.tpl", $this->_data);
	}




	

	

	





}