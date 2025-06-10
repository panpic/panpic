<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 12 Oct 2023
 *
 * @package Frontend Blog
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 12 Oct 2023
 */
class Sitemapblog extends FRONT_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->blog_model->lang = $this->langUrl;
    }

    /**
     * Parse sitemap product
     * https://www.panpic.vn/home/sitemapblog/index 
     */
    function index()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $field = "slug";
        $cond = " post_type = '".POST_TYPE_BLOG."' AND content IS NOT NULL AND content != '' ";
        $items = $this->blog_model->getBlog($cond, 15000, 0, $field);

        $product_url = "https://www.panpic.vn/";
        $xml = new DomDocument("1.0", "UTF-8");
        $xml->formatOutput=true;

        $urlset = $xml->createElement("urlset");
        $urlset->setAttribute("xmlns","http://www.sitemaps.org/schemas/sitemap/0.9");
        $urlset->setAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
        $urlset->setAttribute("xsi:schemaLocation","http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd");
        $xml->appendChild($urlset);

        foreach ($items as $vl) {
            $loc_url = $product_url.$vl['slug'];
            $url=$xml->createElement("url");
            $urlset->appendChild($url);
            $loc=$xml->createElement("loc", $loc_url);
            $url->appendChild($loc);
            $changefreq=$xml->createElement("changefreq", "weekly");
            $url->appendChild($changefreq);
            $priority=$xml->createElement("priority", "0.64");
            $url->appendChild($priority);
        }

        $xml->save("sitemap_index.xml");

    }

}