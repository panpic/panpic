<?php

/**
* Library Cach tinh ngay du sinh
* Last update 25 Feb 2020
* 
* @package library
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 25 Feb 2020
*/

class Calculator_dayborn {

    var $CI = '';
    private $_chu_ky_chuan = 28; //days
    private $_day_40_week = 280; // days = 40 week
    
    function __construct()
    {
        $this->CI = & get_instance();
    }


    function caculator($d, $k)
    {

        // Tinh So Ngay chenh lech chu ky chuan
        $chenh_lech_chu_ku = $k - $this->_chu_ky_chuan;

        // Tinh ngay du sinh chuan theo chu ky 40 weeks
        $date_select = date('Y-m-d', strtotime($d));
        $date = date_create($date_select);
        date_add($date, date_interval_create_from_date_string("$this->_day_40_week days"));
        $date_born_standard = date_format($date,"Y-m-d");

        // Chuyen date thanh phep tinh cong tru
        $date = date_create(date('Y-m-d', strtotime($date_born_standard)) );

        if($chenh_lech_chu_ku > 0) {

            date_add($date, date_interval_create_from_date_string("$chenh_lech_chu_ku days"));
            return date_format($date, "d-m-Y");

        } elseif($chenh_lech_chu_ku == 0) {

            return date('d-m-Y', strtotime($date_born_standard));

        } else {

            $arr = explode('-',$chenh_lech_chu_ku);
            $day_minus = $arr[1]; // chuyen thanh ngay duong de tru
            date_sub($date, date_interval_create_from_date_string("$day_minus days"));
            return date_format($date, 'd-m-Y');

        }
    }


}