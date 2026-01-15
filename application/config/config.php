<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$weburl = "http://panpic.local";
$config['base_url']       = $weburl;
$config['base_url_front'] = $weburl;
$config['base_tlp_front'] = $weburl."/assets/front";
$config['tpl_absolute_path'] = "assets/front";
$config['upload_absolute_path'] = "files/";

$config['base_url_admin'] = $weburl."/admin";
$config['base_tlp_admin'] = $weburl."/assets/admin/darkgreen";

$config['link_upload'] = $weburl."/files";
$config['path_upload']   = FCPATH."files/";
$config['path_media']    = FCPATH."media";
$config['allowed_file_types'] = 'gif|jpg|png|zip|rar|doc|docx|xlsx|csv|xls|pdf';
$config['allowed_file_types_profile'] = 'pdf';
$config['encrypt_name'] = TRUE;

/**
 * Path upload menu html
 * 7 Apr 2025
 */
$config['path_upload_html'] = FCPATH."application/modules/home/views/widget/";

$config['page_lang']   =  array('vi'=> 'Vietnam');
$config['default_lang'] = 'vi';
$config['page_cat']    =  array(1 => 'Giới thiệu - About Us', 2 => 'Liên hệ - Contact', 3 => 'Chính sách - Policy');

$config['custom_encrypt_key'] = 'panpic.vn';
$config['custom_encrypt_secret'] = 'panpic134129';

// Cookie
$config['domain_cookie'] = 'panpic.vn';
$config['prefix_cookie'] = 'panpic_';

$config['user_cookie']      = 'user_set';
$config['user_path']        = '/';
$config['user_expire']      = time()+86500;

$config['session_enduser']  = 'userData';

// super admin
$config['super_admin']   = 'ADMINISTRATOR';

$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';

$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = TRUE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 4;
$config['log_path'] = FCPATH . '/application/logs/';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = TRUE;
$config['encryption_key'] = 'max';

$config['sess_cookie_name']	= 'ci_session';
$config['sess_expiration']	= 7200;
$config['sess_expire_on_close']	= TRUE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']	= 'ci_sessions';
$config['sess_match_ip']	= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = TRUE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = TRUE;
$config['proxy_ips'] = '';

// $config['smarty.template_error_reporting'] = E_ALL ^ E_NOTICE;
