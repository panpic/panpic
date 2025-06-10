<nav class="navbar hidden-print main " role="navigation">
    <div class="navbar-header pull-left">
        <div class="user-action user-action-btn-navbar pull-left border-right" id="btn_navbar">
            <button class="btn btn-sm btn-navbar btn-inverse btn-stroke"><i class="fa fa-bars fa-2x"></i>
            </button>
        </div>
    </div>
    <ul class="main pull-right ">
    	<li class="dropdown notif notifications hidden-xs">
        	<a href="" class="dropdown-toggle" data-toggle="dropdown">
            	<div class="pull-left">
            		<img src="{$base_tlp_admin}/images/flag/{$current_lang}.png" class="thumb" style="padding-top:17px;" />
                </div> 
                <div class="pull-right" style="padding-top:5px;">{$page_lang[$current_lang]}</div>
            </a>
            <ul class="dropdown-menu chat media-list pull-right" style="width:90px;">
            	{foreach from=$page_lang key=k item=vl}
                <li class="media">
                    <a class="pull-left" href="{$current_url_lang}?lang={$k}">
                        <img class="media-object thumb" src="{$base_tlp_admin}/images/flag/{$k}.png" width="25" />
                    </a>
                    <div class="media-body">
                        <a href="{$current_url_lang}?lang={$k}"><h5 class="media-heading">{$vl}</h5></a>
                    </div>
                </li>
                {/foreach}
        	</ul>        
        </li>
        <li class="dropdown username">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{$base_tlp_admin}/assets/images/people/35/2.jpg" class="img-circle"
                     width="30" />{$user_data->adminLogin}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="{$base_url_admin}/login/logout/" class="glyphicons lock no-ajaxify"><i></i>Logout</a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="navbar-collapse collapse">
        &nbsp;
    </div>
</nav>