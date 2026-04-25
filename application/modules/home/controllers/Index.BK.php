<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 7 Jan 2023
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

        if($this->isMobile == DETECT_MOBILE){
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

        $this->_data['banners'] = $this->main_model->getBanners($this->langUrl, 'home', $bannersLimit, 1);

        /* project */
        $fields = "cat_slug, blog_id, category_id, date_add, slug, title, title_2, portfolio_utility, path_image, path_image_thumb";
        $this->_data['portfolios'] = $this->index_model->getHomePortfolio("", $fields, $offset);

        /* Services home */
        $this->_data['services_menu_home'] = $this->nestedpostcat_library->services_menu_home( $this->_data['menu_services'] );

        /* blog news */
        $POST_TYPE_BLOG = POST_TYPE_BLOG;
        $conNews = "home_status = 1 AND post_type = '$POST_TYPE_BLOG' AND category_id != '" . CAT_BLOG_VIDEO_ID . "' AND content IS NOT NULL AND content != '' ";
        $news = $this->index_model->getHomeBlogsFocus($conNews, 'LIMIT 0,3');
        $this->_data['news'] = $news;

        $IDs = $news[0]['blog_id'];
        $IDs .= isset($news[1]['blog_id']) ? ','.$news[1]['blog_id'] : $IDs;
        $IDs .= isset($news[2]['blog_id']) ? ','.$news[2]['blog_id'] : $IDs;

        if( $IDs ){
            $PARENT_CAT_RECRUITMENT = PARENT_CAT_RECRUITMENT;
            $cond = " WHERE post_type = '$POST_TYPE_BLOG' AND blog_id NOT IN($IDs) AND category_id <> $PARENT_CAT_RECRUITMENT AND home_status = 1 GROUP BY blog_id ORDER BY date_add DESC ";
            $arr_news = $this->index_model->getHomeBlogsByCond($cond, 3);
        }

        $news_sub = $this->nestedpostcat_library->parseBlogs($this->_data['menu_tintuc'], $arr_news);

        $this->_data['news_sub_1'] = $news_sub[PARENT_CAT_BLOG_SUB_1];
        $this->_data['news_sub_2'] = $news_sub[PARENT_CAT_BLOG_SUB_2];
        $this->_data['news_sub_3'] = $news_sub[PARENT_CAT_BLOG_SUB_3];
        $this->_data['news_sub_4'] = $news_sub[PARENT_CAT_BLOG_SUB_4];

        $conTestimonial = " post_type = '".POST_TYPE_TESTIMONIAL."' AND home_status = 1 AND content IS NOT NULL AND content != '' ";
        $this->_data['testimonial'] = $this->index_model->getTestimonial($conTestimonial, $testimonialOffset, 0);

        $this->_data['partners'] = $this->main_model->getBanners($this->langUrl, 'client', $partnersLimit, 1);

        $this->parser->parse("index/index.tpl", $this->_data);
    }

}
