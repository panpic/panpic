<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 25 Apr 2026
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 20 Aug 2021
 */
class Index extends FRONT_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('index_model');
        $this->load->driver('cache', ['adapter' => 'file']);
        // Có thể đổi sang 'redis' hoặc 'memcached' nếu server hỗ trợ
    }

    /**
     * Index
     */
    function index()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $seo = array(
            'seo_title' => $this->lable['seo_title_home'],
            'seo_description' => $this->lable['seo_description_home'],
            'seo_image' =>  $this->_data['seo_image_page']
        );
        $this->_data['seo'] = $seo;

        if ($this->isMobile == DETECT_MOBILE) {
            $offset = 4;
            $testimonialOffset = 7;
            $partnersLimit = " LIMIT 0,7 ";
            $bannersLimit = " LIMIT 0,1 ";
        } else {
            $offset = 8;
            $testimonialOffset = 9;
            $partnersLimit = " LIMIT 0,12 ";
            $bannersLimit = " LIMIT 0,2 ";
        }

        // Cache banners
        $cacheKeyBanners = 'homepage_banners';
        if (!$banners = $this->cache->get($cacheKeyBanners)) {
            $banners = $this->main_model->getBanners($this->langUrl, 'home', $bannersLimit, 1);
            $this->cache->save($cacheKeyBanners, $banners, 600);
        }
        $this->_data['banners'] = $banners;

        // Cache portfolios
        $cacheKeyPortfolios = 'homepage_portfolios';
        if (!$portfolios = $this->cache->get($cacheKeyPortfolios)) {
            $fields = "cat_slug, blog_id, category_id, date_add, slug, title, title_2, portfolio_utility, path_image, path_image_thumb";
            $portfolios = $this->index_model->getHomePortfolio("", $fields, $offset);
            $this->cache->save($cacheKeyPortfolios, $portfolios, 600);
        }
        $this->_data['portfolios'] = $portfolios;

        // Services menu home (ít thay đổi, có thể cache)
        $cacheKeyServices = 'homepage_services_menu';
        if (!$servicesMenu = $this->cache->get($cacheKeyServices)) {
            $servicesMenu = $this->nestedpostcat_library->services_menu_home($this->_data['menu_services']);
            $this->cache->save($cacheKeyServices, $servicesMenu, 600);
        }
        $this->_data['services_menu_home'] = $servicesMenu;

        // Blog news
        $POST_TYPE_BLOG = POST_TYPE_BLOG;
        $cacheKeyNews = 'homepage_news';
        if (!$news = $this->cache->get($cacheKeyNews)) {
            $conNews = "home_status = 1 AND post_type = '$POST_TYPE_BLOG' AND category_id != '" . CAT_BLOG_VIDEO_ID . "' AND content IS NOT NULL AND content != '' ";
            $news = $this->index_model->getHomeBlogsFocus($conNews, 'LIMIT 0,3');
            $this->cache->save($cacheKeyNews, $news, 600);
        }
        $this->_data['news'] = $news;

        $IDs = implode(',', array_column($news, 'blog_id'));
        $cacheKeyNewsSub = 'homepage_news_sub';
        if (!$arr_news = $this->cache->get($cacheKeyNewsSub)) {
            if ($IDs) {
                $PARENT_CAT_RECRUITMENT = PARENT_CAT_RECRUITMENT;
                $cond = " WHERE post_type = '$POST_TYPE_BLOG' AND blog_id NOT IN($IDs) AND category_id <> $PARENT_CAT_RECRUITMENT AND home_status = 1 GROUP BY blog_id ORDER BY date_add DESC ";
                $arr_news = $this->index_model->getHomeBlogsByCond($cond, 3);
                $this->cache->save($cacheKeyNewsSub, $arr_news, 600);
            }
        }
        $news_sub = $this->nestedpostcat_library->parseBlogs($this->_data['menu_tintuc'], $arr_news);
        $this->_data['news_sub_1'] = $news_sub[PARENT_CAT_BLOG_SUB_1];
        $this->_data['news_sub_2'] = $news_sub[PARENT_CAT_BLOG_SUB_2];
        $this->_data['news_sub_3'] = $news_sub[PARENT_CAT_BLOG_SUB_3];
        $this->_data['news_sub_4'] = $news_sub[PARENT_CAT_BLOG_SUB_4];

        // Testimonials
        $cacheKeyTestimonial = 'homepage_testimonial';
        if (!$testimonialData = $this->cache->get($cacheKeyTestimonial)) {
            $conTestimonial = " post_type = '".POST_TYPE_TESTIMONIAL."' AND home_status = 1 AND content IS NOT NULL AND content != '' ";
            $testimonialData = $this->index_model->getTestimonial($conTestimonial, $testimonialOffset, 0);
            $this->cache->save($cacheKeyTestimonial, $testimonialData, 600);
        }
        $this->_data['testimonial'] = $testimonialData;

        // Partners
        $cacheKeyPartners = 'homepage_partners';
        if (!$partnersData = $this->cache->get($cacheKeyPartners)) {
            $partnersData = $this->main_model->getBanners($this->langUrl, 'client', $partnersLimit, 1);
            $this->cache->save($cacheKeyPartners, $partnersData, 600);
        }
        $this->_data['partners'] = $partnersData;

        // Render view
        $this->parser->parse("index/index.tpl", $this->_data);
    }

}
