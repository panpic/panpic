<div class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <!--
            <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                            </button>
                    </span>
                    </div>
            </li>
            -->
            <li>
                <a href="{$base_url_admin}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            {if $ss_admin->admin_role eq 'ADMINISTRATOR'}
                <li {if $form.control eq 'category'}class="active"{/if}>
                    <a href="{$base_url_admin}category/view/"><i class="fa fa-sitemap fa-fw"></i> {$lang.category.value}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {if $form.control eq 'category'}collapse in{/if}">
                        <li>
                            <a href="{$base_url_admin}category/">{$lang.add.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}category/view/">{$lang.list.value}</a>
                        </li>
                    </ul><!-- /.nav-second-level -->
                </li>
            {/if}
            <li {if $form.control eq 'news'}class="active"{/if}>
                <a href="{$base_url_admin}news/view/"><i class="fa fa-edit fa-fw"></i> {$lang.news.value}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level {if $form.control eq 'news'}collapse in{/if}">
                    <li>
                        <a href="{$base_url_admin}news/">{$lang.add.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}news/view/">{$lang.list.value}</a>
                    </li>
                </ul><!-- /.nav-second-level -->
            </li>

            <li {if $form.control eq 'event'}class="active"{/if}>
                <a href="{$base_url_admin}event/views/"><i class="fa fa-edit fa-fw"></i> {$lang.events.value}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level {if $form.control eq 'events'}collapse in{/if}">
                    <li>
                        <a href="{$base_url_admin}events/view/?cat=11">{$lang.events.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}events/view/?cat=13">{$lang.event_13.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}events/view/?cat=14">{$lang.event_14.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}events/view/?cat=0">{$lang.download_form_register.value}</a>
                    </li>
                </ul><!-- /.nav-second-level -->
            </li>

            <li {if $form.control eq 'document'}class="active"{/if}>
                <a href="{$base_url_admin}document/view/"><i class="fa fa-edit fa-fw"></i> {$lang.document.value}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level {if $form.control eq 'document'}collapse in{/if}">
                    <li>
                        <a href="{$base_url_admin}document/">{$lang.add.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}document/view/">{$lang.list.value}</a>
                    </li>
                </ul><!-- /.nav-second-level -->
            </li>

            <li {if $form.control eq 'calendar'}class="active"{/if}>
                <a href="{$base_url_admin}calendar/views/"><i class="fa fa-edit fa-fw"></i> {$lang.calendar.value}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level {if $form.control eq 'calendar'}collapse in{/if}">
                    <li>
                        <a href="{$base_url_admin}calendar/">{$lang.add.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}calendar/view">{$lang.list.value}</a>
                    </li>
                    <li>
                        <a href="{$base_url_admin}calendar/department/">{$lang.department.value}</a>
                    </li>
                </ul><!-- /.nav-second-level -->
            </li>
            {if $ss_admin->admin_role eq 'ADMINISTRATOR'}
                <li {if $form.control eq 'aboutus'}class="active"{/if}>
                    <a href="#"><i class="fa fa-files-o fa-fw"></i> {$lang.aboutus.value}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {if $form.control eq 'aboutus'}collapse in{/if}">
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=1">{$lang.page_1.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=2">{$lang.page_2.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=3">{$lang.page_3.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=4">{$lang.page_4.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=5">{$lang.page_5.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=6">{$lang.intro_dept.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}aboutus/page/?id=7">Trang liên hệ</a>
                        </li>
                        <!--
                        <li><a href="{$base_url_admin}aboutus/view/">{$lang.list.value}</a></li>
                        -->
                    </ul><!-- /.nav-second-level -->
                </li>		
                <li {if $form.control eq 'advertising'}class="active"{/if}>
                    <a href="{$base_url_admin}advertising/view/"><i class="fa fa-files-o fa-fw"></i> {$lang.advertising.value}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level {if $form.control eq 'advertising'}collapse in{/if}">
                        <li>
                            <a href="{$base_url_admin}advertising/">{$lang.add.value}</a>
                        </li>
                        <li>
                            <a href="{$base_url_admin}advertising/view/">{$lang.list.value}</a>
                        </li>
                    </ul><!-- /.nav-second-level -->
                </li>
            {/if}
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->