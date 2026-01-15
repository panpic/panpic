<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers RSS
 * Last update 12 Oct 2024
 * https://www.panpic.vn/rss/news.rss
 *
 * @package Frontend
 * @copyright Panpic
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 12 Oct 2024
 */
class Feed extends FRONT_Controller
{

    private $_parent_category;
    private $_post_type = POST_TYPE_BLOG;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->_parent_category = POST_CAT_KIENTHUC;
        $this->blog_model->lang = $this->langUrl;

        $this->load->library('sitemap_lib');
    }

    /**
     * RSS
     */
    function index()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        header("Content-type: text/xml; charset=utf-8");

        $PARENT_CAT_VIDEO = PARENT_CAT_VIDEO;
        $cond = " post_type = '".POST_TYPE_BLOG."' AND category_id <> $PARENT_CAT_VIDEO ";
        $feeds = $this->blog_model->getBlog($cond, 0, 0);

        $this->_data['feeds'] = $feeds;
        // pre($feeds);

        $this->parser->parse("feed/index.tpl", $this->_data);
    }

    /**
     * https://www.panpic.vn/home/feed/creatsitemapmain
     */
    function creatsitemapmain(){

        $filename = 'sitemap';
        $items = $this->sitemap_lib->sitemap_main();

        $xml = new DomDocument("1.0", "UTF-8");
        $xml->formatOutput=true;

        $urlset = $xml->createElement("urlset");
        $urlset->setAttribute("xmlns","https://www.sitemaps.org/schemas/sitemap/0.9");
        $urlset->setAttribute("xmlns:image","https://www.google.com/schemas/sitemap-image/1.1");
        $urlset->setAttribute("xmlns:video","https://www.google.com/schemas/sitemap-video/1.1");
        $urlset->setAttribute("xmlns:xhtml","https://www.w3.org/1999/xhtml");
        $xml->appendChild($urlset);

        foreach ($items as $vl) {
            $loc_url =  $vl['loc'];
            $priority =  $vl['priority'];

            $url = $xml->createElement("url");
            $urlset->appendChild($url);
            $loc = $xml->createElement("loc", $loc_url);
            $url->appendChild($loc);
            $changefreq = $xml->createElement("changefreq", "weekly");
            $url->appendChild($changefreq);
            $priority = $xml->createElement("priority", $priority);
            $url->appendChild($priority);
        }

        $xml->save($filename.".xml");
    }


}
