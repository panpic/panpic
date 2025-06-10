<ul class="nav nav-tabs mb-5" role="tablist">
    {foreach from=$menu_services item=vl}
    <li class="nav-item" role="presentation">
        <a class="nav-link {if $service.category_id eq $vl.post_cat_id}active{/if}" href="{$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}">{$vl.cat_name|stripslashes}</a>
    </li>
    {/foreach}
</ul>