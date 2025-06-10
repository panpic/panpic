<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{$base_url_admin}">Admin v1.0</a>
</div><!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    {if $ss_admin->admin_role eq 'ADMINISTRATOR'}
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="{$base_url_admin}category/view/">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> Danh mục
                            <span class="pull-right text-muted small"><!--4 minutes ago--></span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{$base_url_admin}lang/view">
                        <div>
                            <i class="fa fa-gear fa-fw"></i> Tiêu đề
                            <span class="pull-right text-muted small">...</span>
                        </div>
                    </a>
                </li>

            </ul>
            <!-- /.dropdown-alerts -->
        </li>
    {/if}
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#"><i class="fa fa-user fa-fw"></i> {$ss_admin->username}</a>
            </li>
            <li class="divider"></li>
            <li><a href="{$base_url_admin}login/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->