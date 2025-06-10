<ul>
<li {if $tab eq $BLOG_TAB_VIEWALL}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=1" class="glyphicons glyphicons list"><i></i><span class="strong">{$lable.list_items}</span><span>{$lable.view_all}</span></a>
</li>
<!--
<li {if $tab eq $BLOG_TAB_UNVERIFY}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=2" class="glyphicons glyphicons unchecked"><i></i><span class="strong">{$lable.admin_verify}</span><span>{$lable.verify_unchecked}</span></a>
</li>
<li {if $tab eq $BLOG_TAB_VERIFY}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=3" class="glyphicons glyphicons check"><i></i><span class="strong">{$lable.admin_verify}</span><span>{$lable.verify_checked}</span></a>
</li>
-->
<li {if $tab eq $BLOG_TAB_ACTIVE}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=4" class="glyphicons glyphicons check"><i></i><span class="strong">{$lable.active}</span><span>{$lable.current_active}</span></a>
</li>
<li {if $tab eq $BLOG_TAB_INACTIVE}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=5" class="glyphicons delete"><i></i><span class="strong">{$lable.trash}</span><span>{$lable.has_delete}</span></a>
</li>
</ul>