<?php
/**
 * Parent Frontend
 * Last update 28 Sep 2024
 *
 * @package Front
 * @copyright Panpic
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 20 Aug 2021
 */

Class FRONT_Controller extends CI_Controller
{

    public $base_url,
        $_data = array(),
        $langUrl,
        $control,
        $action,
        $path_upload,
        $link_upload,
        $lable,
        $isMobile;

    function __construct()
    {
        parent::__construct();
        $this->base_url = $this->config->item("base_url");
        $langUrl = LANG_VI;

        $this->lang->load('lang', $langUrl);
        $this->lable = $this->lang->language;
        $this->_data['lable'] = $this->lable;
        $this->langUrl = $langUrl;
        $this->_data['current_lang'] = $this->langUrl;

        $this->_data['base_url'] = $this->base_url;
        $this->_data['base_tlp_front'] = $this->config->item("base_tlp_front");

        $this->control = $this->router->class;
        $this->action = $this->router->method;
        $this->_data['control'] = $this->control;
        $this->_data['action'] = $this->action;
        $this->path_upload = $this->config->item("path_upload");
        $this->link_upload = $this->config->item("link_upload");
        $this->_data['link_upload'] = $this->link_upload;

        $this->isMobile = $this->isMobile();
        $this->_data['isMobile'] = $this->isMobile;

        $this->load->model('main_model');
        $this->load->library('nestedpostcat_library');
        // $this->main_model->emptyTable();

        $all_category = $this->main_model->menuCatBlogs(" WHERE lang='$langUrl' ");
        $categories = $this->nestedpostcat_library->groupSubMenuByParent($all_category);

        $this->_data['menu_tintuc'] = $this->nestedpostcat_library->sortCategory($categories[PARENT_CAT_BLOG]['sub']);
        $this->_data['menu_services'] = $this->nestedpostcat_library->sortCategory($categories[PARENT_CAT_SERVICES]['sub']);

        $this->_data['menu_duan'] = $categories[PARENT_CAT_PORTFOLIO]['sub'];
        $this->_data['menu_year_portfolio'] = $this->main_model->getYearPortfolio();
        $this->_data['menu_year_portfolio_count'] = count($this->_data['menu_year_portfolio']) - 1;
        $this->_data['menu_document'] = $this->nestedpostcat_library->sortCategory($categories[PARENT_CAT_DOCUMENT]['sub']);

        $this->_data['seo_image_page'] = $this->lable['page_image'];
        $this->_data['no_image_portfolio'] = $this->_data['base_tlp_front'] .'/images/thiet-ke-web-panpic.webp';
        $this->_data['no_image_history'] = $this->_data['base_tlp_front'] .'/images/thiet-ke-web-panpic.webp';
        $this->_data['no_image_news'] = $this->_data['base_tlp_front'] .'/images/thiet-ke-web-panpic.webp';

        $this->_data['current_url'] = current_url();
    }

    function isMobile(){

        $flag_mobile = INACTIVE;

        // Detect devices
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $isMobile  = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

        if ($iPad)
            $flag_mobile = DETECT_IPAD;
        else if ( $Android|| $iPod || $iPhone || $isMobile)
            $flag_mobile = DETECT_MOBILE;
        else
            $flag_mobile = DETECT_PC;

        return$flag_mobile;

        /*
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        */
    }

}