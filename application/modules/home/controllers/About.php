<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 22 May 2021
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 5 Apr 2019
 */
class About extends FRONT_Controller
{
    /**
     * About constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pages_model');
        $this->load->model('blog_model');
        $this->load->model('portfolio_model');

        /* project */
        $this->load->model('index_model');
        $fields = "blog_id, category_id, date_add, slug, title, portfolio_utility, path_image, path_image_thumb";
        $this->_data['portfolioRelated'] = $this->index_model->getHomePortfolio("", $fields);

        /* Services home */
        $this->_data['services_menu_home'] = $this->nestedpostcat_library->services_menu_home( $this->_data['menu_services'] );


        /*
        // Get portfolio
        $condPortfolio = " content IS NOT NULL AND content != '' ";
        $limitPortfolio = ' LIMIT 0,5 ';
        $selectPortfolio = ' title, slug, short, path_image, portfolio_utility, title_2, path_image_thumb';
        $this->_data['portfolio'] = $this->portfolio_model->getPortfolio($condPortfolio, $limitPortfolio, $selectPortfolio);
        */
    }

    /**
     * Page history
     * @return mixed
     */
    function history()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get data page detail, check exits from database
        $conPages = "page_id = '" . BLOG_HISTORY_ID . "' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;

        /* Get history data */
        $conHistory = "post_type = '" . POST_TYPE_HISTORY . "' ";
        $selectHistory = 'slug, title, content, path_image ';
        $this->_data['history'] = $this->blog_model->getBlogHistory($conHistory, '', 'ORDER BY portfolio_year ASC', $selectHistory);
        // pre( $this->_data['history'] );

        $page_id = $page['page_id'];
        $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "$page_id");

        /* breadcrumb */
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);
        $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.base_url($slugAboutUs).'"><span itemprop="name">'.$this->lable['menu_aboutus'].'</span></a><meta itemprop="position" content="2" /></li>
                    <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">'.$page['page_title'].'</span><meta itemprop="position" content="3" /></li>';

        /* Set seo data */
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control ."/history.tpl", $this->_data);
    }

    /**
     * Page testimonial list item
     */
    public function testimonial()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get blog testimonial, check news exist from database
        $conTestimonial = "post_type = '" . POST_TYPE_LETTERS . "' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conTestimonial);
        if ($totalItems == 0) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->load->library('pagination_blog');
        $perPage = $this->lable['per_item_testimonial'];
        $slugTestimonial = convertSlugByLang(TESTIMONIAL_SLUG);
        $baseUrl = base_url($slugTestimonial);
        $uriSegment = 4;
        $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
        $this->_data['links'] = $this->pagination->create_links();
        $curPage = $this->input->get('per_page');
        $offset = ($curPage) ? $curPage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
        $this->_data['testimonial'] = $this->blog_model->getBlog($conTestimonial, $perPage, $start);

        // Set breadcrumb
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);
        $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugAboutUs) . '"><span itemprop="name">' . $this->lable['menu_aboutus'] . '</span></a><meta itemprop="position" content="2" /></li>
                <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this->lable['letters'] . '</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $this->lable['seo_title_testimonial'],
            'seo_description' => $this->lable['seo_description_testimonial'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control . "/testimonial.tpl", $this->_data);
    }

    /**
     * Handle all page for about
     */
    public function page($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        // Get data page detail, check exits from database
        $conPages = "page_slug = '" . $slug . "' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;

        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugAboutUs) . '"><span itemprop="name">' . $this->lable['menu_aboutus'] . '</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control . "/page.tpl", $this->_data);
    }

    /**
     * Handle all page for about full screen
     */
    public function fullScreenPage($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        // Get data page detail, check exits from database
        $conPages = "page_slug = '" . $slug . "' ";
        $select = "page_id, page_slug, page_title, page_short, page_detail, seo_title, seo_description";
        $page = $this->pages_model->getPageBy($conPages, $select);

        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $this->_data['page'] = $page;
        $page_id = $page['page_id'];

        $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "$page_id");

        if($page_id == 1) {
            $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="2" /></li>';
        } else {
            $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);
            $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.base_url($slugAboutUs).'"><span itemprop="name">'.$this->lable['menu_aboutus'].'</span></a><meta itemprop="position" content="2" /></li>
                        
                    <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">'.$page['page_title'].'</span><meta itemprop="position" content="3" /></li>';
        }

        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control . "/fullscreen.tpl", $this->_data);
    }

    /**
     * Can bo chu chot
     */
    public function KeyPerson($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        // Get data page detail, check exits from database
        $conPages = "page_slug = '" . $slug . "' ";
        $select = "page_id, page_slug, page_title, page_short, page_detail, seo_title, seo_description";
        $page = $this->pages_model->getPageBy($conPages, $select);

        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $this->_data['page'] = $page;
        $page_id = $page['page_id'];

        $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "$page_id");

        if($page_id == 1) {
            $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="2" /></li>';
        } else {
            $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);
            $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.base_url($slugAboutUs).'"><span itemprop="name">'.$this->lable['menu_aboutus'].'</span></a><meta itemprop="position" content="2" /></li>
                        
                    <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">'.$page['page_title'].'</span><meta itemprop="position" content="3" /></li>';
        }

        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control ."/keyperson.tpl", $this->_data);
    }


    /**
     * Page partner
     * @param $slug
     * @return mixed
     */
    function partner($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        // Get data page detail, check exits from database
        // $conPages = "page_slug = '" . $slug . "' ";
        $conPages = " page_id = 4 ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;
        $page_id = $page['page_id'];

        // Get banner partner
        $this->_data['partners'] = $this->main_model->getBanners($this->langUrl, 'client', "", false);

        // Set breadcrumb
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);

        $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.base_url($slugAboutUs).'"><span itemprop="name">'.$this->lable['menu_aboutus'].'</span></a><meta itemprop="position" content="2" /></li>
                        
                    <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">'.$page['page_title'].'</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        // $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "$page_id");

        $this->parser->parse($this->control . "/partner.tpl", $this->_data);
    }

    /**
     * Ky thuat nganh
     */
    function technology() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get category by cat slug, check category exist from database
        $PARENT_CAT_CONSTRUCT_ENGINEERING = PARENT_CAT_CONSTRUCT_ENGINEERING;
        $condCategory = " WHERE post_cat_id = $PARENT_CAT_CONSTRUCT_ENGINEERING";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);

        /*
        if (count($category) == 0) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        */

        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);

        // Get blog news by category slug, check news exist from database
        $conNews = " post_type = '" . POST_TYPE_CONSTRUCT_ENGINEERING . "' AND content IS NOT NULL AND content != ''";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_tintuc'];
            // $slugNews = convertSlugByLang(CULTURE_SLUG);
            $baseUrl = current_url(); // base_url($slugNews . "/$slug");
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['news'] = $this->blog_model->getBlog($conNews, $perPage, $start);
        }

        // Set category data
        $this->_data['category'] = $category;

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $category['seo_title'],
            'seo_description' => $category['seo_description'],
            'seo_image' => ''
        );

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugAboutUs) . '"><span itemprop="name">' . $this->lable['menu_aboutus'] . '</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $category['cat_name'] . '</span><meta itemprop="position" content="3" /></li>';


        $this->parser->parse($this->control."/category.tpl", $this->_data);
    }

    function technologyDetail($slug, $id) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // $id = $this->extract_blog_id($slug);
        if (!$id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get data news detail, check exits from database
        $conNews = " blog_id = '$id' AND lang='$this->langUrl' ";
        $news = $this->blog_model->getBlogBy($conNews);
        if (!$news) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['news'] = $news;
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);

        $category_id = $news['category_id'];
        $condCategory = " WHERE post_cat_id = $category_id";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);

        // Get news related
        $conNewsRelated = "post_type = '".POST_TYPE_CONSTRUCT_ENGINEERING."' and category_id = '$category_id' and blog_id != '$id'";
        $this->_data['newsRelated'] = $this->blog_model->getBlogBasic($conNewsRelated, 'LIMIT 0,4',
            'ORDER BY date_add DESC');

        $this->main_model->updateHit($id);

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugAboutUs) . '"><span itemprop="name">' . $this->lable['menu_aboutus'] . '</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $category['cat_name'] . '</span><meta itemprop="position" content="3" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$news['title'].'</span><meta itemprop="position" content="3" /></li>';


        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $news['seo_title'],
            'seo_description' => $news['seo_description'],
            'seo_image' => ($news['path_image'] != '') ? $this->link_upload. '/'.$news['path_image'] : '',
        );

        $this->parser->parse($this->control."/technology_detail.tpl", $this->_data);
    }

    /**
     * Page partner
     * @param $slug
     * @return mixed
     */
    function policy($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        // Get data page detail, check exits from database
        $conPages = "page_slug = '" . $slug . "' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;
        $page_id = $page['page_id'];

        // Get banner partner
        $this->_data['partners'] = $this->main_model->getBanners($this->langUrl, 'client', "", false);

        // Set breadcrumb
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);

        $this->_data['breadcrumb'] = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">'.$page['page_title'].'</span><meta itemprop="position" content="2" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "$page_id");

        $this->parser->parse($this->control . "/policy.tpl", $this->_data);
    }

}
