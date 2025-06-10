<?php
/**
* Controllers Social author
* Last update 16 Sep 2018
*
* @package Social
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 16 Sep 2018
*/


class Sociallogin {


    var $CI = ''; 
    public $_session_enduser;

    function __construct() {

        $this->CI = & get_instance();
        $this->_session_enduser = $this->CI->config->item("session_enduser");

        $this->CI->load->library('facebook');
        $this->CI->load->library('googleplus');
        $this->CI->load->model('enduser_model');
    }

    

    

    /**
     * Check facebook author
     * @return bool
     */
    function getUserFacebook(){
        return $this->CI->facebook->getUser();
    }

    

    /**
     * Get User data from facebook login
     * @return array
     */
    function userFacebookInfo() {
        //return $this->CI->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
        return $this->CI->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
    }

    

    
    /**
     * Google plus author and User data
     * @return array
     */
    function getUserGoogleplus() {
        $this->CI->googleplus->getAuthenticate();
        return $this->CI->googleplus->getUserInfo();
    }

    

    






    /**
     * Google plus url login
     * @return string
     */
    function googleplusUrlLogin() {
        return $this->CI->googleplus->loginURL();
    }

    


    /**
     * Get user data info Social login
     * First facebook
     * Second google plus
     *
     * @return array
     */
    function socialProfile($type='') {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $userData = '';
        $data['user_profile'] = '';

        $user_facebook = $this->CI->facebook->is_authenticated();
        // pre($user_facebook);
        if ($user_facebook) { // facebook

            $enduser = $this->userFacebookInfo(); //$this->CI->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');

            $userData['oauth_uid']      = $enduser['id'];
            $userData['oauth_provider'] = 'facebook';
            $userData['profile_url']    = 'https://www.facebook.com/'.$enduser['id'];
            $userData['first_name']     = $enduser['first_name'];
            $userData['last_name']      = $enduser['last_name'];
            $userData['email']          = $enduser['email'];
            $userData['gender']         = $enduser['gender'];
            $userData['locale']         = $enduser['locale'];
            $userData['avatar_url']     = $enduser['picture']['data']['url'];

            // Insert or update user data
            $userID = $this->CI->enduser_model->checkUser($userData);

            if(!empty($userID)){
                $userData['user_id'] = $userID;
                $userData = (object)$userData;
                $this->CI->session->set_userdata($this->_session_enduser, $userData);
            } 

            return (object)$userData;
        }


        if($type != 'fb') {
            // google plus
            $code = $this->CI->input->get('code');

            if($code && $user_facebook == '') {

                $this->CI->googleplus->getAuthenticate();
                $enduser = $this->CI->googleplus->getUserInfo();

                $userData['oauth_uid']      = $enduser['id'];
                $userData['oauth_provider'] = 'google';
                $userData['profile_url']    = $enduser['link'];
                $userData['first_name']     = $enduser['given_name'];
                $userData['last_name']      = $enduser['family_name'];
                $userData['email']          = $enduser['email'];
                $userData['gender']         = $enduser['gender'];
                $userData['locale']         = $enduser['locale'];
                $userData['avatar_url']     = $enduser['picture'];

                // Insert or update user data
                $userID = $this->CI->enduser_model->checkUser($userData);

                if(!empty($userID)){
                    $userData['user_id'] = $userID;
                    $userData = (object)$userData;
                    $this->CI->session->set_userdata($this->_session_enduser,$userData);
                }

                return (object)$userData;
            }
        }
    }


    /**
     * Facebook url login
     * @return string
     */
    function facebookUrlLogin() {
        return $this->CI->facebook->login_url();
    }

}