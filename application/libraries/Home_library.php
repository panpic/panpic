<?php

/**
* Library for Home
* Last update 20 Feb 2020
* 
* @package library
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 17 Jan 2020
*/

class Home_library {

    var $CI = ''; 
    
    function __construct()
    {
        $this->CI = & get_instance();
    }
    

    function parseItemsByCategory($arr) {
        $temp = array();
        foreach ($arr as $item) {
            $temp[$item['category_id']]['category'] = $item;
            $temp[$item['category_id']]['services'][$item['blog_id']] = $item;
        }

        return $temp;
    }


    function downloadItemsByCategory($arr) {
        $temp = array();
        $i=1;
        foreach ($arr as $item) {

            $blog_id = ($item['blog_id'] == '') ? $i : $item['blog_id'];

            $temp[$item['post_cat_id']]['category'] = $item;
            $temp[$item['post_cat_id']]['services'][$blog_id] = $item;

            $i++;
        }

        return $temp;
    }


    function parseCategoryBlogParent($arr) {
        $temp = array();
        foreach ($arr as $item) {
            $temp[$item['parents']][$item['post_cat_id']] = $item;
        }

        return $temp;
    }


    function parsePos($arr) {
        $temp = array();
        foreach ($arr as $item) {
            $temp[$item['post_comment']][] = $item;
        }

        return $temp;
    }

    
}    
