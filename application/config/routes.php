<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/index';
$route['^en$'] = $route['default_controller'];
$route['subscriber'] = 'home/subscriber/index';

$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/* Portfolio */
$route['website-doanh-nghiep/(:any)'] = 'home/portfolio/index/$1';
$route['website-dich-vu-san-pham/(:any)'] = 'home/portfolio/index/$1';
$route['website-shop-ban-hang/(:any)'] = 'home/portfolio/index/$1';
$route['phan-mem-web-app/(:any)'] = 'home/portfolio/index/$1';
$route['website-khac/(:any)'] = 'home/portfolio/index/$1';
$route['du-an/nam-(:any)'] = 'home/portfolio/byYear/$1/$2';
$route['y-kien-phan-hoi-cua-khach-hang/(:any)'] = 'home/portfolio/testimonial_detail/$1';
$route['du-an/testimonial'] = 'home/portfolio/testimonial';
$route['du-an/(:any)'] = 'home/portfolio/category/$1';
$route['du-an'] = 'home/portfolio/portfolio';
$route['portfolio/(:any)'] = 'home/portfolio/redirect_old/$1';

/* Services */
$route['thiet-ke-website'] = 'home/services/thietkewebsite';
$route['viet-phan-mem-theo-yeu-cau'] = 'home/services/vietphanmem';
$route['cham-soc-bao-tri-quan-ly-website'] = 'home/services/webmaster';
$route['thiet-ke-do-hoa-graphic-design'] = 'home/services/graphicdesign';
$route['mobile-app'] = 'home/services/mobileapp';
$route['bang-gia-hosting-host-vps-linux'] = 'home/services/hosting';
$route['bang-gia-ten-mien-website'] = 'home/services/domain';
$route['web-seo'] = 'home/services/webseo';
$route['quang-cao-online'] = 'home/services/adv';
$route['dich-vu'] = 'home/services/item';

/* 27 Jun 2026*/
$route['giai-phap-tich-hop-ai-hub'] = 'home/services/ai_hub';
$route['contact/submit-ai-hub'] = 'home/contact/submit_consultation';

/* Document detail */
$route['tai-lieu/(:any)-(:num).html'] = 'home/document/index/$1/$2';
$route['download/(:any)-(:num).html'] = 'home/document/download/$1/$2';
$route['tai-lieu/(:any)'] = 'home/document/category/$1';
$route['tai-lieu/(:any)'] = 'home/document/category/$1';
$route['tai-lieu'] = 'home/document/items';
$route['profile/(:any)'] = 'home/document/index/$1';
$route['catalogue/(:any)'] = 'home/document/index/$1';

/* History */
$route['lich-su'] = 'home/about/history';

/* About us */
$route['(gioi-thieu)'] = 'home/about/fullScreenPage/$1';
$route['(co-cau-to-chuc)'] = 'home/about/fullScreenPage/$1';
$route['(gia-tri-cot-loi)'] = 'home/about/fullScreenPage/$1';
$route['(can-bo-chu-chot)'] = 'home/about/KeyPerson/$1';
$route['(khach-hang)'] = 'home/about/partner/$1';

$route['(cam-ket-chat-luong)'] = 'home/about/policy/$1';
$route['(dieu-khoan-su-dung)'] = 'home/about/policy/$1';
$route['(chinh-sach-bao-mat)'] = 'home/about/policy/$1';
$route['(bang-andre)'] = 'home/about/personal/$1';

/* Contact */
$route['lien-he'] = 'home/contact/index';

/* Page search */
$route['tim-kiem'] = 'home/search/item';

/* News */
$route['tin-tuc/(:any)'] = 'home/news/category/$1';
$route['tin-tuc'] = 'home/news/news';
$route['author/panpicteam'] = 'home/news/authors';
$route['web-blog'] = 'home/news/web_blog';
$route['web-blog/(:any)'] = 'home/news/index/$1';
$route['faq'] = 'home/news/faq';
$route['faq/(:any)'] = 'home/news/index/$1';
$route['mau-giao-dien-web'] = 'home/news/ux_ui';
$route['mau-giao-dien-web/(:any)'] = 'home/news/index/$1';
$route['tin-video'] = 'home/news/video_blog';
$route['tin-video/(:any)'] = 'home/news/index/$1';
$route['tin-tuyen-dung'] = 'home/news/career_blog';
$route['tin-tuyen-dung/(:any)'] = 'home/news/index/$1';
$route['tag/(:any)'] = 'home/news/tag/$1';
$route['(:any)'] = 'home/news/index/$1'; // 'home/news/redirect_old/$1';

/* SEO */
$route['(rss/news.rss)'] = 'home/feed/index';
// https://www.panpic.vn/home/sitemapblog/index
