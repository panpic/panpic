<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 30 May 2022
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 30 May 2022
 */
class Import extends FRONT_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('index_model');
    }

    /**
     * Index
     */
    function index()
    {
        // error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $file = FCPATH."/server/panpic.xml";


        // $xml   = simplexml_load_string($file);
        $xml = simplexml_load_file($file);

        // $json  = json_encode($xml);
        // $array = json_decode($json,TRUE);

        // $this->load->library('simplexml');
        // $xmlData = $this->simplexml->xml_parse($xml);

        // $xmlDoc = new DOMDocument();
        // $xmlDoc->load($file);

        // echo strlen("Công ty chuyên thiết kế web bán hàng");
        // pre('');

        $temp = array();
        foreach ($xml->channel->item as $vl){
            // $arr = $vl->item;

            $title = (string)$vl->title;
            $e_content = $vl->children("content", true);
            $content = (string)$e_content->encoded;
            $strlen = strlen($content);

            if( $content && $strlen > 100 ) {
                $file_image = $vl->guid;
                $file_image = str_replace('/wp-content/', '/application/', $file_image);
                $file_image = explode('/uploads/', $file_image);
                $file_iamge = isset($file_image[1]) ? $file_image[1] : '';

                $e_wp = $vl->children("wp", true);
                $date_add = (string)$e_wp->post_date;
                $slug = (string)$e_wp->post_name;

                $item = array(
                    'title'     => $title,
                    'content'   => $content,
                    'slug'      => $slug,
                    'file_image'=> $file_iamge,
                    'date_add'  => $date_add
                );

                // pre($item);

                array_push($temp, $item);
            }
        }

        pre($temp);
    }

    function excel() {
        $this->load->library('excel');
        //$this->load->library('PHPexcel/iofactory');
        $arrayLabel = array("A","B","C","D","E","F","G","H");
        $objPHPExcel = PHPExcel_IOFactory::load(FCPATH."/server/panpic.xlsx");

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        // pre($sheetData);

        $temp = array();
        $i=0;
        foreach ($sheetData as $vl) {

            if($i > 0) {
                $title = $vl['B'];
                $content = $vl['C'];
                $date_add = $vl['E'];

                $slug = $vl['G'];
                $image = $vl['H'];
                $category = $vl['I'];
                $seo_title = $vl['J'];
                $seo_description = $vl['K'];

                $slug = explode('https://www.panpic.vn/', $slug);
                $slug = str_replace('/', '', $slug[1]);

                $image = explode('||', $image);
                if(sizeof($image) > 0) {
                    $image = $image[0];
                }

                $image = explode('/uploads/', $image);
                $image = isset($image[1]) ? $image[1] : '';

                $cat = explode('Panpic>', $category);
                $category = ($cat && sizeof($cat) > 0) ? $cat[1] : $category;

                $item = array(
                    'title'     => $title,
                    'content'   => $content,
                    'slug'      => $slug,
                    'path_image'=> $image,
                    'date_add'  => $date_add,
                    'category'  => $category,
                    'seo_title' => $seo_title,
                    'seo_description' => $seo_description
                );

                // $this->main_model->insertItem($item);

                // array_push($temp, $item);
            }

            $i++;
        }

        echo $i;
        // pre($temp);

    }

    function tag() {
        $this->load->library('excel');
        //$this->load->library('PHPexcel/iofactory');
        $arrayLabel = array("A","B","C","D","E","F","G","H");
        $objPHPExcel = PHPExcel_IOFactory::load(FCPATH."/server/tag.xlsx");

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        // pre($sheetData);

        $temp = array();
        $i=0;
        foreach ($sheetData as $vl) {

            if($i > 0) {
                $title = $vl['B'];
                $content = $vl['C'];

                $item = array(
                    'title' => $title,
                    'slug'  => $content,
                );

                // $this->main_model->insertTag($item);

                // array_push($temp, $item);
            }

            $i++;
        }

        echo $i;
        // pre($temp);

    }

}