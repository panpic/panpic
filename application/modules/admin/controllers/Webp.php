<?php
/**
 * Controllers Webp: Convert image to webp
 * Last update 26 May 2024
 *
 * @package backend
 * @copyright Panpic
 * @author contact@panpic.vn
 * @author position: Website's Developer Team
 * @since 6 Mar 2024
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webp extends MY_Controller{

    private $_URL_LINK; // 'http://panpicv3.local'


    public function __construct(){
        parent::__construct();
        $this->_URL_LINK = $this->base_url;
    }

    /**
     * convert webp
     */
    function index(){
        $UrlHinh = $this->input->post('UrlHinh'); // $_GET['UrlHinh'];
        // pre($UrlHinh);

        $path_file = '';

        if ($UrlHinh != '') {

            // $this->hkt_resize($UrlHinh, 200, 155);
            // $this->hkt_resize($UrlHinh, 120, 95);
            // $this->hkt_resize($UrlHinh, 150, 100);
            // $this->hkt_resize($UrlHinh, 400, 320);

            $path_file = $this->hkt_saveWebp($UrlHinh);

            // $this->hkt_saveWebp(str_replace("/images/", "/resize/200x155/", $UrlHinh));
            // $this->hkt_saveWebp(str_replace("/images/", "/resize/120x95/", $UrlHinh));
            // $this->hkt_saveWebp(str_replace("/images/", "/resize/150x100/", $UrlHinh));
            // $this->hkt_saveWebp(str_replace("/images/", "/resize/400x320/", $UrlHinh));

        }

        echo $path_file;
        die();
    }

    function hkt_saveWebp($UrlHinh)
    {
        // echo $UrlHinh;echo "</br>";
        // echo $UrlHinh;
        // echo "</br>";
        // echo $_SERVER['DOCUMENT_ROOT'] ;echo "</br>";
        $file_name = basename($UrlHinh);
        $path_get_content = $_SERVER['DOCUMENT_ROOT'] ."/". str_replace("$this->_URL_LINK/", "", $UrlHinh);
        // echo $path_get_content;echo "</br>";

        $path_to = str_replace($file_name, "", $path_get_content);
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $new_path = $year.'/'.$month.'/'.$day;

        if (strpos($path_to, "/resize/")) {
            // neu hien tai hinh anh nam trong thu muc resize
            $path_to = str_replace("/resize/", "/$new_path/webp/", $path_to);
        } else {
            $path_to = str_replace("/images/", "/$new_path/webp/", $path_to);
        }

        // echo $path_get_content;echo "</br>";
        // echo $path_to;echo "</br>";

        // kiem tra duong dan file
        if (!file_exists($path_to)) {
            mkdir($path_to, 0777, true);
        }

        //filename : duong dan thu muc
        $image = imagecreatefromstring(file_get_contents($path_get_content));
        ob_start();
        imagejpeg($image, NULL, 100);
        $content1 = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        $content2 = imagecreatefromstring($content1);
        $output = $path_to.$file_name.".webp";

        // exit();
        imagewebp($content2, $output);
        imagedestroy($content2);

        $path = explode('/media/', $output);
        return $this->_URL_LINK.'/media/'.$path[1];

        // echo 1;exit();
    }


    function hkt_resize($UrlHinh,$newWidth,$newHeight){
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $new_path = $year.'/'.$month.'/'.$day.'/';

        $file_name = basename($UrlHinh);
        $path_get_content = $_SERVER['DOCUMENT_ROOT'] ."/". str_replace("$this->_URL_LINK/", "", $UrlHinh);
        list($width,$height,$type) = getimagesize($path_get_content);
        // echo strtolower(image_type_to_mime_type($type));exit();
        $newImage = imagecreatetruecolor($newWidth,$newHeight);

        // kiem tra file nhap vao
        switch(strtolower(image_type_to_mime_type($type)))
        {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($path_get_content);
                break;
            case 'image/jpg':
                $source = imagecreatefromjpeg($path_get_content);
                break;
            case 'image/png':
                $source = imagecreatefrompng($path_get_content);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($path_get_content);
                break;
            default:
                return false;
        }

        imagecopyresized($newImage, $source,0,0,0,0,$newWidth, $newHeight,$width,$height);

        $path_to = str_replace($file_name, "", $path_get_content);
        $path_to = str_replace("/images/", "/$new_path/resize/{$newWidth}x{$newHeight}/", $path_to);

        if (!file_exists($path_to)) {
            mkdir($path_to, 0777, true);
        }

        //save image
        imagejpeg($newImage,$path_to.$file_name);
    }

    
}