<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 17 Jun 2025
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 22 Aug 2020
 */
class Services extends FRONT_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('pages_model');
        $this->load->model('portfolio_model');
        $this->load->model('blog_model');

        /*
        // Get portfolio
        $condPortfolio = "  content IS NOT NULL AND content != '' ";
        $limitPortfolio = ' LIMIT 0,5 ';
        $selectPortfolio = ' title, slug, short, path_image, portfolio_utility, title_2, path_image_thumb';
        $this->_data['portfolio'] = $this->portfolio_model->getPortfolio($condPortfolio, $limitPortfolio,
            $selectPortfolio);
        */

        /* project */
        $this->load->model('index_model');
        $fields = "blog_id, category_id, date_add, slug, title, portfolio_utility, path_image, path_image_thumb";
        $this->_data['portfolioRelated'] = $this->index_model->getHomePortfolio("", $fields);

        $base_tlp_front = $this->_data['base_tlp_front'];
        $this->_data['header_script'] = '<link rel="stylesheet" href="'.$base_tlp_front.'/css/toc.min.css?ver=2.9">
                    <script src="'.$base_tlp_front.'/js/toc_collapsed.min.js?ver=2.9"></script>';
    }

    /**
     * Service detail
     * @param $slug
     * @return mixed
     */
    function index($slug, $cat_id)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;

        $this->main_model->updateHit($id);

        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    /**
     * Page service list
     */
    function item()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get service
        $conService = " WHERE post_type = '" . POST_TYPE_SERVICES . "' AND content IS NOT NULL AND content != '' ";

        $this->_data['service'] = $this->blog_model->getBlogServicesItems($conService, $field = "slug, blog_id, title, short, content, category_id ");
        // pre( $this->_data['service'] );

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $this->lable['seo_title_services'],
            'seo_description' => $this->lable['seo_description_services'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['menu_services'] . '</span><meta itemprop="position" content="2" /></li>';

        $this->parser->parse($this->control ."/item.tpl", $this->_data);
    }

    function thietkewebsite()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 34;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "a.seo_title, a.seo_description, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
                            
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/thietkewebsite.tpl", $this->_data);
    }

    function vietphanmem()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 35;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */

        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';


        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function webmaster()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 36;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */

        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function graphicdesign()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 37;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */

        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function mobileapp()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 15;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */
        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function hosting()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 27;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */

        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function domain()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 7;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */
        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function webseo()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 38;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */
        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function adv()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $cat_id = 39;

        if (!$cat_id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* Get data news detail, check exits from database */
        $post_type = POST_TYPE_SERVICES;
        $conService = "JOIN view_category AS c
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND c.post_cat_id = $cat_id ";

        $service = $this->blog_model->getBlogServicesByQuery($conService);

        if (!$service) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $service['blog_id'];
        $this->_data['service'] = $service;
        $this->main_model->updateHit($id);

        $field = "c.cat_slug, c.post_cat_id, c.cat_name, a.short, a.path_image ";
        $conds = "JOIN view_category AS c 
                        ON a.category_id = c.post_cat_id 
                            AND a.post_type = '$post_type'
                            AND a.blog_id <> $id";
        $services = $this->blog_model->getBlogServicesItems($conds, $field);
        $this->_data['services'] = $services;

        /*
        $this->_data['breadcrumb'] = '
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$service['title'].'</span><meta itemprop="position" content="2" /></li>';
        */
        $this->_data['breadcrumb'] = '<li class="active"><span>'.$service['title'].'</span></li>';

        $this->_data['seo'] = array(
            'seo_title' => $service['seo_title'],
            'seo_description' => $service['seo_description'],
            'seo_image' => $this->link_upload. '/'. $service['path_image']
        );

        $this->parser->parse($this->control."/index.tpl", $this->_data);
    }

}