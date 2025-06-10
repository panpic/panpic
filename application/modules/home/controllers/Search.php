<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 24 Aug 2022
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 1 Jun 2020
 */
class Search extends FRONT_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('search_model');
    }

    function item()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $keyword = $this->input->get('s');
        $search['s'] = $keyword;
        $this->_data['search'] = $search;
        $more_url = "s=$keyword";

        $search = $this->search_model->getKeyWordTotal($keyword, $this->langUrl);
        $totalItems = count($search);

        $this->_data['totalItems'] = $totalItems;
        $slugSearch = convertSlugByLang(SEARCH_SLUG);
        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_portfolio'];
            $baseUrl = base_url($slugSearch);
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, $more_url);
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['news'] = $this->search_model->getKeyWordPagination($keyword, $this->langUrl, $perPage, $start);
        }
        // pre( $this->_data['news'] );

        // Set seo data
        $seo_title = $this->lable['seo_title_search']." - $keyword";
        $seo_desc = $this->lable['seo_description_search']." - $keyword";
        $this->_data['seo'] = array(
            'seo_title' => $seo_title,
            'seo_description' => $seo_desc,
            'seo_image' =>  $this->_data['seo_image_page']
        );

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['mn_search'] . '</span><meta itemprop="position" content="2" /></li>';

        $this->parser->parse( $this->control."/item.tpl", $this->_data);
    }
}
