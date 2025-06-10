<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**
* Controllers Frontend
* Last update 12 Oct 2017
*
* @package Frontend Login Social
* @copyright PANPIC
* @author contact@panpic.vn
* @author pos: PHP Developer
* @since 13 Jan 2017
*/



class Index extends FRONT_Controller{

    

    private $_data;
    private $_control;
    private $_session_enduser;
    private $_user_data;
    private $_social;
    private $_pathThumb;
    private $_agency_session;


    public function __construct(){

        parent::__construct();

        $this->load->model('index_model');
        $this->load->helper('location_helper'); //transport_icon
        $this->load->helper('icon_helper'); 

        $this->_data['base_url'] = base_url();
        $this->_data['base_tlp_front'] = $this->config->item("base_tlp_front");
        $this->_data['base_url_front'] = $this->config->item("base_url_front");
        $this->_data['search_tour']  = base_url().'search/autocomplete/';

        $this->_control = $this->router->class;
        $this->_data['current_control'] = $this->_control;
        $this->_data['current_method'] = $this->router->method;
        $this->_data['lable'] = $this->lable;
        $this->_data['share'] = ''; 

        $this->_session_enduser     = $this->config->item("session_enduser");
        $this->_dirCate             = $this->config->item('dir_category');
        $this->_data['pathCate']    = base_url().$this->_dirCate;
        $this->_dirThumb            = $this->config->item('dir_thumb');
        $this->_data['pathThumb']   = base_url().$this->_dirThumb;
        $this->_dirLogo             = $this->config->item('dir_logo');
        $this->_data['pathLogo']    = base_url().$this->_dirLogo;

        $this->_user_data = $this->session->userdata($this->_session_enduser);

        if($this->_user_data == '') {
            $this->load->library('sociallogin');
            $this->_user_data = $this->sociallogin->socialProfile();
            if(! $this->_user_data) {
                $this->_social = array(
                    'facebook_login'   => $this->sociallogin->facebookUrlLogin(),
                    'googleplus_login' => $this->sociallogin->googleplusUrlLogin()
                );
            }
        }

        $this->_data['social']    = $this->_social;
        $this->_data['user_data'] = $this->_user_data;

        //load ip address
        $user_ip = getenv('REMOTE_ADDR');
        $detail = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
        $geo_location = geo_location($detail); 

        $ss_location   = $this->session->userdata('ss_location');
        $ss_name_location   = $this->session->userdata('ss_name_location');
        $this->_data['ss_name_location'] = $ss_name_location;
        $geo_location = ($ss_location == '') ? $geo_location : $ss_location;
        $this->_data['geo_location'] = $geo_location; 

        $this->load->model('main_model'); 

        $this->_session_agency = $this->config->item('session_agency');
        $this->_agency_session = $this->session->userdata($this->_session_agency);
        $this->_data['session_agency'] = $this->_agency_session;

    }


    public function index(){
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $number_items = 10;

        $tour_per_category = $this->index_model->getinfotourdestination($number_items);

        $group = array();

        foreach ( $tour_per_category as $value ) {
            $temp = array('cat_name' => $value['cat_name'], 'cat_id' => $value['category_destination_id']);
            $group[$value['category_destination_id']] = $temp;
        }

//         echo '<pre>';
//         print_r($group);
//         echo '</pre>'; die;


        foreach ($group as $k => $vl) {

            $t = array();
            $i = 0;
            foreach ($tour_per_category as $tour) {

                $arr_destination = explode(',', $tour['tour_destination_id']);
                
                if (in_array($k, $arr_destination)) {
                    $t[]  = $tour;
                    unset($tour_per_category[$i]);
                }
                
                $i++;
            }

            $group[$k]['tour'] = $t;
        }

        $this->_data['group'] = $group;

        $infoviewmost=$this->index_model->getInfoTourviewmost();
        $this->_data['infoviewmost']  =  $infoviewmost;

        $infoSearch=$this->index_model->getInfoTourdestinationDesc();
        $this->_data['infoSearch']  =  $infoSearch;

        $seo = array(
            'seo_title'     => $this->lable['seo_homepage_title'],
            'seo_keyword'   => $this->lable['seo_homepage_keyword'],
            'seo_description'=> $this->lable['seo_homepage_description']
        );

        $this->_data['seo'] = $seo;
        //custom 170315
        $this->load->model('general_model');
        $general_hotel = $this->general_model->selectItemsCustom("'hotel'");
        $this->_data['general_hotel'] = $general_hotel;

        $this->load->library('blogcategory_library');
        $url_icon = $this->config->item("base_tlp_front").'/images/';
        $icons = $this->blogcategory_library->category_icon($url_icon);

        $this->_data['category_icons'] = $icons;

        $tour_destination = $this->index_model->get_tour_destination(); 

        $where = " AND p.package_type IN(2,3) AND DATEDIFF(pa.expired_date, now()) >= 0";

        $tour = $this->index_model->get_tour_package_expired(); // mysql view //get_tour('', $where, '');
        $tour_location = $this->index_model->get_location();
        $agency = $this->index_model->get_agency();

        // RECENT VIEW 
        $idTourView = $this->session->userdata('tour_view'); 

        $tourRecent = '';

        if($idTourView) {
            $tmp = array(); 

            foreach($idTourView as $vl){
                $tmp[] = $vl['tour_id'];
            }

            $ids = implode(',', $tmp);
            $cond1 = " WHERE FIND_IN_SET(t.tour_id, '$ids') ";
            $tourRecent = $this->index_model->get_tour($cond1,'', "LIMIT 15");
            $this->_data['tourRecent'] = $tourRecent;
        }

        $this->_data['tourRecent'] = $tourRecent;
        $this->_data['tour_destination']  =  $tour_destination;
        $this->_data['tour']  =  $tour;
        $this->_data['agency']  =  $agency;
        $this->_data['tour_location'] = $tour_location;
        //session lasted view tour

        $array = $this->session->userdata('tour_id');
        // $temp = $this->_model->getListMember("FIND_IN_SET(id, '$comma_separated')");
        $last_view = $this->index_model->get_tour();
        $blog = $this->index_model->blogCategories();

        $this->_data['blog'] = $blog;
        $this->_data['action_url'] = base_url().'search';
        $this->_data['mobile_thailan'] = $tour_destination[6];

        $this->parser->parse("index/index.tpl", $this->_data);
    }


}