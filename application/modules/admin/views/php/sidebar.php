<div id="menu" class="hidden-print hidden-xs  sidebar-white">
    <div id="sidebar-collapse-wrapper">
        <div id="brandWrapper">
            <a href="{$base_url_admin}/" class="display-block-inline pull-left logo">
                Logo
            </a>
            <a href="{$base_url_admin}/"><span class="text">Air Trippy</span></a>
        </div>
        <div id="logoWrapper">
            <div id="logo">
                <a href="{$base_url_admin}/login/logout/" title="Logout" class="btn btn-sm btn-inverse pull-right"><i class="fa fa-fw fa-sign-out"></i></a>
            </div>
        </div>
        <ul class="menu list-unstyled hide" id="navigation_components"></ul>
        <ul class="menu list-unstyled hide" id="navigation_modules"></ul>
        <ul class="menu list-unstyled hide" id="navigation_modules_front"></ul>
        <ul class="menu list-unstyled" id="navigation_current_page">
            <li class="hasSubmenu">
                <a href="{$base_url_admin}/" class="glyphicons home ">
                    <i></i><span>Dashboard</span>
                </a>      
            </li>

            <li class="hasSubmenu ">
                <a href="#sidebar-collapse-member" data-toggle="collapse" class="glyphicons user"><i></i><span>Agency management</span></a>
                <ul id="sidebar-collapse-member" class="collapse ">

                    <li class="active"><a href="{$base_url_admin}/agency/"><i class="fa fa-edit"></i>asdf</a></li>

                    <li><a href="{$base_url_admin}/agency/add/"><i class="fa fa-edit"></i>asdf</a></li>

                    <li><a href="{$base_url_admin}/agency/update/"><i class="fa fa-edit"></i>asdfa</a></li>


                </ul>
            </li>

            <li class="hasSubmenu">
                <a href="#sidebar-collapse-projects" data-toggle="collapse"><i class="fa fa-list"></i>Tour management</a>
                <ul id="sidebar-collapse-projects" class="collapse ">
                    <li ><a href="{$base_url_admin}projects/"><i class="fa fa-edit"></i> Mn</a></li>
                </ul>
            </li>

            <li class="hasSubmenu">
                <a href="#sidebar-collapse-mail" data-toggle="collapse"><i class="fa fa-list"></i>Blog management</a>
                <ul id="sidebar-collapse-mail" class="collapse ">
                    <li><a href="{$base_url_admin}product/list/"><i class="fa fa-edit"></i> Mn</a></li>
                    </ul>
            </li>


            <li class="hasSubmenu">
                <a href="#sidebar-collapse-blogs" data-toggle="collapse" class="glyphicons file"><i></i><span>Experience images</span></a>
                <ul id="sidebar-collapse-blogs" class="collapse">
                    <li ><a href="{$base_url_admin}blogs/add/"><i class="fa fa-edit"></i> Mn</a></li>
                    <li ><a href="{$base_url_admin}/blogs/"><i class="fa fa-list-ol"></i> Mn</a></li>
                </ul>
            </li>

            <li class="hasSubmenu ">
                <a href="#sidebar-collapse-consulting" data-toggle="collapse" class="glyphicons file"><i></i><span>Yêu cầu đăng tin</span></a>
                <ul id="sidebar-collapse-consulting" class="collapse ">
                    <li><a href="{$base_url_admin}/consulting/add/"><i class="fa fa-edit"></i> Mn</a></li>
                </ul>
            </li>


            <li class="hasSubmenu <?php if ($this->router->class == 'callme') { echo 'active'; }?>">
                <a href="#sidebar-collapse-pages" data-toggle="collapse" class="glyphicons file"><i></i><span>Call me</span></a>
                <ul id="sidebar-collapse-pages" class="collapse <?php if ($this->router->class == 'callme') { echo 'in'; } ?>">
                    <li><a href="{$base_url_admin}/callme/"><i class="fa fa-edit"></i> Danh sách</a></li>
                </ul>
            </li>


            <li class="hasSubmenu ">
                <a href="#sidebar-collapse-banners" data-toggle="collapse" class="glyphicons picture"><i></i><span>Visitor management</span></a>
                <ul id="sidebar-collapse-banners" class="collapse ">
                    <li><a href="{$base_url_admin}/banners/categories/"><i class="fa fa-list-ul"></i> Banner Cat</a>
                    <li><a href="{$base_url_admin}/banners/banners/"><i class="fa fa-list-ol"></i> Main</a></li>
                </ul>
            </li>

            <li class="hasSubmenu <?php if ($this->router->class == 'language') { echo 'active'; }?>">

                <a href="#sidebar-collapse-maps" data-toggle="collapse" class="glyphicons settings"><i></i><span>Setting</span></a>
                <ul id="sidebar-collapse-maps" class="collapse <?php if ($this->router->class == 'language') { echo 'in'; } ?>">

                    <li><a href="{$base_url_admin}/users/"><i class="fa fa-wrench"></i>Admin</a></li>

                    
                    <li><a href="{$base_url_admin}/category/viewnested/"><i class="fa fa-wrench"></i>Price management</a></li>

                    
                    <li <?php if ($this->router->class == 'language') { echo 'class="active"'; } ?>><a href="{$base_url_admin}/language/items"><i class="fa fa-wrench"></i>Biến chung</a></li>

                </ul>
            </li>
            <li class="hasSubmenu "> &nbsp; </li>
            <li class="hasSubmenu "> &nbsp; </li>
        </ul>

    </div>
</div>
