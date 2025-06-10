<ul>
<li {if $tab eq $BLOG_TAB_ACTIVE}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}" class="glyphicons glyphicons check"><i></i><span class="strong">{$lable.active}</span><span>{$lable.current_active}</span></a>
</li>
<li {if $tab eq $BLOG_TAB_INACTIVE}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=5" class="glyphicons bin"><i></i><span class="strong">{$lable.trash}</span><span>{$lable.has_delete}</span></a>
</li>
</ul>