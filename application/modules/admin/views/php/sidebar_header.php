<nav class="navbar hidden-print main " role="navigation">
    <div class="navbar-header pull-left">
        <div class="user-action user-action-btn-navbar pull-left border-right" id="btn_navbar">
            <button class="btn btn-sm btn-navbar btn-inverse btn-stroke"><i class="fa fa-bars fa-2x"></i>
            </button>
        </div>
    </div>
    <ul class="main pull-right ">


        <li class="dropdown username">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $this->config->item("base_tlp_admin");?>/assets/images/people/35/2.jpg" class="img-circle"
                     width="30" /><?php echo $user_data->adminName; ?>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="<?php echo $this->config->item("base_url_admin");?>/login/logout/" class="glyphicons lock no-ajaxify"><i></i>Logout</a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="navbar-collapse collapse"> &nbsp; </div>
</nav>
