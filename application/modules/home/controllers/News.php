<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 9 May 2023
 *
 * @package Frontend Blog
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 14 Feb 2020
 */
class News extends FRONT_Controller
{

    private $_parent_category;
    private $_post_type = POST_TYPE_BLOG;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->library('blog_lib');

        $this->_parent_category = POST_CAT_KIENTHUC;
        $this->blog_model->lang = $this->langUrl;
    }

    /**
     * Blog detail
     *
     * @param $slug
     * @return mixed
     */
    function index($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        if (!$slug) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // News detail
        $cond = "WHERE a.slug = '$slug' AND a.post_type = '$this->_post_type' ";
        $news = $this->blog_model->getBlogBy($cond);

        if (!$news) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $news['blog_id'];
        $news['content'] = $this->blog_lib->escape_code_blocks($news['content']);
        $this->_data['news'] = $news;
        // pre($news);

        $category_id = $news['category_id'];
        $per_item_news_related = ($this->isMobile == DETECT_MOBILE) ? 5 : $this->lable['per_item_news_related'];
        $slugNews = convertSlugByLang(NEWS_SLUG);

        // Related
        $conNewsRelated = " post_type = '".POST_TYPE_BLOG."' and category_id = '$category_id' and blog_id <> '$id' GROUP BY blog_id ";
        $this->_data['newsRelated'] = $this->blog_model->getBlogBasic($conNewsRelated, "LIMIT 0,$per_item_news_related",
            'ORDER BY date_add DESC');

        $this->main_model->updateHit($id);

        $this->_data['breadcrumb'] = '
        <li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="'.base_url($slugNews).'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="'.url_news_cat($news['cat_slug']).'"><span itemprop="name">'.stripslashes($news['cat_name']).'</span></a>
            <meta itemprop="position" content="3" />
        </li>
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name">'.stripslashes($news['title']).'</span>
            <meta itemprop="position" content="4" />
        </li>';

        $seo_last_update = ($news['last_update'] != '') ? $news['last_update'] : strtotime($news['date_add']);
        $this->_data['seo'] = array(
            'seo_title' => stripslashes($news['seo_title']),
            'seo_description' => stripslashes($news['seo_description']),
            'seo_image' => ($news['path_image'] != '') ? $this->link_upload.'/'.$news['path_image'] : $this->_data['seo_image_page'],
            'seo_date_add' => date("Y-m-d\TH:i:s.000\Z", strtotime($news['date_add'])),
            'seo_last_update' => date("Y-m-d\TH:i:s.000\Z", $seo_last_update),

            'articleSection' => $news['cat_name'],
            'datePublished' => date(DATE_ATOM, strtotime($news['date_add'])),
            'dateModified'  => date(DATE_ATOM, $seo_last_update),

            'seo_image_alt' => stripslashes($news['title']),
        );

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );

        $form_app = 0;
        if($category_id == PARENT_CAT_RECRUITMENT) {
            $form_app = 1;

            $this->load->model('pages_model');
            $conPages = " page_id = '10' ";
            $select = "page_title, page_detail";
            $this->_data['page'] = $this->pages_model->getPageBy($conPages, $select);
            $detail_link = current_url();
            $this->_data['detail_link'] = $detail_link;

            if ($this->input->post()) {
                $_data = $this->input->post('data');

                $params['career_pos'] = $_data['career_pos'];
                $params['fullname'] = $_data['fullname'];
                $params['email'] = $_data['email'];
                $params['phone'] = $_data['phone'];
                $params['linkedin'] = $_data['linkedin'];
                $params['email_footer'] = $this->lable['email_footer'];
                $params['base_url'] = $this->base_url;
                $message = $this->parser->parse('email/form_apply.tpl', $params, TRUE);

                require_once(APPPATH . 'config/email_order.php');
                $this->load->library('email');
                $this->email->initialize($config);
                $admin_email = $this->lable['admin_email'];
                $admin_email_1 = ''; //$this->lable['admin_email_1'];
                $this->email->from($_data['email'], $this->lable['menu_recruitment']);

                $this->email->to($admin_email);
                if ($admin_email_1 != '') {
                    $this->email->cc($admin_email_1);
                }

                $this->load->helper('file');
                $attach1 = $this->do_attach('file1');
                $file_path_1 = $attach1['file_path'];

                if ($file_path_1 != '') {
                    $this->email->attach($attach1['upload_data']['full_path']);
                }

                $this->email->subject($this->lable['email_recruitment_title']);
                $this->email->message($message);

                if ($this->email->send()) {
                    $this->session->set_flashdata('alert', 'success');
                    $this->session->set_flashdata('msg', $this->lable['send_apply_success']);
                } else {
                    $this->session->set_flashdata('alert', 'warning');
                    $this->session->set_flashdata('msg', $this->lable['send_apply_fail']);
                }

                delete_files($attach1['upload_data']['full_path']);
                redirect($detail_link);
            }
        }

        $this->_data['form_app'] = $form_app;

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->blog_model->blog_id = $id;
        $tags = $this->blog_model->getTags();
        $this->_data['tags'] = $tags;

        if($category_id == PARENT_CAT_VIDEO){

            $this->parser->parse( $this->control."/index_video.tpl", $this->_data);

        } else {

            if($category_id != 13) {
                $base_tlp_front = $this->_data['base_tlp_front'];
                $this->_data['header_script'] = '<link rel="stylesheet" href="'.$base_tlp_front.'/css/toc.min.css?ver=2.9">
                    <script src="'.$base_tlp_front.'/js/toc.min.js?ver=2.6"></script>';
            }

            $this->parser->parse( $this->control."/index.tpl", $this->_data);
        }
    }

    /**
     * Redirect old ulr
     *
     * @param $slug
     * @return mixed
     */
    function redirect_old($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        if (!$slug) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        /* News detail */
        $cond = "WHERE a.slug = '$slug' AND a.post_type = '$this->_post_type' ";
        $news = $this->blog_model->getBlogBy($cond);

        if (!$news) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $cat_slug = $news['cat_slug'];
        $slug = $news['slug'];

        if($cat_slug && $slug){
            redirect(base_url("$cat_slug/$slug"));
        } else {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $news['blog_id'];
        $this->_data['news'] = $news;
        $category_id = $news['category_id'];
        $per_item_news_related = ($this->isMobile == DETECT_MOBILE) ? 5 : $this->lable['per_item_news_related'];
        $slugNews = convertSlugByLang(NEWS_SLUG);

        /* Related */
        $conNewsRelated = "post_type = '".POST_TYPE_BLOG."' and category_id = '$category_id' and blog_id <> '$id'";
        $this->_data['newsRelated'] = $this->blog_model->getBlogBasic($conNewsRelated, "LIMIT 0,$per_item_news_related",
            'ORDER BY date_add DESC');

        $this->main_model->updateHit($id);

        /* Breadcrumb */
        $this->_data['breadcrumb'] = '
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="'.base_url($slugNews).'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="'.url_news_cat($news['cat_slug']).'"><span itemprop="name">'.stripslashes($news['cat_name']).'</span></a>
            <meta itemprop="position" content="3" />
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

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );

        $form_app = 0;
        if($category_id == PARENT_CAT_RECRUITMENT) {
            $form_app = 1;

            $this->load->model('pages_model');
            $conPages = " page_id = '10' ";
            $select = "page_title, page_detail";
            $this->_data['page'] = $this->pages_model->getPageBy($conPages, $select);
            $detail_link = current_url();
            $this->_data['detail_link'] = $detail_link;

            if ($this->input->post()) {
                $_data = $this->input->post('data');

                $params['career_pos'] = $_data['career_pos'];
                $params['fullname'] = $_data['fullname'];
                $params['email'] = $_data['email'];
                $params['phone'] = $_data['phone'];
                $params['linkedin'] = $_data['linkedin'];
                $params['email_footer'] = $this->lable['email_footer'];
                $params['base_url'] = $this->base_url;
                $message = $this->parser->parse('email/form_apply.tpl', $params, TRUE);

                require_once(APPPATH . 'config/email_order.php');
                $this->load->library('email');
                $this->email->initialize($config);
                $admin_email = $this->lable['admin_email'];
                $admin_email_1 = ''; //$this->lable['admin_email_1'];
                $this->email->from($_data['email'], $this->lable['menu_recruitment']);

                $this->email->to($admin_email);
                if ($admin_email_1 != '') {
                    $this->email->cc($admin_email_1);
                }

                $this->load->helper('file');
                $attach1 = $this->do_attach('file1');
                $file_path_1 = $attach1['file_path'];

                if ($file_path_1 != '') {
                    $this->email->attach($attach1['upload_data']['full_path']);
                }

                $this->email->subject($this->lable['email_recruitment_title']);
                $this->email->message($message);

                if ($this->email->send()) {
                    $this->session->set_flashdata('alert', 'success');
                    $this->session->set_flashdata('msg', $this->lable['send_apply_success']);
                } else {
                    $this->session->set_flashdata('alert', 'warning');
                    $this->session->set_flashdata('msg', $this->lable['send_apply_fail']);
                }

                delete_files($attach1['upload_data']['full_path']);
                redirect($detail_link);
            }
        }

        $this->_data['form_app'] = $form_app;

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->blog_model->blog_id = $id;
        $tags = $this->blog_model->getTags();
        $this->_data['tags'] = $tags;

        // $BANNER_CAT_NEWS = BANNER_CAT_NEWS;
        // $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "$BANNER_CAT_NEWS");

        if($category_id == PARENT_CAT_VIDEO){
            $this->parser->parse( $this->control."/index_video.tpl", $this->_data);
        } else {
            $this->parser->parse( $this->control."/index.tpl", $this->_data);
        }
    }

    /**
     * Page news list item
     * @return mixed
     */
    function news()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $conNews = " post_type = '".POST_TYPE_BLOG."' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        $curPage = 0;
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_tintuc'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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

        $seo_title = stripslashes($this->lable['seo_title_news']);
        $seo_description = stripslashes($this->lable['seo_description_news']);

        if($curPage > 1) {
            $seo_title .= " - ".$this->lable['page']." ".$curPage;
            $seo_description .= " - ".$this->lable['page']." ".$curPage;
        }

        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_image' =>  $this->lable['seo_tintuc_image']
        );

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$this->lable['mn_news'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );

        $condCategory = " WHERE post_cat_id = '$this->_parent_category' AND lang = 'vi' ";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);
        $this->_data['category'] = $category;

        $this->parser->parse($this->control."/category.tpl", $this->_data);
    }

    /**
     * Page news list item
     * @return mixed
     */
    function authors()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $conNews = " post_type = '".POST_TYPE_BLOG."' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        $curPage = 0;
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_tintuc'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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

        $seo_title = stripslashes($this->lable['seo_title_authors']);
        $seo_description = stripslashes($this->lable['seo_description_authors']);

        if($curPage > 1) {
            $seo_title .= " - ".$this->lable['page']." ".$curPage;
            $seo_description .= " - ".$this->lable['page']." ".$curPage;
        }

        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_image' =>  $this->lable['seo_tintuc_image']
        );

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">Author Panpic Editor Team</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );

        $condCategory = " WHERE post_cat_id = '$this->_parent_category' AND lang = 'vi' ";
        $selectCategory = 'post_cat_id, cat_name, cat_slug, seo_title, seo_description';
        $category = $this->main_model->menuCatBlogs($condCategory, $selectCategory, true);
        $this->_data['category'] = $category;

        $this->parser->parse($this->control."/authors.tpl", $this->_data);
    }

    /**
     * @param $slug
     * @return mixed
     */
    function category($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get category by cat slug, check category exist from database
        $condCategory = " WHERE cat_slug = '$slug' AND lang = 'vi' ";
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
        $conNews = " post_type = '".POST_TYPE_BLOG."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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
            <a itemprop="item" href="'.base_url('tin-tuc').'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );


        if ($post_cat_id == PARENT_CAT_VIDEO) {
            $this->parser->parse($this->control."/category_video.tpl", $this->_data);
        } else {
            $this->parser->parse($this->control."/category.tpl", $this->_data);
        }
    }

    /**
     * WEB BLOG
     * @return mixed
     */
    function web_blog()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_cat_id = 14;
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
        $conNews = " post_type = '".POST_TYPE_BLOG."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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
            <a itemprop="item" href="'.base_url('tin-tuc').'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );


        if ($post_cat_id == PARENT_CAT_VIDEO) {
            $this->parser->parse($this->control."/category_video.tpl", $this->_data);
        } else {
            $this->parser->parse($this->control."/category.tpl", $this->_data);
        }
    }

    /**
     * FAQ
     * @return mixed
     */
    function faq()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_cat_id = 5;
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
        $conNews = " post_type = '".POST_TYPE_BLOG."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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
            <a itemprop="item" href="'.base_url('tin-tuc').'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );


        if ($post_cat_id == PARENT_CAT_VIDEO) {
            $this->parser->parse($this->control."/category_video.tpl", $this->_data);
        } else {
            $this->parser->parse($this->control."/category.tpl", $this->_data);
        }
    }

    /**
     * FAQ
     * @return mixed
     */
    function ux_ui()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_cat_id = 6;
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
        $conNews = " post_type = '".POST_TYPE_BLOG."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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
            <a itemprop="item" href="'.base_url('tin-tuc').'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );


        if ($post_cat_id == PARENT_CAT_VIDEO) {
            $this->parser->parse($this->control."/category_video.tpl", $this->_data);
        } else {
            $this->parser->parse($this->control."/category.tpl", $this->_data);
        }
    }

    /**
     * TIN VIDEO
     * @return mixed
     */
    function video_blog()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_cat_id = 13;
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
        $conNews = " post_type = '".POST_TYPE_BLOG."' AND category_id = '$post_cat_id' "; // AND content IS NOT NULL AND content != ''
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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
            <a itemprop="item" href="'.base_url('tin-tuc').'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );


        if ($post_cat_id == PARENT_CAT_VIDEO) {
            $this->parser->parse($this->control."/category_video.tpl", $this->_data);
        } else {
            $this->parser->parse($this->control."/category.tpl", $this->_data);
        }
    }

    /**
     * CAREER
     * @return mixed
     */
    function career_blog()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $post_cat_id = 21;
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
        $conNews = " post_type = '".POST_TYPE_BLOG."' AND category_id = '$post_cat_id' AND content IS NOT NULL AND content != '' ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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
            <a itemprop="item" href="'.base_url('tin-tuc').'"><span itemprop="name">'.$this->lable['mn_news'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$category['cat_name'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );


        if ($post_cat_id == PARENT_CAT_VIDEO) {
            $this->parser->parse($this->control."/category_video.tpl", $this->_data);
        } else {
            $this->parser->parse($this->control."/category.tpl", $this->_data);
        }
    }

    /**
     * @param string $attach_name
     * @return array
     */
    private function do_attach($attach_name = 'file1')
    {
        $path = $this->path_upload;

        $pathY = date('Y');
        if (!is_dir($path . "/" . $pathY)) {
            mkdir($path . "/" . $pathY, 0755, TRUE);
        }

        $path_M = "/" . date('m');
        if (!is_dir($path . "/" . $pathY . $path_M)) {
            mkdir($path . "/" . $pathY . $path_M, 0755, TRUE);
        }

        $path_D = "/" . date('d');
        if (!is_dir($path . "/" . $pathY . $path_M . $path_D)) {
            mkdir($path . "/" . $pathY . $path_M . $path_D, 0755, TRUE);
        }

        $file_path = $pathY . $path_M . $path_D;
        $config['upload_path'] = $path . "/" . $file_path;
        $config['allowed_types'] = $this->config->item("allowed_file_types");
        $config['max_size'] = 1024000 * 5; //5 MB(1024 Kb)

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($attach_name)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $info_upload = $this->upload->data();
            return $data = array(
                'upload_data' => $info_upload,
                'file_path' => $file_path ."/". $info_upload['file_name']
            );
        }
    }

    /**
     * Blogs by Tag
     */
    function tag($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $parent_link = base_url('tin-tuc');
        if($slug == ''){
            redirect($parent_link);
        }

        $more_url = "";
        $ACTIVE = ACTIVE;
        $cond = " WHERE c.slug = '$slug' ";

        $totalItems = $this->blog_model->countMainProductByCondTags($cond);

        $cond .= " ORDER BY a.date_add DESC ";
        $per_page    = $this->lable['per_item_tags'];
        $base_url    = current_url();
        $uri_segment = 4;
        $this->load->library('pagination_blog');
        $this->pagination_blog->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $items = $this->blog_model->getMainProductByCondTags("a.*", $cond, $per_page, $start);
        $this->_data['items'] = $items;
        $this->_data['totalItems'] = $totalItems;

        $tag = $this->blog_model->getTagBySlug($slug, 'a.*, c.path_image, c.path_image_thumb ');

        $tag_title = $tag['title'];
        $seo_title = ($tag['seo_title'] != '') ? stripslashes($tag['seo_title']) : "$tag_title | ".$this->lable['seo_title_tag'];
        $seo_desc = ($tag['seo_description'] != '') ? stripslashes($tag['seo_description']) :  $this->lable['seo_desc_tag']." - tag $tag_title";
        if($curpage > 1) {
            $seo_title .= " - Trang $curpage ";
            $seo_desc .= " - Trang $curpage ";
        }

        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_desc,
            'seo_image' => ($tag['path_image'] != '') ? $this->link_upload.'/'.$tag['path_image'] : $this->_data['seo_image_page'],
        );

        $breadcrumb = '<li  itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <span itemprop="name">tag: '.$tag_title.'</span>
                            <meta itemprop="position" content="2">
                        </li>';

        $this->_data['breadcrumb'] = $breadcrumb;

        $this->_data['tags'] = $tag;
        $this->parser->parse( $this->control."/tag.tpl", $this->_data);
    }

    /**
     * Search news list item
     * @return mixed
     */
    function search()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $q = $this->input->get('s');

        $slugNews = convertSlugByLang(NEWS_SLUG);

        if(! $q){
            redirect( base_url($slugNews) );
        }

        $conNews = " post_type = '".POST_TYPE_BLOG."' AND content IS NOT NULL AND content != '' AND (title LIKE '%$q%' OR content LIKE '%$q%') ";
        $totalItems = $this->blog_model->counterBlog($conNews);
        $this->_data['totalItems'] = $totalItems;

        $curPage = 0;
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_tintuc'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $news = $this->blog_model->getBlog($conNews, $perPage, $start);

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

        $seo_title = stripslashes($this->lable['seo_title_news']);
        $seo_description = stripslashes($this->lable['seo_description_news']);

        if($curPage > 1) {
            $seo_title .= " - ".$this->lable['page']." ".$curPage;
            $seo_description .= " - ".$this->lable['page']." ".$curPage;
        }

        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$this->lable['mn_news'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['categories'] = $this->blog_model->getNodeByParentId( $this->_parent_category );

        $this->parser->parse($this->control."/category.tpl", $this->_data);
    }

}
