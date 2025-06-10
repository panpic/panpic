<?php

/**
* Library for Sitemap
* Last update 19 Feb 2024
* 
* @package library
* @copyright PhongKhamLaoPhoi
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 19 Feb 2024
*/

class Sitemap_lib {

    public $CI;
    
    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    function sitemap_main(){
        return array(
            1 => array(
                'loc' => 'https://www.panpic.vn',
                'priority' => '1.0',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            2 => array(
                'loc' => 'https://www.panpic.vn/gioi-thieu',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            3 => array(
                'loc' => 'https://www.panpic.vn/lich-su',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            4 => array(
                'loc' => 'https://www.panpic.vn/co-cau-to-chuc',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            5 => array(
                'loc' => 'https://www.panpic.vn/co-cau-to-chuc',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            6 => array(
                'loc' => 'hhttps://www.panpic.vn/gia-tri-cot-loi',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            6 => array(
                'loc' => 'https://www.panpic.vn/khach-hang',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),

            7 => array(
                'loc' => 'https://www.panpic.vn/thiet-ke-website',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            8 => array(
                'loc' => 'https://www.panpic.vn/viet-phan-mem-theo-yeu-cau',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            9 => array(
                'loc' => 'https://www.panpic.vn/cham-soc-bao-tri-quan-ly-website',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            10 => array(
                'loc' => 'https://www.panpic.vn/thiet-ke-do-hoa-graphic-design',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            11 => array(
                'loc' => 'https://www.panpic.vn/mobile-app',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            12 => array(
                'loc' => 'https://www.panpic.vn/bang-gia-hosting-host-vps-linux',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            13 => array(
                'loc' => 'https://www.panpic.vn/bang-gia-ten-mien-website',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            14 => array(
                'loc' => 'https://www.panpic.vn/web-seo',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            15 => array(
                'loc' => 'https://www.panpic.vn/quang-cao-online',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            16 => array(
                'loc' => 'https://www.panpic.vn/du-an/phan-mem-web-app',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            17 => array(
                'loc' => 'https://www.panpic.vn/du-an/website-dich-vu-san-pham',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            18 => array(
                'loc' => 'https://www.panpic.vn/du-an/website-doanh-nghiep',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            19 => array(
                'loc' => 'https://www.panpic.vn/du-an/website-khac',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            20 => array(
                'loc' => 'https://www.panpic.vn/du-an/nam-2024',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            21 => array(
                'loc' => 'https://www.panpic.vn/du-an/nam-2023',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            22 => array(
                'loc' => 'https://www.panpic.vn/du-an/nam-2022',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            23 => array(
                'loc' => 'https://www.panpic.vn/du-an/nam-2021',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            24 => array(
                'loc' => 'https://www.panpic.vn/du-an/nam-2020',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            25 => array(
                'loc' => 'https://www.panpic.vn/du-an/testimonial',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            26 => array(
                'loc' => 'https://www.panpic.vn/web-blog',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            27 => array(
                'loc' => 'https://www.panpic.vn/faq',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            28 => array(
                'loc' => 'https://www.panpic.vn/khach-hang',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            29 => array(
                'loc' => 'https://www.panpic.vn/mau-giao-dien-web',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            30 => array(
                'loc' => 'https://www.panpic.vn/tin-video',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            31 => array(
                'loc' => 'https://www.panpic.vn/tin-tuyen-dung',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            32 => array(
                'loc' => 'https://www.panpic.vn/tai-lieu/profile',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            33 => array(
                'loc' => 'https://www.panpic.vn/tai-lieu/catalogue',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            34 => array(
                'loc' => 'https://www.panpic.vn/lien-he',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            35 => array(
                'loc' => 'https://www.panpic.vn/cam-ket-chat-luong',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            36 => array(
                'loc' => 'https://www.panpic.vn/dieu-khoan-su-dung',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
            37 => array(
                'loc' => 'https://www.panpic.vn/chinh-sach-bao-mat',
                'priority' => '0.8',
                'lastmod' => '2024-09-19T14:46:49+00:00'
            ),
        );
    }

    
}    
