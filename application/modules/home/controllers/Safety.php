<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 22 May 2021
 *
 * @package Frontend Blog
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 8 Jul 2020
 */
class Safety extends FRONT_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->model('video_model');
        $this->load->model('portfolio_model');

        // Get portfolio
        $condPortfolio = " content IS NOT NULL AND content != '' ";
        $limitPortfolio = ' LIMIT 0,5 ';
        $selectPortfolio = ' title, slug, short, path_image, path_image_thumb, blog_id';
        $this->_data['portfolio'] = $this->portfolio_model->getPortfolio($condPortfolio, $limitPortfolio, $selectPortfolio);
    }

    /**
     * Page detail
     * @param $slug
     * @return mixed
     */
    public function index($slug, $id)
    {
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

        $category_id = $news['category_id'];
        $condCategory = " WHERE AND post_cat_id = $category_id ";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);

        $slugNews = convertSlugByLang(SAFETY_SLUG_CAT);
        $parent_link = base_url($slugNews.'/'.$category['cat_slug']);

        // Get news related
        $conNewsRelated = "post_type = '" . POST_TYPE_SAFETY . "' and category_id = '$news[category_id]' and blog_id != '$news[blog_id]'";
        $this->_data['newsRelated'] = $this->blog_model->getBlogBasic($conNewsRelated, 'LIMIT 0,4',
            'ORDER BY date_add DESC');

        $this->main_model->updateHit($id);

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' .$parent_link. '"><span itemprop="name">' . $category['cat_name']. '</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . stripslashes($news['title']) . '</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $news['seo_title'],
            'seo_description' => $news['seo_description'],
            'seo_image' => ($news['path_image'] != '') ? $this->link_upload.'/'.$news['path_image'] : '',
        );

        $this->parser->parse($this->control."/index.tpl", $this->_data);
    }

    /**
     * Page culture list item
     */
    public function culture()
    {
        $this->load->model('pages_model');

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $conPages = "page_id = '" . BLOG_CULTURE_ID . "' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get blog news by category slug, check news exist from database
        $conNews = " post_type = '" . POST_TYPE_SAFETY . "' AND content IS NOT NULL AND content != ''";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_tintuc'];
            $slugNews = convertSlugByLang(CULTURE_SLUG);
            $baseUrl = base_url($slugNews);
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['news'] = $this->blog_model->getBlog($conNews, $perPage, $start);
        }

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' => $this->_data['seo_image_page']
        );

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['mn_occupational_safety'] . '</span><meta itemprop="position" content="3" /></li>';

        $this->parser->parse($this->control."/culture.tpl", $this->_data);
    }

    /**
     * Page culture by category list item
     * @param $slug
     * @return mixed
     */
    function category($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get category by cat slug, check category exist from database
        $condCategory = " WHERE cat_slug = '$slug'";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory);
        if (count($category) == 0) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get blog news by category slug, check news exist from database
        $conNews = " post_type = '" . POST_TYPE_SAFETY . "' AND category_id = '" . $category[0]['post_cat_id'] . "' AND content IS NOT NULL AND content != ''";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_tintuc'];
            $slugNews = convertSlugByLang(CULTURE_SLUG);
            $baseUrl = base_url($slugNews . "/$slug");
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['news'] = $this->blog_model->getBlog($conNews, $perPage, $start);
        }

        // Set category data
        $this->_data['category'] = $category[0];

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $this->_data['category']['seo_title'],
            'seo_description' => $this->_data['category']['seo_description'],
            'seo_image' => $this->_data['seo_image_page']
        );

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this->lable['mn_occupational_safety'] . '</span><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . stripslashes($this->_data['category']['cat_name']). '</span><meta itemprop="position" content="3" /></li>';

        $this->parser->parse($this->control."/category.tpl", $this->_data);
    }

    /**
     * @param $slug
     * @return mixed
     */
    function page($slug = '')
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->load->model('pages_model');
        $page_id = $this->page_id( end($this->uri->segment_array()) );

        /*
        $slug = (!$slug) ? BLOG_SAFETY_ID : $slug;
        // Get data page detail, check exits from database
        if ($slug == BLOG_CULTURE_ID) {
            $conPages = "page_id = '$slug' ";
        } else {
            $conPages = "page_slug = '$slug' ";
        }
        */

        $conPages = " page_id = '$page_id' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;
        $slugNews = convertSlugByLang(CULTURE_SLUG);

        // Set breadcrumb

        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this->lable['mn_occupational_safety'] . '</span><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse("page/fullscreen.tpl", $this->_data);
    }

    private function page_id($slug){
        $arr = array(
            'gioi-thieu' => BLOG_SAFETY_ID_9,
            'about-us' => BLOG_SAFETY_ID_9,
            'about-us' => BLOG_SAFETY_ID_9,
            'chinh-sach' => BLOG_SAFETY_ID_15,
            'policy' => BLOG_SAFETY_ID_15,
            'policy' => BLOG_SAFETY_ID_15,
        );
        if($slug) {
            return $arr[$slug];
        }
    }

}
