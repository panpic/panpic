<?php
/**
 * Controllers Backend
 * Last update 30 August 2018
 *
 * @package backend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author position: Panpic's Developer Team
 * @since 30 August 2018
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends MY_Controller{


    private $_post_type;
    public $path_upload;

    public function __construct(){
        parent::__construct();

        $this->_post_type = POST_TYPE_OTHER;

        $this->load->library('webp_lib');
        $this->path_upload = $this->_path_upload;

        $this->_data['dir_path']  = $this->_path_upload;
        $this->_data['link_upload']  = $this->_link_upload;

        $image_type = array(
            POST_TYPE_PORTFOLIO => 'Dự án',
            POST_TYPE_BLOG  => 'Blog',
            POST_TYPE_SERVICES => 'Lĩnh vực hoạt động',
            POST_TYPE_SERVICES_GALLERY  => 'Gallery dự án',
            POST_TYPE_DOWNLOAD => 'Tài liệu',
            POST_TYPE_TESTIMONIAL => 'Testimonial',
            POST_TYPE_EVENT => 'Event',
            POST_TYPE_ALBUM => 'Album',
            POST_TYPE_ALBUM_DETAIL => 'Album Gallery',
            POST_TYPE_VIDEO     => 'Video',
            POST_TYPE_FAQ       => 'FAQ',
            POST_TYPE_LETTERS    => 'Letters',
            POST_TYPE_REDCRUITMENT => 'Recruitment',
            POST_TYPE_OTHER => 'Other'
        );

        $this->_data['image_type'] = $image_type;

        $this->load->model('media_model');
        $this->load->library('slim_library');
        $this->load->library('admin_permission');

        $session_admin = $this->_data['user_data'];
        $adminPermission= $session_admin->adminPermission;

        // echo $adminPermission;
        // echo $this->_control;
        // die;

        $super_admin = $this->config->item("super_admin");
        if($session_admin->adminRole != $super_admin) {
            if($this->admin_permission->myPermission($this->_control, $adminPermission) == false) {
                redirect(admin_url('index/notpermission'));
            }
        }
    }

    /**
     * Form add
     *
     */
    function index(){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $this->_data['breadcrumb'] = $this->lable['media'];
        $this->_data['alert'] = '';

        $id = $this->input->get('id');
        $option= $this->input->get('option');
        $option = !empty($option) ? $option : OPTION_ADD;
        $this->_data['option'] = $option;
        $this->_data['task'] = $this->lable[$option];

        $data = array();

        if (!empty($id) && $option == 'edit') {
            $this->media_model->id = $id;
            $data = $this->media_model->getImageById();
        }

        $this->_data['data'] = $data;
        $this->_data['valid'] = '';

        $this->parser->parse("media/index.tpl", $this->_data);
    }

    /**
     * Process form add
     */
    function add() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $_data = $this->input->post('data');
        $id = $this->input->post('primary');

        $option = $this->input->post('option');
        $option = ($option == '') ? OPTION_ADD : $option;
        $this->_data['task'] = $this->lable[$option];
        $this->_data['option'] = $option;
        $this->_data['breadcrumb'] = $this->lable['media'];

        $year  = date('Y');
        $month = date('m');
        $day   = date('d');

        $file_path_year = $this->_path_upload.'/'.$year;
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year.'/'. $month;
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month.'/'. $day ;
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

        $new_path = $year.'/'.$month.'/'.$day.'/';
        $images     = $this->slim_library->getImages('path_image');
        $image      = $images[0];
        $new_img    = $image['output']['name'];

        if($new_img){
            $data_img   = $image['output']['data'];
            $flag_change_img = 0;

            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name'];

            // Thumbnail jpg
            $path_thumb = $this->do_resize_thumb($path_image, $new_path);

            $webp = $this->webp_lib->convert($this->path_upload.$path_image);
            if($webp->status == ACTIVE){
                unlink($this->path_upload.$path_image);
                $path_image = $new_path.$webp->file;
            }

            $params = array(
                'object_id'     => 0,
                'title'         => $_data['title'],
                'image_type'    => $this->_post_type,
                'path_image'    => $path_image
            );

            if($path_thumb != '') {
                $image_thumb = $new_path.$path_thumb;
                $webp_thumb = $this->webp_lib->convert($this->path_upload.$image_thumb);

                if($webp_thumb->status == ACTIVE){
                    unlink($this->path_upload.$image_thumb);
                    $path_image_thumb = $new_path.$webp_thumb->file;
                }

                if($path_image_thumb) {
                    $params['path_image_thumb'] = $path_image_thumb;
                }
            }

            if (!empty($id) && $option == OPTION_EDIT) { //Update

                $old = $this->input->post('old');
                $old_img = $old['path_image'];
                $old_img_thumb = $old['path_image_thumb'];
                $old_file_name = $this->slim_library->oldImageName($old_img);

                if($old_img != '' && $old_file_name != $filename) {

                    unlink( $this->_path_upload.'/'.$old_img );
                    unlink( $this->_path_upload.'/'.$old_img_thumb );

                    $this->media_model->id = $id;
                    $imageOldExist = $this->media_model->getImageById($id);

                    if($imageOldExist != '') {
                        unlink( $this->_path_upload.'/'.$imageOldExist['path_image_thumb'] );
                        // $image_id = $old['image_id'];
                        // $this->media_model->updateImage($params, $id);
                    } else {
                        // $this->media_model->insertImage($params);
                    }
                    $flag_change_img = 1;
                } else { // insert
                    // $this->blogs_model->insertImage($params);
                }

                $update = $this->media_model->updateImage($params, $id);

                if ($update) {
                    $back_url = admin_url("media/items/");
                    $this->_data['alert'] = 'success';
                    $this->_data['msg'] = $this->lable['edit_succ'];
                    $this->parser->parse("media/index.tpl", $this->_data);
                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                    return;
                } else {
                    $this->_data['alert'] = 'danger';
                    $this->_data['msg'] = $this->lable['edit_fail'];
                    $this->_data['data'] = $params;
                    $this->parser->parse("media/index.tpl", $this->_data);
                    return;
                }

            } else { //insert

                $insert = $this->media_model->insertImage($params);

                if ($insert) {
                    $back_url = admin_url("media");
                    $this->_data['alert'] = 'success';
                    $this->_data['msg'] = $this->lable['add_succ'];
                    $this->parser->parse("media/index.tpl", $this->_data);
                    header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
                    return;
                } else {
                    $this->_data['alert'] = 'danger';
                    $this->_data['msg'] = $this->lable['add_fail'];
                    $this->_data['data'] = $params;
                    $this->parser->parse("media/index.tpl", $this->_data);
                    return;
                }
            }

        } // new_image

        $back_url = admin_url("media");
        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
        return;
    }

    /**
     * List items
     */
    function items($start=0){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $keyword = $this->input->get('q');
        $category = $this->input->get('cat');

		$tab = $this->input->get('t');
        $tab = ($tab == '') ? 1 : $tab;
        $this->_data['tab'] = $tab;

        $cond = '';
        $more_url = '';
        $keyword = trim(strip_tags($keyword));
        if($keyword){
            $cond .= " (title LIKE '%{$keyword}%' OR path_image LIKE '%{$keyword}%') ";
            $more_url .= "q=$keyword";
            $this->_data['search'] = $keyword;
        }

        if($category) {
            $cond .= " AND c.category = $category ";
            $more_url .= ($more_url == '') ? "cat=$category" : "&cat=$category";
            $this->_data['cat'] = $category;
        }


        $this->_data['alert'] = '';
        $this->_data['breadcrumb'] = $this->lable['event'];

        if($tab == 1) { // all
            $cond .= '';
        }
        if($tab == 2) { // other
            $cond .= ($cond != '') ? ' AND ' : '';
            $cond .= " object_id = 0 ";
        }

        $cond_items = ($cond != '') ? " WHERE $cond " : ''; // " WHERE c.post_type = '$this->_post_type' $cond GROUP BY c.id ";
        $cond_total = ($cond != '') ? " WHERE $cond " : ''; // " WHERE c.post_type = '$this->_post_type' $cond ";

        $totalItems  = $this->media_model->countItems($cond_total);
        $per_page    = $this->lable['per_item_admin'];
        $base_url    = admin_url('media/items');
        $uri_segment = 4;
        $this->load->library('pagination_library');
        $this->pagination_library->pagination($base_url, $totalItems, $per_page, $uri_segment, $more_url, $more_url);
        $this->_data['links'] = $this->pagination->create_links();

        $curpage = $this->input->get('per_page');
        $offset = ($curpage) ? $curpage : 0;
        $start = ($offset > 0) ? (($offset - 1) * $per_page) : $offset;
        $this->_data['items'] = $this->media_model->getItems($cond_items, $per_page, $start);

        $this->parser->parse("media/items.tpl", $this->_data);
    }

    function removemulti() {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $checkAll = $this->input->post('checkAll');
        $event_type = POST_TYPE_EVENT;

        foreach ($checkAll as $id) {
            $this->blogs_model->id = $id;
            $data = $this->blogs_model->getItemById(" AND c.image_type = '$event_type' ");
            @unlink($this->_path_upload.'/'.$data['path_image']);
            @unlink($this->_path_upload.'/'.$data['path_image_thumb']);
            $this->blogs_model->deleteItem( array('id'=>$id) );
        }

        $back_url = admin_url("events/items/");
        $this->_data['alert'] = 'success';
        $this->_data['msg'] = $this->lable['delete_succ'];
        $this->parser->parse("event/items.tpl", $this->_data);
        header("refresh:" . $this->lable['timewait'].";url=".$back_url."");
        return;
    }

    /**
     * Slip upload
     *
     * @param object path_image
     * @param array old
     * @param $blog_id
     */
    function do_slim_upload($blog_id) {
        $year  = date('Y');
        $month = date('m');
        $day   = date('d');

        $file_path_year = $this->_path_upload.'/'.$year;
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year.'/'. $month;
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month.'/'. $day ;
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

        $new_path = $year.'/'.$month.'/'.$day.'/';
        $images     = $this->slim_library->getImages('path_image');
        $image      = $images[0];
        $new_img    = $image['output']['name'];

        if($new_img){
            $data_img   = $image['output']['data'];
            $flag_change_img = 0;

            $file = $this->slim_library->saveFile($data_img, $new_img, $file_path_day);
            $filename = $file['name'];
            $path_image = $new_path.$file['name']; //$file['path']

            $path_image_thumb = $this->do_resize_thumb($path_image);
            $params = array(
                'object_id'     => $blog_id,
                'image_type'    => POST_TYPE_EVENT,
                'path_image'    => $path_image
            );

            if($path_image_thumb != '') {
                $params['path_image_thumb'] = $new_path.$path_image_thumb;
            } else {
                $params['path_image_thumb'] = '';
            }

            $old = $this->input->post('old');
            $old_img = $old['path_image'];
            $old_file_name = $this->slim_library->oldImageName($old_img);

            if($old_img != '' && $old_file_name != $filename) {

                unlink( $this->_path_upload.'/'.$old_img );
                $imageOldExist = $this->blogs_model->getImageByBlogId($blog_id);

                if($imageOldExist != '') {
                    unlink( $this->_path_upload.'/'.$imageOldExist['path_image_thumb'] );
                    $image_id = $old['image_id'];
					$params['path_image_thumb'] = ($params['path_image_thumb'] == '') ? '' : $params['path_image_thumb'];
                    $this->blogs_model->updateImage($params, $image_id);
                } else {
                    $this->blogs_model->insertImage($params);
                }
                $flag_change_img = 1;
            } else { // insert
                $this->blogs_model->insertImage($params);
            }
        }
    }

    /**
     * Resize image thumb
     * small size format
     *
     * @param $file_image
     * @return string
     */
    function do_resize_thumb($file_image) {
        if ($file_image == '') return;

        $path_image = $this->_path_upload.$file_image;
        $file_size = getimagesize($path_image);
        $width = $file_size[0];
        $height = $file_size[1];
        $no_resize = 0;

        if ($width > $height && $width > BLOG_IMG_RESIZE_THUMB) {
            $width = BLOG_IMG_RESIZE_THUMB;
            $resize_height = ($width * BLOG_IMG_RESIZE_THUMB) / $width;
        } elseif ($height > $width && $height > BLOG_IMG_RESIZE_THUMB) {
            $width = ($height * BLOG_IMG_RESIZE_THUMB) / $height;
            $resize_height = BLOG_IMG_RESIZE_THUMB;
        } else { // not resize
            $no_resize = 1;
        }

        if ($no_resize == 0) { // Resize image
            $configs = array(
                'source_image'  => $path_image,
                'new_image'     => $path_image,
                'width'         => $width,
                'height'        => $resize_height,
                'maintain_ratio'=> TRUE,
                'quality'       => 100,
                'upload_path'   => $path_image,
                'image_library' => 'gd2',
                'create_thumb'  => TRUE,
                'maintain_ratio'=> TRUE
            );

            $this->load->library('image_lib');
            $this->image_lib->initialize($configs);
            $this->image_lib->resize();

            $file_info = pathinfo($configs['new_image']);
            return $image_thumb = $file_info['filename'] .THUMB_NAME.'.'.$file_info['extension'];
        }
    }

    /**
     * Copy image
     *
     * @param string path $old_image
     * @param int primary $blog_id
     * @return bool|string
     */
    function copy_image_new_path($old_image, $blog_id) {
        $year  = date('Y');
        $month = date('m');
        $day   = date('d');

        $file_path_year = $this->_path_upload.'/'.$year;
        if (! file_exists($file_path_year)) { mkdir($file_path_year,0777, TRUE); }

        $file_path_month = $file_path_year.'/'. $month;
        if (! file_exists($file_path_month)) { mkdir($file_path_month,0777, TRUE); }

        $file_path_day = $file_path_month.'/'. $day ;
        if (! file_exists($file_path_day)) { mkdir($file_path_day,0777, TRUE);}

        $new_path = $year.'/'.$month.'/'.$day.'/';
        $file_path = $this->_path_upload.'/'.$old_image;
        $dest_path = $this->_path_upload.'/'.$new_path;

        $pathinfo = pathinfo($file_path);
        $pic = $pathinfo['basename'];

        if($pic) {
            if (strpos($file_path, '/') !== false) {
                $dest_path = str_replace($pathinfo['dirname'], $dest_path, $file_path);
            }else{
                $dest_path = $dest_path.'/'.$file_path;
            }

            @copy($file_path, $dest_path);

            $path_image = $new_path.$pic;
            $params = array(
                'object_id'     => $blog_id,
                'image_type'    => POST_TYPE_EVENT,
                'path_image'    => $path_image,
            );

            $this->blogs_model->insertImage($params);
        }
    }

}
