<div id="menu" class="hidden-print hidden-xs  sidebar-white">
<div id="sidebar-collapse-wrapper">
	<div id="brandWrapper">
		<a href="{$base_url}" target="_blank" class="display-block-inline pull-left logo">{$lable.company_char}</a>
	</div>

	<ul class="menu list-unstyled hide" id="navigation_components"></ul>
	<ul class="menu list-unstyled hide" id="navigation_modules"></ul>
	<ul class="menu list-unstyled hide" id="navigation_modules_front"></ul>
	<ul class="menu list-unstyled" id="navigation_current_page">
		<li class="hasSubmenu">
			<a href="{$base_url_admin}/" class="glyphicons home">
				<i></i><span>Dashboard</span>
			</a>      
		</li>
        <li class="hasSubmenu {if $control eq 'portfolio'}active{/if}">
			<a href="#sidebar-collapse-portfolio" data-toggle="collapse"><i class="fa fa-tasks"></i>{$lable.mn_portfolio}</a>
			<ul id="sidebar-collapse-portfolio" class="collapse {if $control eq 'portfolio'}in{/if}">
				<li {if $control eq 'portfolio' && $action eq 'items'}class="active"{/if}>
                	<a href="{$base_url_admin}/portfolio/items/"><i class="fa fa-edit"></i> {$lable.list_items}</a>
                </li>
                <li {if $control eq 'portfolio' && $action eq 'index'}class="active"{/if}>
                	<a href="{$base_url_admin}/portfolio"><i class="fa fa-edit"></i> {$lable.add_new}</a>
                </li>			
			</ul>
		</li>
        <li class="hasSubmenu {if $control eq 'blogcat' || $control eq 'blogs' || $control eq 'culture' || $control eq 'keystaff' || $control eq 'services' || $control eq 'letters' || $control eq 'faq' || $control eq 'recruitment' || $control eq 'download' || $control eq 'tags' || $control eq 'testimonial'}active{/if}">
			<a href="#sidebar-collapse-blog" data-toggle="collapse"><i class="fa fa-stack-exchange"></i>{$lable.post}</a>
			<ul id="sidebar-collapse-blog" class="collapse {if $control eq 'blogcat' || $control eq 'blogs' || $control eq 'culture' || $control eq 'keystaff' || $control eq 'services' || $control eq 'letters' || $control eq 'faq' || $control eq 'recruitment' || $control eq 'download' || $control eq 'tags' || $control eq 'testimonial'}in{/if}">
				
                <li {if $control eq 'blogs'}class="active"{/if}><a href="{$base_url_admin}/blogs/items/"><i class="fa fa-edit"></i> {$lable.mn_news}</a></li>
				<li {if $control eq 'services'}class="active"{/if}><a href="{$base_url_admin}/services/items/"><i class="fa fa-edit"></i> {$lable.services}</a></li>
				<li {if $control eq 'download'}class="active"{/if}><a href="{$base_url_admin}/download/items/"><i class="fa fa-edit"></i> {$lable.download}</a></li>
				<li {if $control eq 'testimonial'}class="active"{/if}><a href="{$base_url_admin}/testimonial/items/"><i class="fa fa-edit"></i> {$lable.testimonial}</a></li>
				<li {if $control eq 'blogcat'}class="active"{/if}><a href="{$base_url_admin}/blogcat/viewnested/"><i class="fa fa-edit"></i> {$lable.category}</a></li>
				<li {if $control eq 'tags'}class="active"{/if}><a href="{$base_url_admin}/tags/items/"><i class="fa fa-edit"></i> {$lable.tags}</a></li>

				{**
				<li {if $control eq 'keystaff'}class="active"{/if}><a href="{$base_url_admin}/keystaff/items/"><i class="fa fa-edit"></i> {$lable.menu_about_key_staff}</a></li>
				<li {if $control eq 'recruitment'}class="active"{/if}><a href="{$base_url_admin}/recruitment/items/"><i class="fa fa-edit"></i> {$lable.menu_recruitment}</a></li>
				<li {if $control eq 'letters'}class="active"{/if}><a href="{$base_url_admin}/letters/items/"><i class="fa fa-edit"></i> {$lable.letters}</a></li>
				<li {if $control eq 'culture'}class="active"{/if}><a href="{$base_url_admin}/culture/items/"><i class="fa fa-edit"></i> {$lable.company_culture}</a></li>
				<li {if $control eq 'safety'}class="active"{/if}><a href="{$base_url_admin}/safety/items/"><i class="fa fa-edit"></i> {$lable.mn_occupational_safety}</a></li>
				<li {if $control eq 'technology'}class="active"{/if}><a href="{$base_url_admin}/technology/items/"><i class="fa fa-edit"></i> {$lable.mn_technology}</a></li>
				<li {if $control eq 'award'}class="active"{/if}><a href="{$base_url_admin}/award/items/"><i class="fa fa-edit"></i> {$lable.award}</a></li>
				**}
			</ul>
		</li>
        <li class="hasSubmenu {if $control eq 'banner'}active{/if}">
			<a href="#sidebar-collapse-banner" data-toggle="collapse"><i class="fa fa-camera"></i>{$lable.banner}</a>
			<ul id="sidebar-collapse-banner" class="collapse {if $control eq 'banner'}in{/if}">
				<li {if $control eq 'banner'}class="active"{/if}><a href="{$base_url_admin}/banner/items"><i class="fa fa-edit"></i> {$lable.list_items}</a></li>
			</ul>
		</li>
        <li class="hasSubmenu {if $control eq 'pages' || $control eq 'history'}active{/if}">
			<a href="#sidebar-collapse-pages" data-toggle="collapse"><i class="fa fa-file-o"></i>{$lable.page_manager}</a>
			<ul id="sidebar-collapse-pages" class="collapse {if $control eq 'pages' || $control eq 'history'}in{/if}">
				<li {if $control eq 'pages'}class="active"{/if}><a href="{$base_url_admin}/pages"><i class="fa fa-edit"></i> {$lable.list_items}</a></li>
                <li {if $control eq 'history'}class="active"{/if}><a href="{$base_url_admin}/history/items"><i class="fa fa-edit"></i> {$lable.history}</a></li>
			</ul>
		</li>
		<li class="hasSubmenu {if $control eq 'subscriber'}active{/if}">
			<a href="{$base_url_admin}/subscriber"><i class="fa fa-group"></i>{$lable.subscriber}</a>
		</li>
		<li class="hasSubmenu {if $control eq 'setup' || $control eq 'users' || $control eq 'members' || $control eq 'media' || $control eq 'provience' || $control eq 'district' || $control eq 'ward'} active {/if}">
			<a href="#sidebar-collapse-maps" data-toggle="collapse" class="glyphicons settings"><i></i><span>Setting</span></a>
			<ul id="sidebar-collapse-maps" class="collapse {if $control eq 'setup' || $control eq 'users' || $control eq 'members' || $control eq 'media' || $control eq 'provience' || $control eq 'district' || $control eq 'ward'} in {/if}">
				<li {if $control eq 'users'} class="active" {/if}><a href="{$base_url_admin}/users/"><i class="fa fa-wrench"></i>Admin</a></li>
                <li {if $control eq 'media'} class="active" {/if}><a href="{$base_url_admin}/media/items"><i class="fa fa-wrench"></i>{$lable.media}</a></li>
				<li {if $control eq 'language'} class="active" {/if}><a href="{$base_url_admin}/setup"><i class="fa fa-wrench"></i>{$lable.variable_setup}</a></li>
                
                {**
                <li {if $control eq 'provience'} class="active" {/if}><a href="{$base_url_admin}/provience"><i class="fa fa-wrench"></i>{$lable.city_province}</a></li>
                <li {if $control eq 'district'} class="active" {/if}><a href="{$base_url_admin}/district"><i class="fa fa-wrench"></i>{$lable.district}</a></li>
                <li {if $control eq 'ward'} class="active" {/if}><a href="{$base_url_admin}/ward"><i class="fa fa-wrench"></i>{$lable.ward}</a></li>
                **}
                
			</ul>
		</li>
		<li class="hasSubmenu"> &nbsp; </li>
		<li class="hasSubmenu"> &nbsp; </li>
	</ul>
</div>
</div>