<?php
/**
* Library Nested Algorilthm
* Last update 12 May 2012
* 
* @package library
* @copyright PANPIC
* @author contact@panpic.vn
* @author position: PHP Developer
* @since 12 May 2012
*/

class Nestedpostcat_library {

    public $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    /**
     * combobox career nested
     *
     * @param array mix $data
     * @param string $action
     * @param int $id_edit
     * @param array row $row
     * @return string
     */
    function cmbNested($data, $action = '', $id_edit = '', $row = '') {
        $cat_name = '';
        $cmb = '';
        $arr = array();

        if ( sizeof($data) > 0 ) {
            foreach ($data as $key => $val) {

                $id     = $val['post_cat_id'];
                $parents= $val['parents'];
                $level  = $val['level'];
                $lft    = $val['lft'];
                $rgt    = $val['rgt'];
                $levelCss = '';

                if ($action == 'edit' && $id_edit == $id) {
                    $post_cat_id= $val['post_cat_id'];
                    $cat_name   = $val['cat_name'];
                    $cat_icon   = $val['cat_icon'];
                    $seo_title  = $val['seo_title'];
                    $seo_description = $val['seo_description'];
                }

                if ($level == 0) {
                    $name = '<span style="color:red">--- ' . $val['cat_name'] . ' ---</span>';
                } else if ($level == 1) {
                    $name = '<b>+ ' . $val['cat_name'] . '</b>';
                } else {
                    $name = $this->stringChar($val['level']) . $val['cat_name'];
                    $levelCss = 'padding-left:' . (5 * $val['level']) .'px;';
                }

                if ($action == 'edit' && $row != '' && $id == $row['parents']) {
                    $selected = 'selected="selected"';
                } elseif ($action == 'sub' && $id == $id_edit) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }

                $cmb .= '<option value="' . $id . '" ' . $selected . ' style="' . $levelCss . '">' . $name . '</option>';
            }

            if ( $cat_name != '' ) {
                $arr['post_cat_id'] = $post_cat_id;
                $arr['cat_name'] = stripslashes($cat_name);
                $arr['cat_icon'] = $cat_icon;
                $arr['seo_title'] = stripslashes($seo_title);
                $arr['seo_description'] = $seo_description;
            }
        }

        $arr['cmb'] = $cmb;
        return $arr;
    }

    function cmbNoRoot($data, $action = '', $id_edit = '') {
        $cmb = '';
        $arr = array();

        if (sizeof($data) > 0) {
            foreach ($data as $key => $val) {

                $id = $val['post_cat_id'];
                $cat_name = stripslashes($val['cat_name']);
                $level = $val['level'];
                $levelCss = '';

                if ($level > 0) {
                    if ($level == 1) {
                        $name = $cat_name;
                    } else {
                        $name = $this->stringChar($val['level']).' &nbsp; '. $cat_name;
                        $levelCss = 'padding-left:' . (5 * $val['level']) .'px;';
                    }

                    $selected = ($action == 'sub' && $id == $id_edit) ? 'selected="selected"' : '';

                    $cmb .= '<option value="' . $id . '" ' . $selected . ' style="' . $levelCss . '">' . $name . '</option>';
                }
            }

            $arr['cmb'] = $cmb;
        }

        return $arr;
    }

    /**
     * @param $tree - menu data array
     * @param $parent - 0
     * 
     * @return $arr menu true: parent node to last sub
     */
    function formatTree($tree, $parent) {
        $tree2 = null;
        foreach ($tree as $i => $item) {
            if ($item['parents'] == $parent) {
                $tree2[$item['post_cat_id']] = $item;
                $tree2[$item['post_cat_id']]['submenu'] = $this->formatTree($tree, $item['post_cat_id']);
            }
        }

        return $tree2;
    }

    function groupSubMenuByParent($data) {
        $temp = array();

        foreach ($data as $key => $val){
            if($val['level'] == 1) {
                $val['sub'] = $this->formatTree($data, $val['post_cat_id']);
                $temp[$val['post_cat_id']] = $val;
            }
        }

        return $temp;
    }

    /**
     * string space level of category
     *
     * @param int $int
     * @return string
     */
    function stringChar($int) {
        $char = '-';
        $n = 1;
        while ($n < $int) {
            $char .= ' - ';
            $n++;
        }

        return $char;
    }

    /**
     * Categories return catID String
     *
     * @param array mix $cats
     * @return string Id
     */
    function catStringID($cats) {
        $i = 1;
        $strId = '';
        if (empty($cats))
            return;

        foreach ($cats as $vl) {
            $strId .= ($i > 1) ? ',' . $vl['post_cat_id'] : $vl['post_cat_id'];

            $i++;
        }

        return $strId;
    }

    /**
     * Multi Selected
     * Jan 10 2017
     * 
     * @param array mix $data
     * @param string $action
     * @param array row $id_edit
     * @param array mix $row
     * @return string
     */
    function cmbpost_cat_idLanding($data, $action = '', $id_edit, $row = '') {
        $cat_name = '';
        $cmb = '';
        $arr = array();

        if (sizeof($data) > 0)
            foreach ($data as $key => $val) {

                $id = $val['post_cat_id'];
                $parents = $val['parents'];
                $level = $val['level'];
                $lft = $val['lft'];
                $rgt = $val['rgt'];
                $levelCss = '';

                if ($action == 'edit' && array_key_exists($id, $id_edit)) {
                    $post_cat_id = $val['post_cat_id'];
                    $cat_name = $val['cat_name'];
                    $cat_icon = $val['cat_icon'];
                    $seo_title = $val['seo_title'];
                    $seo_description = $val['seo_description'];
                }


                if ($level == 0) {
                    $name = '<span style="color:red">--- ' . $val['cat_name'] . ' ---</span>';
                } else if ($level == 1) {
                    $name = '<b>+ ' . $val['cat_name'] . '</b>';
                } else {
                    $name = $this->stringChar($val['level']) . $val['cat_name'];
                    $levelCss = 'padding-left:' . (5 * $val['level']) . 'px;';
                }

                if ($action == 'edit' && !empty($row) && $id == $row['parents']) {
                    $selected = 'selected="selected"';
                } elseif ($action == 'sub' && array_key_exists($id, $id_edit)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }

                $cmb .= '<option value="' . $id . '" ' . $selected . ' style="' . $levelCss . '">' . $name . '</option>';
            }

        if ($cat_name != '') {
            $arr['post_cat_id'] = $post_cat_id;
            $arr['cat_name'] = $cat_name;
            $arr['cat_icon'] = $cat_icon;
            $arr['seo_title'] = $seo_title;
            $arr['seo_description'] = $seo_description;
        }

        $arr['cmb'] = $cmb;
        return $arr;
    }

    /**
     * 
     * @param type $data
     * @return string
     */
    function parseNested($data) {
        $temp = array();
        
        foreach ($data as $key => $val) {

            $post_cat_id = $val['post_cat_id'];
            $level = $val['level'];
            $cat_name = $val['cat_name'];
            $cat_icon = $val['cat_icon'];
            $seo_title = $val['seo_title'];
            $seo_description = $val['seo_description'];

            if ($level > 0) {
                
                if ($level == 1) {
                    $name = '<b>+ ' . $val['cat_name'] . '</b>';
                } else {
                    $name = $this->stringChar($val['level']) . $val['cat_name'];
                    $padding = 'padding-left:' . (5 * $val['level']) . 'px;';
                }

                $val['cat'] = $name;
                $val['padding'] = $padding;
                $temp[] = $val;
            }
        }

        return $temp;
    }

    function groupSub($data) {
        $temp = array();
        
        foreach ($data as $key => $val){
            if($val['level'] == 1) {
                $val['sub'] = $this->formatTree($data, $val['post_cat_id']);
                $temp[] = $val;
            }
        }

        return $temp;
    } 

    function parseBlogs($categories, $blogs){
        $temp = array();
        if($categories != '' && $blogs != '') {
            foreach ($categories as $cat) {
                $i=1;
                foreach ($blogs as $vl) {
                    if($vl['category_id'] == $cat['post_cat_id'] && $i <= 3) {
                        $cat['news'][] = $vl;
                        $temp[$cat['post_cat_id']] = $cat;
                        $i++;
                    }
                }
            }
        }

        return $temp;
    }

    function sortCategory($array, $key='posts_no', $direction='ASC'){
        switch ($direction){
            case "ASC":
                usort($array, function ($first, $second) use ($key) {
                    return $first[$key] <=> $second[$key];
                });
                break;
            case "DESC":
                usort($array, function ($first, $second) use ($key) {
                    return $second[$key] <=> $first[$key];
                });
                break;
            default:
                break;
        }

        return $array;
    }

    function services_menu_home($arr){
        $temp = array();
        foreach ($arr as $vl){
            if($vl['home_status'] == ACTIVE) {
                $temp[] = $vl;
            }
        }

        return $temp;
    }

}