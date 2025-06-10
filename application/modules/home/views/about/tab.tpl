<ul class="nav nav-tabs mb-5" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link {if $page.page_id eq 1}active{/if}" href="{'about_us'|url_menu_page}">{$lable.menu_about_gioithieu}</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {if $page.page_id eq 3}active{/if}" href="{'history'|url_menu_page}">{$lable.menu_about_history}</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {if $page.page_id eq 7}active{/if}" href="{'company_chart'|url_menu_page}">{$lable.menu_about_cocautochu}</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {if $page.page_id eq 8}active{/if}" href="{'core_value'|url_menu_page}">{$lable.menu_about_corevalue}</a>
    </li>
    {**
    <li class="nav-item" role="presentation">
        <a class="nav-link {if $page.page_id eq 9}active{/if}" href="{'key_staff'|url_menu_page}">{$lable.menu_about_key_staff}</a>
    </li>
    **}
</ul>