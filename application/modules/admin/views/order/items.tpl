{include file="header.tpl"}
{include file="sidebar.tpl"}

<link rel="stylesheet" href="{$base_tlp_admin}/css/custom.css" />

<div id="content">

{include file="sidebar_header.tpl"}

{*include file="breadcrumb.tpl"*}
<div class="innerLR">

{if $msg neq ''} {include file="notes.tpl"} {/if}

<div class="widget">			
<div class="widget-head">
<h4 class="heading">{$lable.order_product}</h4>
</div>

<form name="frm_list" method="get" action="">
<div class="widget-body overflow-x">

<div class="purchase-product">					
	{include file="order/filter.tpl"}
</div>				
<div class="separator"></div>

<!-- Table -->
<div class="table-responsive">
<table class="dynamicTable fixedHeaderColReorder table">
	<thead class="bg-gray">
		<tr>
			<th>ID</th>
            <th>{$lable.fullname}</th>
			<th>{$lable.email}</th>
            <th>{$lable.phone}</th>
            <th>{$lable.address}</th>
            <th>{$lable.date_born}</th>
			<th>{$lable.order_date}</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$items item=vl}
		<tr class="gradeX">
			<td>
            <a href="{$base_url_admin}/{$control}/detail?s={$vl.id}" title="{$lable.order_detail}: {$vl.id}">{$vl.id}</a>
            </td>
            <td>
				{$vl.order_fullname}
			</td>
            <td>
				{$vl.order_email}
			</td>
			<td>
				{$vl.order_phone}
			</td>
            <td>
				{$vl.order_address}
			</td>
            <td>{$vl.date_add_born|date_format:"%d-%m-%Y"}</td>
			<td>
				{$vl.date_add|date_format:"%d-%m-%Y %H:%M"}
			</td>
		</tr>
		{/foreach}
	</tbody>
</table>
</div>

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
<script src="{$base_tlp_admin}/js/moment-with-locales.min.js"></script>
<script src="{$base_tlp_admin}/js/bootstrap-datepicker.js"></script>
<script src="{$base_tlp_admin}/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://app.AZB.com/assets/app/libs/jquery.ui/js/jquery-ui.min.js" type="text/javascript"></script>
{literal}
<script>
$(document).ready(function(){
	// var sd = new Date(), ed = new Date();
	
	$('#from').datetimepicker({
		pickTime: false,
		format: "YYYY-MM-DD",
		/*
		maxDate: ed
		*/
	});
	
	$('#to').datetimepicker({
		pickTime: false,
		format: "YYYY-MM-DD",
		/*
		minDate: sd
		*/
	});
});
</script>
{/literal}