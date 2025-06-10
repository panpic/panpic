<?php

Class Pagination_blog
{
    public $CI;

    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    function pagination($base_url, $total_rows, $per_page, $uri_segment, $more_url ='', $flag='', $num_links=5){
        $this->CI->load->library('pagination');
        $config = array();
        $config['base_url']  = $base_url;

        if ( count($_GET) > 0 ) {
            if($more_url) {
                $config['suffix']    = "&".$more_url;
            }
          $config['first_url'] = $base_url.$more_url;
        }

        if($more_url){
            if($more_url) {
                $config['suffix']    = "&".$more_url;
            }
            $config['first_url'] = $base_url."?per_page=1&".$more_url;
        }

        if($flag){
            if($more_url) {
                $config['suffix']    = "&".$more_url;
            }

            $config['first_url'] = $base_url.$more_url; //$config['base_url'].'?'.http_build_query($_GET,'', "&");
        }

        $config['per_page'] = $per_page;
        $config['total_rows'] = $total_rows;
        $config['uri_segment'] = $uri_segment;
        $config['num_links'] = ($num_links) ? $num_links : 5;

        $config['full_tag_open'] = '<ul class="pagination list-unstyled mb-0">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>'; /*class="prev"*/
        $config['first_tag_close'] = '</li>';
        $config['first_link'] = '‹';
        $config['last_tag_open'] = '<li>'; /*class="next"*/
        $config['last_tag_close'] = '</li>';
        $config['last_link'] = '›';
        $config['prev_tag_open'] = '<li>'; /*class="prev"*/
        $config['prev_tag_close'] = '</li>';
        $config['prev_link'] = '‹‹';
        $config['next_tag_open'] = '<li>'; /*class="next"*/
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = '››';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
            
        $this->CI->pagination->initialize($config);
    }

}