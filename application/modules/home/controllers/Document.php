<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 25 Aug 2021
 *
 * @package Frontend Blog
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 14 Feb 2020
 */
class Document extends FRONT_Controller
{

    private $_parent_category;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('document_model');
        $this->_parent_category = POST_CAT_DOWNLOAD;
        $this->document_model->lang = $this->langUrl;

        $this->_data['banner'] = $this->main_model->getBanner($this->langUrl, "document");
    }

    /**
     * @param $slug
     * @return mixed
     */
    function index($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        if (!$slug) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get data document, check exits from database
        $conDocument = " slug = '$slug' ";
        $fields = "category_id, slug, title, title_2, date_add, seo_title, seo_description, hits, path_image ";
        $document = $this->document_model->getDocumentBy($conDocument, $fields);

        if (!$document) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $id = $document['blog_id'];
        $this->_data['document'] = $document;
        $this->main_model->updateHit($id);

        $category_id = $document['category_id'];
        $category = $this->document_model->getCategoryByCond(" AND c.post_cat_id = '$category_id'");
        $this->_data['category'] = $category;

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <a itemprop="item" href="'.base_url('tai-lieu').'"><span itemprop="name">'.$this->lable['menu_tailieu'].'</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$document['title'].'</span>
            <meta itemprop="position" content="2" />
        </li>';

        $this->_data['seo'] = array(
            'seo_title' => $document['seo_title'],
            'seo_description' => $document['seo_description'],
            'seo_image' => $this->link_upload.'/'.$document['path_image']
        );

        $this->parser->parse($this->control."/index.tpl", $this->_data);
    }

    /**
     * Get list document by category
     */
    function category($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $fields = " c.post_cat_id, c.posts_no, d.cat_name, d.cat_slug, d.cat_note, d.seo_title, d.seo_description ";
        $category = $this->document_model->getCategoryByCond(" AND d.cat_slug = '$slug'", $fields);
        $post_cat_id = $category['post_cat_id'];

        if (!$slug || $post_cat_id == '') {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        $cond = " AND c.post_cat_id = '$post_cat_id' ";
        $totalItems = $this->document_model->counterDocument($cond);
        $this->_data['totalItems'] = $totalItems;

        if ($totalItems > 0) {
            $this->load->library('pagination_blog');
            $perPage = $this->lable['per_item_document'];
            $baseUrl = current_url();
            $uriSegment = 4;
            $this->pagination_blog->pagination($baseUrl, $totalItems, $perPage, $uriSegment, '');
            $this->_data['links'] = $this->pagination->create_links();
            $curPage = $this->input->get('per_page');
            $offset = ($curPage) ? $curPage : 0;
            $start = ($offset > 0) ? (($offset - 1) * $perPage) : $offset;
            $this->_data['document'] = $this->document_model->getDocument($cond,  $perPage, $start);
        }

        $this->_data['category'] = $category;

        $this->_data['seo'] = array(
            'seo_title' => $category['seo_title'],
            'seo_description' => $category['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        /*
        // Set breadcrumb
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugAboutUs) . '"><span itemprop="name">' . $this->lable['menu_aboutus'] . '</span></a><meta itemprop="position" content="2" /></li>
            <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['page_document_title'] . '</span><meta itemprop="position" content="3" /></li>';
        */

        $this->_data['categories'] = $this->document_model->getNodeByParentId( $this->_parent_category );

        $this->parser->parse($this->control ."/category.tpl", $this->_data);
    }

    /**
     * Get list document
     */
    function items()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Set html render html collection
        $this->_data['scriptRender'] = "<link rel=\"stylesheet\" href='" . $this->_data['base_tlp_front'] . "/libs/datatables.net-bs/css/dataTables.bootstrap.min.css'>
        <script type=\"text/javascript\" src='". $this->_data['base_tlp_front'] ."/libs/jquery.dataTable/jquery.dataTables.min.js'></script>
        <script type=\"text/javascript\" src='". $this->_data['base_tlp_front'] ."/libs/datatables.net-bs/js/dataTables.bootstrap.min.js'></script>";

        // Get document
        $this->_data['document'] = $this->document_model->getDocument();

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $this->lable['seo_title_document'],
            'seo_description' => $this->lable['seo_description_document'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        // Set breadcrumb
        $slugAboutUs = convertSlugByLang(ABOUTUS_SLUG);
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' .$this->lable['page_document_title']. '</span><meta itemprop="position" content="2" /></li>';

        $this->parser->parse($this->control."/item.tpl", $this->_data);
    }

    function download($slug, $id) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $file_name = '';
        if($slug && $id) {
            $con = " blog_id = '$id' ";
            $data = $this->document_model->getDocumentBy($con);

            if($data['title_2'] != '') {
                $file_name = $this->path_upload.$data['title_2'];
            }
        }

        $this->load->helper('download');
        force_download($file_name, NULL);

        /*
        if($file_name != '') {

        } else {
            echo "<script>window.close();</script>";
        }
        */
    }

}