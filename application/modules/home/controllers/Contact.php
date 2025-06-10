<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 26 Aug 2022
 *
 * @package Frontend Blog
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 14 Feb 2021
 */
class Contact extends FRONT_Controller
{
    /**
     * Contact constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->model('video_model');
        $this->load->model('portfolio_model');
        $this->load->model('pages_model');

        $this->load->library('recaptcha');
    }

    /**
     * @param $slug
     * @return mixed
     */
    function index()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $_p = $this->input->get('p');

        $conPages = "page_id = '" . BLOG_CONTACT_ID . "' ";
        $page = $this->pages_model->getPageBy($conPages);
        if (!$page) {
            return $this->parser->parse("404.tpl", $this->_data);
        }
        $this->_data['page'] = $page;

        $content = '';
        if($_p == 1) {
            $content = '1. Gói Basic - Thiết kế theo mẫu có sẵn';
        } elseif ($_p == 2) {
            $content = '2. Gói Figma - Thiết kế giao diện theo yêu cầu';
        }

        $this->_data['content'] = $content;
        

        $this->data['valid'] = array();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'email'));

        $captcha = array(
            'widget' => $this->recaptcha->getWidget(),
            'script' => $this->recaptcha->getScriptTag(),
        );

        $this->_data['captcha'] = $captcha;
        $back_link = 'lien-he';

        /* Form contact send */
        if ($this->input->post()) {
            $_data = $this->input->post('data');

            $recaptcha = $this->input->post('g-recaptcha-response');
            $response = $this->recaptcha->verifyResponse($recaptcha);

            if ( isset($response['success']) and $response['success'] === true ) {
                // echo "You got it!";
            } else {
                redirect( base_url($back_link) );
            }

            $fullname = $_data['fullname'];
            $parame['fullname'] = $fullname;
            $parame['email'] = $_data['email'];
            $parame['address'] = $_data['address']; /*telephone*/
            $parame['content'] = $_data['content'];
            $parame['base_url'] = $this->base_url;
            $parame['email_footer'] = $this->lable['email_footer'];
            $message = $this->parser->parse('email/form_contact.tpl', $parame, TRUE);

            $subject = "[$fullname] ".$this->lable['email_contact_title'];

            require_once(APPPATH .'config/email_order.php');
            $this->load->library('email');
            $this->email->initialize($config);
            $admin_email = $this->lable['admin_email'];
            $admin_email_1 = ''; //$this->lable['admin_email_1'];
            $this->email->from($_data['email'], $subject);

            $this->email->to($admin_email);
            if ($admin_email_1 != '') {
                $this->email->cc($admin_email_1);
            }
            $this->email->subject($subject);
            $this->email->message($message);

            $back_url = current_url();
            if ($this->email->send()) {
                $this->session->set_flashdata('alert', 'success');
                $this->session->set_flashdata('msg', $this->lable['send_message_success']);
                redirect($back_url);

            } else {
                $this->session->set_flashdata('alert', 'danger');
                $this->session->set_flashdata('msg', $this->lable['send_message_fail']);
                redirect($back_url);
            }
        }

        $this->_data['seo'] = array(
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'seo_image' => $this->_data['seo_image_page']
        );

        $this->_data['alert'] = $this->session->flashdata('alert');
        $this->_data['msg'] = $this->session->flashdata('msg');

        $this->_data['breadcrumb'] = '
        <li class="is-active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
            <span itemprop="name">'.$this->lable['mn_contact'].'</span>
            <meta itemprop="position" content="2" />
        </li>';
        
        $this->parser->parse( $this->control ."/index.tpl", $this->_data);
    }

}