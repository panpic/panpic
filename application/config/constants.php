<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('LANG_VI', 'vi');
define('LANG_EN', 'en');
define('AVATAR', 'avatar.jpg');

define('OPTION_ADD', 'add');
define('OPTION_EDIT', 'edit');

define('ACTIVE', 1);
define('INACTIVE', 0);
define('ACTIVE_DUPLICATE', 2);
define('ADMIN_BLOG_VERIFY', 1);
define('ADMIN_BLOG_PENDING', 0);
define('SHOW_HOME', 1);

/**
 * Detect devices
 * 17 Jan 2024
 */
define('DETECT_MOBILE', 1);
define('DETECT_IPAD', 2);
define('DETECT_PC', 3);

define('BLOG_IMG_RESIZE_THUMB', 550);
define('PRODUCT_IMG_RESIZE_THUMB', 274);
define('THUMB_NAME', '_thumb');
define('DUPLICATED', 'duplicated');
define('DUPLICATED_AVAIL', 2);

define('POST_TYPE_BLOG', 'B'); /*Blog*/
define('POST_TYPE_FAQ', 'FAQ');
define('POST_TYPE_LAYOUT', 'UI');

define('POST_TYPE_SERVICES', 'S'); /*Services*/
define('POST_TYPE_PORTFOLIO', 'P'); /*Portfolio*/
define('POST_TYPE_EVENT', 'E'); /*Event*/
define('POST_TYPE_DOWNLOAD', 'DL'); /*Download*/
define('POST_TYPE_TESTIMONIAL', 'TE');
define('POST_TYPE_VIDEO', 'V');
define('POST_TYPE_LISCESING', 'LS'); /*Liscesing*/
define('POST_TYPE_LETTERS', 'LT'); /*Letters*/
define('POST_TYPE_REDCRUITMENT', 'R');
define('POST_TYPE_SERVICES_GALLERY', 'SG'); /*Portfolio Gallery*/
define('POST_TYPE_BLOG_GALLERY', 'G'); /*Album Gallery*/
define('POST_TYPE_KEY_STAFF', 'KS');
define('POST_TYPE_ALBUM', 'AM');
define('POST_TYPE_ALBUM_DETAIL', 'AD');
define('POST_TYPE_HISTORY', 'HS'); /* History */
define('POST_TYPE_OTHER', 'OR');
define('POST_TYPE_TAGS', 'TS'); /* Tags*/

define('BANNER_CAT_HOME', 'home');
define('BANNER_CAT_ABOUTUS', 'aboutus');
define('BANNER_CAT_BLOG', 'blog');
define('BANNER_CAT_FAQ', 'faq');
define('BANNER_CAT_NEWS', 'news');
define('BANNER_CAT_SERVICE', 'services');
define('BANNER_CAT_CONTACT', 'contact');
define('BANNER_CAT_DOWNLOAD', 'download');

define('POST_CAT_KIENTHUC', 2);
define('POST_CAT_TRUYENTHONG', 4);
define('POST_CAT_TRUYENTHONG_BAOCHI', 3);
define('POST_CAT_TRUYENTHONG_NEWSEVENT', 10);
define('POST_CAT_TRUYENTHONG_PROMOTION', 11);
define('POST_CAT_DOWNLOAD', 4);

define('ROOT_CAT', 1);
define('PARENT_CAT_BLOG', 2);
define('PARENT_CAT_FAQ', 5);
define('PARENT_CAT_LAYOUT', 6);

define('PARENT_CAT_BLOG_SUB_1', 14);
define('PARENT_CAT_BLOG_SUB_2', 5);
define('PARENT_CAT_BLOG_SUB_3', 6);
define('PARENT_CAT_BLOG_SUB_4', 13);

define('PARENT_CAT_ADVERTISE_SIGNS', 3);
define('PARENT_CAT_SERVICES', 23);
define('PARENT_CAT_PORTFOLIO', 17);
define('PARENT_CAT_PORTFOLIO_POS', 25);
define('PARENT_CAT_PORTFOLIO_SERVICES', 23);
define('PARENT_CAT_ALBUM', 12);
define('PARENT_CAT_PARTNER', 12);
define('PARENT_CAT_KEY_STAFF', 15);

define('PARENT_CAT_DOCUMENT', 4); /* Documents */
define('PARENT_CAT_DOWNLOAD', 3); /* Download */
define('PARENT_CAT_TESTIMONIAL', 16); /*Testimonial*/
define('PARENT_CAT_VIDEO', 13);
define('PARENT_CAT_RECRUITMENT', 21);

define('PRODUCT_TYPE_PRODUCT', 'P');
define('PRODUCT_TYPE_PRODUCT_GALLERY', 'PG');
define('PRODUCT_CAT_PRODUCT', 0);

define('BLOG_TAB_VIEWALL', 1);
define('BLOG_TAB_UNVERIFY', 2);
define('BLOG_TAB_VERIFY', 3);
define('BLOG_TAB_ACTIVE', 4);
define('BLOG_TAB_INACTIVE', 5);
define('BLOG_TAB_MEMBER', 6);

define('TESTIMONIAL_CAT_DOCCAMNHAN', 23);
define('TESTIMONIAL_CAT_TINCAY', 24);
define('TESTIMONIAL_CAT_CAMNHAN', 25);
define('TESTIMONIAL_CAT_CLIPCAMNHAN', 26);
define('TESTIMONIAL_CAT_STAFF', 27);

define('USER_ACTIVE', 1);
define('USER_INACTIVE', 0);
define('USER_NOT_EXIST', 0);
define('MAX_STRING_JAPAN', 2);

define('CAT_BLOG_VIDEO_ID', 13);
define('BLOG_CULTURE_ID', 10);
define('BLOG_SAFETY_ID_9', 9);
define('BLOG_SAFETY_ID_15', 15);
define('BLOG_HISTORY_ID', 3);
define('BLOG_POLICIES_ID', 11);
define('BLOG_CONTACT_ID', 2);

define('NEWS_SLUG', ['/tin-tuc', 'en/news']); //
define('TESTIMONIAL_SLUG', ['/thu-danh-gia', 'en/testimonial']);
define('DOCUMENT_SLUG', ['/tai-lieu', 'en/document']);
define('PORTFOLIO_SLUG', ['/du-an', 'en/portfolio']);
define('CAREERS_SLUG', ['/tuyen-dung', 'en/careers']);
define('SERVICE_SLUG', ['/dich-vu', 'en/services']);
define('CONTACT_SLUG', ['/lien-he', 'en/contact-us']);
define('SEARCH_SLUG', ['/tim-kiem', '/en/search']);
define('ABOUTUS_SLUG', ['/gioi-thieu', '/en/about-us']);
define('SAFETY_SLUG_CAT', ['/an-toan-lao-dong', 'en/safety']);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
