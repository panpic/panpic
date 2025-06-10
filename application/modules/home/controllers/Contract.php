<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 8 Jul 2020
 *
 * @package Frontend Blog
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 14 Feb 2020
 */
class Contract extends FRONT_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->model('video_model');
        $this->load->model('portfolio_model');
        $this->load->model('pages_model');

        // Get portfolio
        $condPortfolio = " content IS NOT NULL AND content != '' ";
        $limitPortfolio = ' LIMIT 0,5 ';
        $selectPortfolio = ' title, slug, short, path_image, portfolio_utility, title_2, path_image_thumb';
        $this->_data['portfolio'] = $this->portfolio_model->getPortfolio($condPortfolio, $limitPortfolio, $selectPortfolio);
    }

    /**
     * @param $slug
     * @return mixed
     */
    function index($slug = '')
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        /*
        $slug = (!$slug) ? BLOG_CULTURE_ID : $slug;
        // Get data page detail, check exits from database
        if ($slug == BLOG_CULTURE_ID) {
            $conPages = "page_id = '$slug' ";
        } else {
            $conPages = "page_slug = '$slug' ";
        }
        */

        $page_id = 12;
        $conPages = "page_id = '$page_id' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;
        $slugNews = convertSlugByLang(CULTURE_SLUG);

        // Set breadcrumb
        if ($slug == BLOG_CULTURE_ID) {
            $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.base_url($slugNews).'"><span itemprop="name">'.$this->lable['company_culture'].'</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['breadcrumb_lb_culture_about_us'] . '</span><meta itemprop="position" content="3" /></li>';
        } else {
            $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this->lable['breadcrumb_lb_contract'] . '</span><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="3" /></li>';
        }

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse("page/fullscreen.tpl", $this->_data);
    }

    /**
     * @param $slug
     * @return mixed
     */
    function partner($slug = '')
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        /*
        $slug = (!$slug) ? BLOG_CULTURE_ID : $slug;
        // Get data page detail, check exits from database
        if ($slug == BLOG_CULTURE_ID) {
            $conPages = "page_id = '$slug' ";
        } else {
            $conPages = "page_slug = '$slug' ";
        }
        */

        $page_id = 13;
        $conPages = " page_id = '$page_id' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;
        $slugNews = convertSlugByLang(CULTURE_SLUG);

        // Set breadcrumb
        if ($slug == BLOG_CULTURE_ID) {
            $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.base_url($slugNews).'"><span itemprop="name">'.$this->lable['company_culture'].'</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['breadcrumb_lb_culture_about_us'] . '</span><meta itemprop="position" content="3" /></li>';
        } else {
            $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this->lable['breadcrumb_lb_contract'] . '</span><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="3" /></li>';
        }

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        // Get banner partner
        $this->_data['partners'] = $this->main_model->getBanners($this->langUrl, 'client', "", false);

        $this->parser->parse("about/client.tpl", $this->_data);
    }


}
