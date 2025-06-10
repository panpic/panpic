<div class="innerLR">
<h2 class="margin-none">{$lable.list_pages}</h2>
<div class="widget widget-heading-simple widget-body-white">					
    <div class="widget-body">
        <form class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-md-6">
                <label class="col-sm-2 control-label">{$lable.keyword}</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" 
                    placeholder="{$lable.btn_search}" name="keyword" value="{$keyword}">
                </div>
            </div>
            <div class="col-md-4">
                <label class="col-md-2 control-label" for="page_cat">{$lable.page_cat}</label>
                <div class="col-md-10">
                    <select class="form-control" id="page_cat" name="page_cat">
                    <option value="">---</option>
                    {foreach from=$page_catArray key = k item=v}
                    <option {if $page_cat eq $k}selected {/if}value="{$k}">{$v}</option>
                    {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-default" type="submit" title="{$lable.btn_search}">
                    <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>    
        </form>
    </div>
</div>

<!-- Table -->
<div class="widget">
    <div class="widget-head">
        <h4 class="heading">{$lable.list_pages}</h4>
    </div>
    <div class="widget-body innerAll inner-2x">
    	{if $alert neq ''} {include file="notes.tpl"} {/if}
        
        <div class="form-group">
            {**
            <a href="{$base_url_admin}/{$control}/add" class="btn btn-success mb-15">
                <i class="fa fa-plus"></i> {$lable.add_page}
            </a>
            **}
            {if isset($smarty.get.avail) && $smarty.get.avail eq '0' || isset($smarty.get.avail) && $smarty.get.avail eq 'trash'}
            <a class="btn btn-primary mb-15" href="{$base_url_admin}/pages" title="{$lable.list_pages}">
                <i class="fa fa-arrow-left"></i>
            </a>
            {else}
                {**
                <a class="btn mb-15 {if $trash }btn-primary{else}btn-primary btn-stroke{/if}" href="{$base_url_admin}/pages.html?avail=trash" title="{$lable.trash}">
                <i class="fa fa-trash-o"></i>
                </a>
                **}
            {/if}
        </div>
        <table class="table table-striped table-responsive swipe-horizontal table-primary variables-list">
           <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">{$lable.page_title}</th>
                    <th class="text-center">{$lable.page_cat}</th>
                    <th class="text-center">{$lable.date_add}</th>
                    <th class="text-center">{$lable.action}</th>
                </tr>
            </thead>
            <tbody>
                {if $list}
                {foreach from=$list item=item}                                
                    <tr>
                        <td>
                            {$item.page_id}
                        </td>
                        <td>
                            {$item.page_title}
                        </td>
                        <td>
                            {assign var=page_cate value=$item.page_cat}
                            {$page_catArray.$page_cate}
                        </td>
                        <td>
                            {date("d/m/Y",$item.date_add)}
                        </td>
                        <td class="text-center">
                         {if $item.avail eq 0 }
                         	{**
                            <a class="btn btn-danger delpage" data-message="{$lable.confirm_del}?" data-id = "{$item.page_id}" title="{$lable.delete}">
                                <i class="fa fa-trash-o"></i></a>
                            <a class="btn btn-primary" href="{$base_url_admin}/restore-page.html?id={$item.page_id}" title="{$lable.restore}">
                            <i class="fa fa-reply"></i></a>
                            **}

                            {else if $item.avail eq 1}
                            <a class="btn btn-sm btn-success" href="{$base_url_admin}/pages/add?id={$item.page_id}" title="{$lable.edit}">
                                <i class="fa fa-edit"></i>
                            </a>
                            {**
                            {$base_url_admin}/pages/add?lang={$item.lang}&id={$item.page_id}&langp={$item.lang}
                            <a class="btn btn-stroke btn-circle btn-danger delpage" data-message="{$lable.confirm_del}?" data-id = "{$item.page_id}" title="{$lable.delete}">
                            <i class="fa fa-trash-o"></i></a>
                             **}
                         {/if}                                            
                        </td>
                    </tr>
                {/foreach}
                {/if}
            </tbody>
        </table>
    </div>
</div>
<div class="dataTables_paginate paging_bootstrap">
{$links}
</div><!-- /Table -->
</div>

<script>	
{literal}
$(document).ready (function(){
	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
});
{/literal}
</script>
        