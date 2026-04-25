<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('clear_homepage_cache')) {
    function clear_homepage_cache()
    {
        $CI =& get_instance();
        $CI->load->driver('cache', ['adapter' => 'file']);
        // Có thể đổi sang 'redis' hoặc 'memcached' nếu server hỗ trợ

        $keys = [
            'homepage_banners',
            'homepage_portfolios',
            'homepage_services_menu',
            'homepage_news',
            'homepage_news_sub',
            'homepage_testimonial',
            'homepage_partners'
        ];

        foreach ($keys as $key) {
            $CI->cache->delete($key);
        }

        log_message('info', 'Homepage cache cleared successfully.');
    }
}
