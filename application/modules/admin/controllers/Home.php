<?php
/**
* Controllers Backend login
* Last update 1 Feb 2021
* 
* @package backend
* @copyright PANPIC
* @author 
* @author position: PHP Developer
* @since 3 Dec 2020
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller{
	

	public function __construct(){
        parent::__construct();
        $this->load->model('statistics_model');
	}


	
	function index(){

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->_data['task'] = $this->lable['add'];
        $this->_data['breadcrumb'] = $this->lable['general_variable'];
        $this->_data['alert'] = '';

        // Blogs
        $blogTotal = $this->statistics_model->countPost(" WHERE post_type = 'B' ");
        $blogsActive = $this->statistics_model->countPost(" WHERE post_type = 'B' AND avail = 1 ");

        // Portfolio
        $POST_TYPE_PORTFOLIO = POST_TYPE_PORTFOLIO;
        $servicesTotal = $this->statistics_model->countPost(" WHERE post_type = '$POST_TYPE_PORTFOLIO' ");
        $servicesActive = $this->statistics_model->countPost(" WHERE post_type = '$POST_TYPE_PORTFOLIO' AND avail = 1 ");

        $POST_TYPE_DOWNLOAD = POST_TYPE_DOWNLOAD;
        $promotionTotal = $this->statistics_model->countPost(" WHERE post_type = '$POST_TYPE_DOWNLOAD' ");
        $promotionActive = $this->statistics_model->countPost(" WHERE post_type = '$POST_TYPE_DOWNLOAD' AND avail = 1 ");

        $POST_TYPE_REDCRUITMENT = POST_TYPE_REDCRUITMENT;
        $recruitementTotal = $this->statistics_model->countPost(" WHERE post_type = '$POST_TYPE_REDCRUITMENT' ");
        $recruitementActive = $this->statistics_model->countPost(" WHERE post_type = '$POST_TYPE_REDCRUITMENT' AND avail = 1 ");

        $statistics = array(
            'blogTotal'    => $blogTotal,
            'blogsActive'    => $blogsActive,
            'servicesTotal'  => $servicesTotal,
            'servicesActive' => $servicesActive,
            'promotionTotal' => $promotionTotal,
            'promotionActive' => $promotionActive,
            'recruitementTotal' => $recruitementTotal,
            'recruitementActive' => $recruitementActive,
        );

        $this->_data['statistics'] = $statistics;
        $this->parser->parse("index/index.tpl", $this->_data);
	}



}