<?php

Class Blogcategory_library
{
    var $CI = ''; 
    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    

    public function category_icon($path) {
        return array(
            1 => '<span class="color-blue"><img src="'.$path.'icon-meohay.png"></span>',
            2 => '<span class="color-green"><img src="'.$path.'icon-trainghiem.png" ></span>',
            3 => '<span class="color-orange"><img src="'.$path.'icon-amthuc.png" ></span>',
        );

    }

    public function cate_icon(){
         return array(
            1 => 'meo-hay.jpg',
            2 => 'trai-nghiem.jpg',
            3 => 'symbol5.png',
            );
    }

}