<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Controllers Frontend
* Last update 9 Nov 2024
*
* @package Frontend
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 21 Aug 2021
*/

class Subscriber extends FRONT_Controller{


    public function __construct(){
        parent::__construct();
    }


    /**
     * Insert Subscriber
     */
    function index() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $subscriber_email = $this->input->post('sub_e');
        $subscriber_fullname = $this->input->post('sub_fn');
        $subscriber_phone = $this->input->post('sub_p');

        if($subscriber_email != '' && $subscriber_fullname != '' && $subscriber_phone != '') {
            $params = array(
                    'email'     => $subscriber_email,
                    'fullname'  => $subscriber_fullname,
                    'phone'     => $subscriber_phone,
                    'date_add' => date('Y-m-d H:i:s')
                );
            $status = $this->main_model->insertSubscriber($params);
            if($status) {

                $message = $this->parser->parse('subscriber/modal-notification.tpl', $this->_data, TRUE);;
                $arr = array(
                    'status' => 1,
                    'content' => $message
                );
                echo json_encode($arr);
                die();

            }
        }

        $arr = array(
            'status' => 0,
            'content' => ''
        );
        echo json_encode($arr);
        die();
    }



}