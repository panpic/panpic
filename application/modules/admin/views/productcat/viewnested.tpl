{include file="header.tpl"}
{include file="sidebar.tpl"}

<link rel="stylesheet" href="{$base_tlp_admin}/css/custom.css" />

<div id="content">

{include file="sidebar_header.tpl"}

{include file="breadcrumb.tpl"}
<div class="innerLR">

{if $msg neq ''} {include file="notes.tpl"} {/if}

<div class="widget">			
<div class="widget-head">
<h4 class="heading">{$heading}</h4>
</div>

<form name="frm_list" method="get" action="">
<div class="widget-body overflow-x">

<div class="purchase-product">					
	<div class="row">
		<div class="separator bottom"></div>

		<div class="col-md-1">
			<h3>&nbsp;  </h3>					
		</div>
		<div class="col-md-5">
			<label class="strong"> &nbsp; </label>
			<input class="form-control" type="text" name="cat_name" value="{$search.cat_name}" placeholder="Category" />							
		</div>
		<div class="col-md-2">
			<h4>&nbsp; </h4>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search-minus"></i> {$lable.bt_search}</button>
		</div>
		<div class="col-md-4">
		<div class="form-actions pull-right">
			<h4>&nbsp; </h4>
			<a href="{$base_url_admin}/{$control}/" id="btnAddUser" class="btn btn-primary">{$lable.add_new}</a>
		</div>
		</div>
		
	</div>
</div>				
<div class="separator"></div>

<!-- Table -->
<table class="dynamicTable fixedHeaderColReorder table">
	<thead class="bg-gray">
		<tr>
			<th>ID</th>
			<th>Parent</th>
			<th>{$lable.category}</th>
			<th>{$lable.tier}</th>
            <th>Thứ tự</th>
			<th>&nbsp;  </th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$items item=vl}
		<tr class="gradeX">
			<td>{$vl.product_cat_id}</td>
			<td>{$vl.parents}</td>
			<td>
				{if $vl.level eq 0}
					<b style="color:red">{$vl.cat_name|stripslashes|stripslashes}</b>
				{elseif $vl.level eq 1}
					+ <b>{$vl.cat_name|stripslashes}</b>
				{else}			
					{math assign="sub_level" equation='x*y' x=12 y=$vl.level}
					<span style="padding-left:{$sub_level}px;"> - - {$vl.cat_name|stripslashes}</span>
				{/if}
			</td>
			<td>
				{$vl.level}
			</td>
            <td>
            	{if $vl.level eq 1}{$vl.posts_no}{/if}
            </td>
			<td class="right right_padding">
				
                {if $vl.level gt 0}					
				<a href="{$base_url_admin}/{$control}/?id={$vl.product_cat_id}&option=edit" class="btn btn-sm btn-success button_margin" title="Update {$vl.cat_name}"><i class="fa fa-pencil"></i></a>	
				{/if}
				
                {if $vl.level gt 1}
				<a data-toggle="confirmation" data-placement="left" href="javascript:void(0)" data-href="{$base_url_admin}/{$control}/delnested/?id={$vl.product_cat_id}" class="ask btn btn-sm btn-danger button_margin" title="Delete"><i class="fa fa-trash-o"></i></a>
				{/if}
									
			</td>
		</tr>
		{/foreach}
	</tbody>
</table>
</div>
</div>
        
<div class="">            
    <div class="pull-right">
        {$links}
    </div>
</div>
<div class="clearfix"></div>   
</form>	

</div>    
</div>

{include file="footer.tpl"}

<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-confirmation.js"></script>

<script>
{literal}
$(document).ready(function() { 

    !function ($) {
        $(function(){
            $('[data-toggle="confirmation"]').confirmation();	
        });
    }(window.jQuery)

});
{/literal}
</script>

