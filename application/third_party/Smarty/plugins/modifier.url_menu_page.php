<?php
function smarty_modifier_url_menu_page($page)
{
    $ci = &get_instance();

    if ($page == 'document') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/document';
        } else {
            $link_url = 'tai-lieu';
        }
    } else if ($page == 'contract_policy') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/contract/policy';
        } else {
            $link_url = 'hop-tac/chinh-sach';
        }
    } else if ($page == 'contact') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/contact-us';
        } else {
            $link_url = 'lien-he';
        }
    } else if ($page == 'history') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/history';
        } else {
            $link_url = 'lich-su';
        }
    } else if ($page == 'core_value') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/core-value';
        } else {
            $link_url = 'gia-tri-cot-loi';
        }
    } else if ($page == 'company_chart') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/company-chart';
        } else {
            $link_url = 'co-cau-to-chuc';
        }
    } else if ($page == 'key_staff') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/key-staff';
        } else {
            $link_url = 'can-bo-chu-chot';
        }
    } else if ($page == 'partner') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/partner';
        } else {
            $link_url = 'khach-hang';
        }
    } else if ($page == 'news') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/news';
        } else {
            $link_url = 'tin-tuc';
        }
    } else if ($page == 'portfolio') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/portfolio';
        } else {
            $link_url = 'du-an';
        }
    } else if ($page == 'services') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/services';
        } else {
            $link_url = 'dich-vu';
        }
    } else if ($page == 'about_us') {
        if ($ci->langUrl == LANG_EN) {
            $link_url = $ci->langUrl . '/about-us';
        } else {
            $link_url = 'gioi-thieu';
        }
    }

    return base_url($link_url);
}
