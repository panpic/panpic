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


    /**
     * Xử lý AJAX submit consultation form
     *
     * @return void - JSON response
     */
    public function submit_consultation() {
        // Chỉ accept POST request
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->output_json(FALSE, 'Invalid request method', [], 400);
            return;
        }

        // Lấy JSON data từ request body
        $json_data = $this->input->raw_input_stream;
        $data = json_decode($json_data, TRUE);

        // ========== VALIDATION ==========
        if (!$this->validate_input($data)) {
            $this->output_json(FALSE, 'Validation failed', $this->errors, 422);
            return;
        }

        // ========== SANITIZE & PREPARE DATA ==========
        $contact_data = array(
            'company_name' => trim($data['companyName']),
            'email' => trim($data['email']),
            'phone' => trim($data['phone']),
            'service' => trim($data['service']),
            'message' => trim($data['message']),
            'submitted_at' => date('Y-m-d H:i:s'),
            'ip_address' => $this->input->ip_address(),
            'status' => 'new'
        );

        /*
        // ========== SAVE TO DATABASE ==========
        $save_result = $this->Contact_model->save_consultation($contact_data);
        if (!$save_result) {
            $this->output_json(FALSE, 'Error saving consultation', [], 500);
            return;
        }
        */

        $save_result = 1;
        // ========== SEND EMAIL NOTIFICATION ==========
        $email_sent = $this->send_notification_email($contact_data);

        // ========== SUCCESS RESPONSE ==========
        $response_data = array(
            'consultation_id' => $save_result,
            'email_sent' => $email_sent
        );

        $this->output_json(TRUE, 'Consultation submitted successfully', $response_data, 200);
    }


    /**
     * Validate input data
     *
     * @param array $data - Input data từ AJAX
     * @return bool - TRUE nếu valid, FALSE nếu có lỗi
     */
    private function validate_input($data) {
        $this->errors = array();

        // Kiểm tra tất cả required field có không
        if (empty($data['companyName']) || strlen(trim($data['companyName'])) < 3) {
            $this->errors['companyName'] = 'Company name must be at least 3 characters';
        }

        if (empty($data['email']) || !$this->is_valid_email($data['email'])) {
            $this->errors['email'] = 'Invalid email format';
        }

        if (empty($data['phone']) || !$this->is_valid_phone($data['phone'])) {
            $this->errors['phone'] = 'Phone number must be 10-11 digits';
        }

        if (empty($data['service'])) {
            $this->errors['service'] = 'Service must be selected';
        }

        if (empty($data['message']) || strlen(trim($data['message'])) < 10) {
            $this->errors['message'] = 'Message must be at least 10 characters';
        }

        return count($this->errors) === 0;
    }

    /**
     * Validate email format
     *
     * @param string $email
     * @return bool
     */
    private function is_valid_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE;
    }

    /**
     * Validate phone number (Việt Nam format)
     * Accept: 0986973897 hoặc +84986973897
     *
     * @param string $phone
     * @return bool
     */
    private function is_valid_phone($phone) {
        // Remove non-digits except +
        $cleaned = preg_replace('/[^0-9+]/', '', $phone);

        // Pattern: (0|+84) + 9-10 digits
        $pattern = '/^(0|\+84)[0-9]{9,10}$/';

        return preg_match($pattern, $cleaned) === 1;
    }

    /**
     * Gửi email notification cho admin
     *
     * @param array $data - Contact data
     * @return bool - TRUE nếu gửi thành công
     */
    private function send_notification_email($data) {

        $fullname = $data['company_name'];
        $admin_email_1 = $data['email'];

        $message = $this->parser->parse('email/form_ai_hub.tpl', $data, TRUE);

        $subject = "[$fullname] ".$this->lable['email_contact_title'];

        require_once(APPPATH .'config/email_order.php');
        $this->load->library('email');
        $this->email->initialize($config);
        $admin_email = $this->lable['admin_email'];
        $this->email->from($data['email'], $subject);

        $this->email->to($admin_email);
        if ($admin_email_1 != '') {
            $this->email->cc($admin_email_1);
        }
        $this->email->subject($subject);
        $this->email->message($message);

        $send_result = $this->email->send();
        // Reset email library
        $this->email->clear(TRUE);
        return $send_result;

        /*
        // Config email
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',  // Đổi theo mail server của bạn
            'smtp_port' => 587,
            'smtp_user' => 'your-email@gmail.com',  // Đổi email của bạn
            'smtp_pass' => 'your-password',  // Đổi password của bạn
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        $this->email->initialize($config);

        // Email content
        $subject = '[AI Hub] Tư vấn mới từ ' . $data['company_name'];

        $body = $this->load->view('email/consultation_notification', array(
            'data' => $data
        ), TRUE);

        // Send email
        $this->email->from('noreply@panpic.vn', 'Panpic AI Hub');
        $this->email->to('contact@panpic.vn');  // Đổi email nhận của bạn
        $this->email->subject($subject);
        $this->email->message($body);

        $send_result = $this->email->send();

        // Reset email library
        $this->email->clear(TRUE);

        return $send_result;
        */
    }

    /**
     * Output JSON response
     *
     * @param bool $success
     * @param string $message
     * @param array $data
     * @param int $http_code
     * @return void
     */
    private function output_json($success, $message, $data = array(), $http_code = 200) {
        $response = array(
            'success' => $success,
            'message' => $message,
            'data' => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($http_code)
            ->set_output(json_encode($response));
    }


}
