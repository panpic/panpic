<ul>
<li {if $tab eq $BLOG_TAB_VIEWALL}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}?t=1" class="glyphicons glyphicons list"><i></i><span class="strong">{$lable.list_items}</span><span>{$lable.view_all}</span></a>
</li>
<li {if $tab eq 2}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}?t=2" class="glyphicons glyphicons user"><i></i><span class="strong">{$lable.members}</span><span>Được đăng nhập</span></a>
</li>
<li {if $tab eq 3}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}?t=3" class="glyphicons glyphicons unchecked"><i></i><span class="strong">{$lable.members}</span><span>Không được đăng nhập</span></a>
</li>
</ul>