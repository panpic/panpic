<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 20 May 2025
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 20 May 2025
 */
class Test extends FRONT_Controller
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
        $link = "https://www.keyword-tools.org/en/google-ranking-live-check/?keyword=thiet%20ke%20web&domain=panpic.vn&searchengine=google.com&analysis=true";
        $test = file_get_contents($link);
        pre($test);

        $path_upload_html = $this->config->item("path_upload_html");

        $menu_mobile_html = $this->parser->parse('widget/menu-mobile.tpl', $this->_data, TRUE);
        file_put_contents($path_upload_html.'/menu_mobile.html', $menu_mobile_html);

        $menu_html = $this->parser->parse('widget/menu-pc.tpl', $this->_data, TRUE);
        file_put_contents($path_upload_html.'/menu.html', $menu_html);
    }

}