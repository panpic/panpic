<?php
/**
* Model Products_mode
* Last update 16 Nov 2018
* 
* @package backend
* @copyright PANPIC
* @author @contact@panpic.vn
* @author position: Panpic's Developer Team
* @since 16 Nov 2018
*/

class Products_model extends MY_Model
{
    
    private $_pp_product_translate = 'pp_product_translate';
    private $_pp_product_category_desc = 'pp_product_category_desc';
    private $_pp_product    = 'pp_product';
    private $_pp_images = 'pp_images';

    public $id,
        $current_lang,
        $page_lang,
        $default_lang;


    public function __construct(){

    }

    
    function getKeyString() { return " a.product_id = $this->id "; }
    
    
    function get_slug_exist($slug, $product_id='') {
        $cond = ($product_id != '') ? " AND product_id <> $product_id " : '';
        $sql = "SELECT slug FROM $this->_pp_product_translate WHERE slug = '$slug' $cond";
        $exist_slug = $this->db->query($sql)->row()->slug;
        
        if($exist_slug) {
            $exist_slug .= "$this->current_lang-1";
            return $this->get_slug_exist($exist_slug);
        }
        
        return $slug;
    }
    
    
    /**
     * Get item by Id
     * 
     * @param $id int
     * @param string $cond_image
     * @return array
     */
    function getItemById($cond_image=" AND c.image_type = 'R' "){
        if($this->id == '') return;
        
        $sql = "SELECT a.sku, a.category_id, a.product_price, a.product_sale_percent, a.post_type, a.brand, a.date_add, a.avail, a.admin_verify, a.hot_status, b.*, c.image_id, c.path_image, c.path_image_thumb
                FROM $this->_pp_product AS a 
                JOIN  $this->_pp_product_translate AS b ON a.product_id = b.product_id AND b.lang = '$this->current_lang'
                LEFT JOIN $this->_pp_images AS c ON a.product_id = c.object_id $cond_image 
                WHERE ".$this->getKeyString();

        return $this->db->query($sql)->row_array();
    }


    function getItemByCond($cond, $cond_image=" AND c.image_type = 'R' "){

        $sql = "SELECT a.sku, a.category_id, a.product_price, a.product_sale_percent, a.post_type, a.brand, a.date_add, a.avail, a.admin_verify, a.hot_status, b.*, c.image_id, c.path_image, c.path_image_thumb
                FROM $this->_pp_product AS a 
                JOIN  $this->_pp_product_translate AS b ON a.product_id = b.product_id $cond 
                LEFT JOIN $this->_pp_images AS c ON a.product_id = c.object_id $cond_image";

        return $this->db->query($sql)->row_array();
    }
    
    
    function getSlugById(){
        if($this->id == '') return;
        
         $sql = "SELECT * FROM $this->_pp_product_slug WHERE product_id = $this->id";
        return $this->db->query($sql)->row_array();
    }


    /**
     * Insert multi language
     *
     * @param array $params
     * @param array $_data
     * @return bool
     */
    function insertItem($params, $_data=''){
        $this->db->trans_begin();
        
            $this->db->insert($this->_pp_product, $params);
            $primary = $this->db->insert_id();

            if($_data) {
                // multi language
                foreach ($this->page_lang as $k=>$vl) {
                    // If english not input
                    if($k != $this->default_lang && $_data[$k]['title'] == '') {
                        $slug = $_data[$this->default_lang]['slug']."-$k";
                        $slug = $this->get_slug_exist($slug);

                        $data = array(
                            'product_id'   => $primary,
                            'lang'      => $k,
                            'slug'      => $slug,
                            'title'     => $_data[$this->default_lang]['title']
                        );
                    } else {
                        $data = $this->builParamsInsert($_data, $k);
                        $data['product_id'] = $primary;
                    }

                    $this->db->insert($this->_pp_product_translate, $data);
                 }
            }
            
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback(); 
            return FALSE; 
        } else {
            $this->db->trans_commit(); 
            return $primary; 
        }
    }


    /**
     * Update item a language
     *
     * @param array $params_translate
     * @param array $params
     * @return bool
     */
    function updateItem($params_translate, $params='') {
        $this->db->trans_begin();

            $this->db->update($this->_pp_product_translate, $params_translate, array('product_id'=>$this->id, 'lang'=>$this->current_lang));

            if($params != '') {
                $this->db->update($this->_pp_product, $params, array('product_id'=>$this->id));
            }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


    /**
     * Duplicate insert new item
     *
     * @param array $params
     * @param array $param_vi
     * @param array $param_en
     * @return bool
     */
    function duplicateItem($params, $param_vi, $param_en) {
        $this->db->trans_begin();

            $this->db->insert($this->_pp_product, $params);
            $primary = $this->db->insert_id();

            $param_vi['product_id'] = $primary;
            $this->db->insert($this->_pp_product_translate, $param_vi);

            if($param_en != '') {
                $param_en['product_id'] = $primary;
                $this->db->insert($this->_pp_product_translate, $param_en);
            }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $primary;
        }
    }


    function getImageByBlogId($product_id, $cond=" AND image_type = '".PRODUCT_TYPE_PRODUCT."' ") {
        if($product_id == '') return;

        $sql = "SELECT * FROM $this->_pp_images WHERE object_id = $product_id $cond";
        return $this->db->query($sql)->row_array();
    }


    function insertImage($params) {
        if($params == '') return;

        return $this->db->insert($this->_pp_images, $params);
    }


    function updateImage($params, $image_id) {
        if($params == '' || $image_id == '') return;

        return $this->db->update($this->_pp_images, $params, array('image_id' => $image_id));
    }


    function updateBlogByFields($params) {
        if($this->id == '') return;
        
        return $this->db->update($this->_pp_product, $params, array('product_id' => $this->id) );
    }


    function updateBlogTranslateByFields($params) {
        if($this->id == '' || $this->current_lang == '') return;

        return $this->db->update($this->_pp_product_translate, $params, array('product_id' => $this->id, 'lang' => $this->current_lang) );
    }


    /**
     * Remove physycle
     *
     * @param $where
     */
    function deleteItem($where) {
        if(!$where) return;

        $this->db->trans_begin();

            $this->db->delete($this->_pp_product, $where);
            $this->db->delete($this->_pp_product_translate, $where);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    
    function countItems($cond) {
        $sql = "SELECT COUNT(a.product_id) AS total FROM $this->_pp_product AS a
                JOIN $this->_pp_product_translate AS b ON a.product_id = b.product_id AND b.lang = '$this->current_lang'
                $cond";
        
        return $this->db->query($sql)->row()->total;
    }
    
    
    function getItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";
        
        $sql = "SELECT a.*, b.*, d.cat_name, i.path_image, i.path_image_thumb 
              FROM $this->_pp_product AS a JOIN $this->_pp_product_translate AS b ON a.product_id = b.product_id AND b.lang = '$this->current_lang' 
              LEFT JOIN $this->_pp_product_category_desc AS d ON a.category_id = d.product_cat_id 
              LEFT JOIN pp_images AS i ON a.product_id = i.object_id 
              $cond 
              GROUP BY b.product_id ORDER BY a.date_add DESC $limit";
        
        return $this->db->query($sql)->result('array');
    }
    
    
    function blogCategories($cond=''){
        $sql = "SELECT * FROM $this->_pp_product_category_desc $cond";
        return $this->db->query($sql)->result('array');
    }


    /**
     * Build param items before insert update database
     *
     * @param array $_data
     * @param string $lang
     * @return array
     */
    function builParamsInsert($_data, $lang) {

        $title_slug = url_convert($_data[$lang]['slug']);
        $slug = $this->get_slug_exist($title_slug);

        return array(
            'lang'          => $lang,
            'title'         => addslashes($_data[$lang]['title']),
            'slug'          => $slug,
            'short'         => addslashes($_data[$lang]['short']),
            'content'       => addslashes($_data[$lang]['content']),
            'technical'     => addslashes($_data[$lang]['technical']),
            'seo_title'     => trim(strip_tags($_data[$lang]['seo_title'])),
            'seo_description'=> trim(strip_tags($_data[$lang]['seo_description'])),
            'home_status'    => $_data[$lang]['home_status'],
        );
    }


    function getGalleryItems($cond='', $num='', $offset=''){
        $limit = ($num > 0 ) ? "LIMIT $offset, $num" : "";

        $sql = "SELECT c.*, s.slug, s.title, i.image_id, i.date_add AS g_date_add, i.path_image, i.path_image_thumb
                FROM $this->_pp_product AS c 
                JOIN $this->_pp_product_translate AS s ON c.product_id = s.product_id 
                LEFT JOIN pp_images AS i ON c.product_id = i.object_id $cond 
              ORDER BY c.date_add DESC $limit ";

        return $this->db->query($sql)->result('array');
    }
    
    
}