<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 22 jUn 2021
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 17 Feb 2020
 */
class Careers extends FRONT_Controller
{

    /**
     * Careers constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pages_model');
        $this->load->model('portfolio_model');
        $this->load->model('careers_model');

        // Get portfolio
        $condPortfolio = " content IS NOT NULL AND content != '' ";
        $limitPortfolio = ' LIMIT 0,5 ';
        $selectPortfolio = ' title, slug, short, path_image, path_image_thumb';
        $this->_data['portfolio'] = $this->portfolio_model->getPortfolio($condPortfolio, $limitPortfolio,
            $selectPortfolio);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function detail($slug)
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $id = $this->extract_blog_id($slug);
        if (!$id) {
            return $this->parser->parse("404.tpl", $this->_data);
        }

        // Get data news detail, check exits from database
        $conCareers = " blog_id = '$id' AND lang='$this->langUrl' ";
        $careers = $this->careers_model->getCareersBy($conCareers);
        if (!$careers) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['careers'] = $careers;
        $slugCareers = convertSlugByLang(CAREERS_SLUG);
        $detailLink = base_url("$slugCareers/$slug.html");
        $this->_data['detail_link'] = $detailLink;

        // Handle client apply
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
            redirect($detailLink);
        }

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->main_model->updateHit($id);

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugCareers) . '"><span itemprop="name">' . $this->lable['mn_news'] . '</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $careers['title'] . '</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $careers['seo_title'],
            'seo_description' => $careers['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control . "/detail.tpl", $this->_data);
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
        $config['max_size'] = 1024000 * 3; //3 MB(1024 Kb)

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($attach_name)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $info_upload = $this->upload->data();
            return $data = array(
                'upload_data' => $info_upload,
                'file_path' => $file_path . "/" . $info_upload['file_name']
            );
        }
    }

    /**
     * Page career list
     */
    public function item()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        // Get career
        $conCareer = " and post_type = '" . POST_TYPE_REDCRUITMENT . "' AND content IS NOT NULL AND content != ''";
        $this->_data['career'] = $this->careers_model->getCareers($conCareer);

        // Get banner slider
        $this->_data['banners'] = $this->main_model->getBanners($this->langUrl, 'careers', "", false);

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $this->lable['seo_title_career'],
            'seo_description' => $this->lable['seo_description_career'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $this->lable['menu_recruitment'] . '</span><meta itemprop="position" content="2" /></li>';

        $this->parser->parse($this->control . "/item.tpl", $this->_data);
    }

    /**
     * Page policies
     */
    function policies()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $conPages = "page_id = '" . BLOG_POLICIES_ID . "' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;
        $slugNews = convertSlugByLang(CAREERS_SLUG);

        // Set breadcrumb
        $this->_data['breadcrumb'] = '<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . base_url($slugNews) . '"><span itemprop="name">' . $this->lable['menu_recruitment'] . '</span></a><meta itemprop="position" content="2" /></li>
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">' . $page['page_title'] . '</span><meta itemprop="position" content="3" /></li>';

        // Set seo data
        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' =>  $this->_data['seo_image_page']
        );

        $this->parser->parse($this->control."/fullscreen-no-title.tpl", $this->_data);
    }

}
