<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 3 Aug 2022
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 23 Aug 2020
 */
class Portfolio extends FRONT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('portfolio_model');
        $this->load->model('blog_model');
    }

    /**
     * Page portfolio detail item
     * @param $slug string
     */
    function index($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // $id = $this->extract_blog_id($slug);

        if (!$slug) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get data portfolio detail, check exits from database
        $conPortfolio = " slug = '$slug' ";
        $portfolio = $this->portfolio_model->getPortfolioBy($conPortfolio);
        if (!$portfolio) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $portfolio['blog_id'];
        $portfolio['year'] = date('Y', strtotime($portfolio['portfolio_year']));
        $this->_data['portfolio'] = $portfolio;

        $this->_data['gallery'] = $this->portfolio_model->getGallery($id);
        $category_id = $portfolio['category_id'];
        $location_id = $portfolio['portfolio_category_id'];

        /* category */
        $conPortfolioByCategory = " WHERE post_cat_id = '$category_id' ";
        $category = $this->main_model->menuCatBlogs($conPortfolioByCategory);
        $this->_data['category'] = $category[0];

        /* location */
        $conPortfolioByLocation = " WHERE post_cat_id = '$location_id' ";
        $location = $this->main_model->menuCatBlogs($conPortfolioByLocation);
        $this->_data['location'] = $location[0];

        // Get portfolio related
        $conPortfolioRelated = " category_id = '$category_id' and blog_id <> $id "; // and portfolio_category_id = '$location_id'
        $this->_data['portfolioRelated'] = $this->portfolio_model->getPortfolioBasic($conPortfolioRelated,
            'LIMIT 0,' . $this->lable['per_item_portfolio_related'],
            'ORDER BY date_add DESC');

        $this->main_model->updateHit($id);

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('du-an').'"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$portfolio['title'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $seo_img = ($portfolio['path_image'] == '') ? $this->lable['no_image_portfolio'] : $this->link_upload.'/'.$portfolio['path_image'];

        $this->_data['seo'] = array(
            'seo_title' => $portfolio['seo_title'],
            'seo_description' => $portfolio['seo_description'],
            'seo_image' => $seo_img
        );

        $this->_data['seo_image_page'] = $seo_img;

        // $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "portfolio");

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    function redirect_old($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // $id = $this->extract_blog_id($slug);

        if (!$slug) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get data portfolio detail, check exits from database
        $conPortfolio = " slug = '$slug' ";
        $portfolio = $this->portfolio_model->getPortfolioBy($conPortfolio);
        if (!$portfolio) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $cat_slug = $portfolio['cat_slug'];
        $slug = $portfolio['slug'];

        if($cat_slug && $slug){
            redirect(base_url("$cat_slug/$slug"));
        } else {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $portfolio['blog_id'];
        $portfolio['year'] = date('Y', strtotime($portfolio['portfolio_year']));
        $this->_data['portfolio'] = $portfolio;

        $this->_data['gallery'] = $this->portfolio_model->getGallery($id);
        $category_id = $portfolio['category_id'];
        $location_id = $portfolio['portfolio_category_id'];

        /* category */
        $conPortfolioByCategory = " WHERE post_cat_id = '$category_id' ";
        $category = $this->main_model->menuCatBlogs($conPortfolioByCategory);
        $this->_data['category'] = $category[0];

        /* location */
        $conPortfolioByLocation = " WHERE post_cat_id = '$location_id' ";
        $location = $this->main_model->menuCatBlogs($conPortfolioByLocation);
        $this->_data['location'] = $location[0];

        // Get portfolio related
        $conPortfolioRelated = " category_id = '$category_id' and blog_id <> $id "; // and portfolio_category_id = '$location_id'
        $this->_data['portfolioRelated'] = $this->portfolio_model->getPortfolioBasic($conPortfolioRelated,
            'LIMIT 0,' . $this->lable['per_item_portfolio_related'],
            'ORDER BY date_add DESC');

        $this->main_model->updateHit($id);

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('du-an').'"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$portfolio['title'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $seo_img = ($portfolio['path_image'] == '') ? $this->lable['no_image_portfolio'] : $this->link_upload.'/'.$portfolio['path_image'];

        $this->_data['seo'] = array(
            'seo_title' => $portfolio['seo_title'],
            'seo_description' => $portfolio['seo_description'],
            'seo_image' => $seo_img
        );

        $this->_data['seo_image_page'] = $seo_img;

        // $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "portfolio");

        $this->parser->parse($this->control ."/index.tpl", $this->_data);
    }

    /**
     * Page portfolio by category list item
     * @param $slug string
     * @return mixed
     */
    function category($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        /* Get category by cat slug, check category exist from database */
        $condCategory = " WHERE cat_slug = '$slug' ";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, cat_icon, cat_note, seo_title, seo_description, parents';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory);
        if (count($category) == 0) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $category_first = $category[0];

        /*
        Get portfolio news by category slug, check news exist from database
        // AND content IS NOT NULL AND content != ''
        */
        if ($category_first['parents'] == PARENT_CAT_PORTFOLIO) {
            $conPortfolio = " WHERE category_id = '" . $category_first['post_cat_id'] . "' ";
        } elseif ( $category_first['parents'] == PARENT_CAT_PORTFOLIO_POS) {
            $conPortfolio = " WHERE portfolio_category_id = '" .$category_first['post_cat_id'] . "' ";
        }

        $totalItems = $this->portfolio_model->counterPortfolio($conPortfolio);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_portfolio'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['portfolio'] = $this->portfolio_model->getPortfolioPagination($conPortfolio, $perPage, $start);
        }

        $this->_data['category'] = $category_first;

        $seo_title =  stripslashes($category_first['seo_title']);
        $seo_description=  stripslashes($category_first['seo_description']);
        $cat_icon = $category_first['cat_icon'];

        if($curPage > 1) {
            $seo_title .= " - Trang $curPage";
            $seo_description .= " - Trang $curPage";
        }

        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_image' => ($cat_icon != '') ? $this->link_upload.'/'.$cat_icon : $this->_data['seo_image_page']
        );

        $cat_name = $category[0]['cat_name'];

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('du-an').'"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$cat_name.'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "portfolio");

        $this->parser->parse( $this->control ."/category.tpl", $this->_data);
    }

    /**
     * Page portfolio list item
     */
    function portfolio()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $conPortfolio = ""; /* AND content IS NOT NULL AND content != ''  */
        $totalItems = $this->portfolio_model->counterPortfolio($conPortfolio);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_portfolio'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['portfolio'] = $this->portfolio_model->getPortfolioPagination($conPortfolio, $perPage, $start);
        }

        $seo_title = $this->lable['seo_title_portfolio'];
        $seo_desc = $this->lable['seo_description_portfolio'];
        if($curPage > 1) {
            $seo_title .= " - ".$this->lable['page']." ".$curPage;
            $seo_desc .= " - ".$this->lable['page']." ".$curPage;
        }
        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_desc,
            'seo_image' => $this->_data['seo_image_page']
        );

        // $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "portfolio");

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span><meta itemprop="position" content="2" /></li>';

        $this->parser->parse($this->control ."/portfolio.tpl", $this->_data);
    }

    /**
     * @param $year
     */
    function byYear($year)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $date = DateTime::createFromFormat("Y-m-d", $this->_data['menu_year_portfolio'][4]['portfolio_year']);

        $years = '';
        /* Check year from key four: AND content IS NOT NULL AND content != ''  */
        if ($date->format('Y') == $year) {
            $conPortfolio = " WHERE year(portfolio_year) <= '$year' ";

            $tt_y = sizeof($this->_data['menu_year_portfolio']);
            $yy = date('Y', strtotime($this->_data['menu_year_portfolio'][$tt_y-1]['portfolio_year']));
            $years = "$yy - $year";

        } else {
            $conPortfolio = " WHERE year(portfolio_year) = '$year' ";
        }

        $totalItems = $this->portfolio_model->counterPortfolio($conPortfolio);
        $this->_data['totalItems'] = $totalItems;

        /*
        $slugPortfolio = convertSlugByLang(PORTFOLIO_SLUG);
        */

        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_portfolio'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['portfolio'] = $this->portfolio_model->getPortfolioPagination($conPortfolio, $perPage, $start);
        }

        $this->_data['year'] = $year;
        $this->_data['years'] = $years;

        $year = ($years != '') ? $years : $year;

        $seo_page = '';
        if($curPage > 1) {
            $seo_page = " Trang $curPage";
        }

        $this->_data['seo'] = array(
            'seo_title' => $this->lable['seo_title_portfolio'] . ' - '.$this->lable['year'].' '.$year.$seo_page,
            'seo_description' => $this->lable['seo_description_portfolio'] . ' - '.$this->lable['year'].' '.$year.$seo_page,
            'seo_image' => $this->_data['seo_image_page']
        );

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('du-an').'"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$year.'</span>
            <meta itemprop="position" content="2" />
        </li>';

        // $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "portfolio");

        $this->parser->parse($this->control . "/year.tpl", $this->_data);
    }

    /**
     * TESTIMONIAL
     * @return mixed
     */
    function testimonial()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_cat_id = PARENT_CAT_TESTIMONIAL;
        // Get category by cat slug, check category exist from database
        $condCategory = " WHERE post_cat_id = $post_cat_id ";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);

        if (count($category) == 0) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $post_cat_id = $category['post_cat_id'];

        $this->load->library('pagination_blog');
        $perPage = $this->lable['per_item_tintuc'];

        $baseUrl = current_url();
        $uriSegment = 4;
        $curPage = 0;
        $conNews = " post_type = '".POST_TYPE_TESTIMONIAL."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterTestimonial($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getTestimonial($conNews, $perPage, $start);

            if($news) {
                $hot_1 = isset($news[0]) ? $news[0] : '';
                unset($news[0]);

                $hot_2 = isset($news[1]) ? $news[1] : '';
                unset($news[1]);

                $hot_3 = isset($news[2]) ? $news[2] : '';
                unset($news[2]);
            }

            $this->_data['hot_1'] = $hot_1;
            $this->_data['hot_2'] = $hot_2;
            $this->_data['hot_3'] = $hot_3;
            $this->_data['news'] = $news;
        }

        $this->_data['category'] = $category;

        $seo_title = stripslashes($category['seo_title']);
        $seo_description = stripslashes($category['seo_description']);

        if($curPage > 1) {
            $seo_title .= " - ".$this->lable['page']." ".$curPage;
            $seo_description .= " - ".$this->lable['page']." ".$curPage;
        }

        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_image' => $this->_data['seo_image_page']
        );

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('du-an').'"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        // $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );

        $this->parser->parse( $this->control ."/testimonial.tpl", $this->_data);
    }

    /**
     * TESTIMONIAL DETAIL
     *
     * @param $slug
     * @return mixed
     */
    function testimonial_detail($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        if (!$slug) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $post_type = POST_TYPE_TESTIMONIAL;
        /* News detail */
        $cond = "WHERE a.slug = '$slug' AND a.post_type = '$post_type' ";
        $news = $this->blog_model->getTestimonialBy($cond);

        if (!$news) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $news['blog_id'];
        $post_cat_id = $news['category_id'];
        $this->_data['news'] = $news;
        $category_id = $news['category_id'];
        $per_item_news_related = $this->lable['per_item_news_related'];
        // $slugNews = convertSlugByLang(NEWS_SLUG);

        /* Related */
        $conNewsRelated = "post_type = '$post_type' and category_id = '$category_id' and blog_id <> '$id'";
        $this->_data['newsRelated'] = $this->blog_model->getTestimonial($conNewsRelated, 50, 0);

        $this->main_model->updateHit($id);

        $condCategory = " WHERE post_cat_id = $post_cat_id ";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);

        /* Breadcrumb */
        $this->_data['breadcrumb'] = '
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="'.base_url('du-an').'"><span itemprop="name">'.$this->lable['mn_portfolio'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('du-an/testimonial').'"><span itemprop="name">'.$category['cat_name'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name">'.stripslashes($news['title']).'</span>
            <meta itemprop="position" content="4" />
        </li>';

        $this->_data['seo'] = array(
            'seo_title' => stripslashes($news['seo_title']),
            'seo_description' => stripslashes($news['seo_description']),
            'seo_image' => ($news['path_image'] != '') ? $this->link_upload.'/'.$news['path_image'] : $this->_data['seo_image_page'],
        );

        // $conNews = " post_type = '".POST_TYPE_TESTIMONIAL."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        // $news_related = $this->blog_model->getTestimonial($conNews, 20, 0);

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->parser->parse($this->control."/testimonial_detail.tpl", $this->_data);

    }

}