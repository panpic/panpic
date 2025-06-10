<?php
/**
* Library Admin_permission
* Last update 5 Aug 2021
* 
* @package library
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 10 Aug 2017
*/

class Admin_permission {
    
    public $CI;

    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    function arrFunctions() {
        return $arr_permision = array(
            1 => array('control' => 'portfolio','name' => 'Dự án'),
            2 => array('control' => 'blogs','name' => 'Tin tức'),
            3 => array('control' => 'services','name' => 'Lĩnh vực hoạt động'),
            4 => array('control' => 'download','name' => 'Tài liệu'),
            5 => array('control' => 'blogcat','name' => 'Danh mục'),
            6 => array('control' => 'banner','name' => 'Banner'),
            7 => array('control' => 'pages','name' => 'Quản lý trang'),
        );
    }

    /**
     * 
     * k/tra quyen truy cap cua admin
     *
     * @string $current_control 
     * @return bool
     */
    function myPermission($current_control, $adminPermission) {
        $arr = explode( ',', $adminPermission);
        $arr_permision = $this->arrFunctions();
        foreach ($arr as $vl) {
            $control = $arr_permision[$vl];
            if (array_key_exists($vl, $arr_permision) && $current_control == $control['control']) {
                    return true;
            }
        }

        return false;
    }
    

}