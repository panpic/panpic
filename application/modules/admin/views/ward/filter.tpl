<ul>
<li {if $tab eq 4}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=4" class="glyphicons glyphicons check"><i></i><span class="strong">{$lable.active}</span><span>{$lable.current_active}</span></a>
</li>
<li {if $tab eq 5}class="active"{/if}>
	<a href="{$base_url_admin}/{$control}/{$action}/?t=5" class="glyphicons delete"><i></i><span class="strong">{$lable.trash}</span><span>{$lable.has_delete}</span></a>
</li>
</ul>