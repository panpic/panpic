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
		<div class="col-md-5">
			<input class="form-control" type="text" name="q" value="{$search.q}" placeholder="Họ tên hoặc SĐT..." />
		</div>
		<div class="col-md-2">
			<button type="submit" class="btn btn-primary"><i class="fa fa-search-minus"></i> {$lable.bt_search}</button>
		</div>
	</div>
</div>				
<div class="separator"></div>
<!-- Table -->
<table class="dynamicTable fixedHeaderColReorder table">
	<thead class="bg-gray">
		<tr>
			<th>ID</th>
			<th>Họ tên</th>
			<th>Số điện thoại</th>
			<th>Nội dung</th>
			<th>Email</th>
            <th>Ngày</th>
			<th class="nosort text-center middle">{$lable.action}</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$items item=vl}
		<tr class="gradeX">
			<td>{$vl.id}</td>
			<td>{$vl.fullname}</td>
            <td>{$vl.phone}</td>
            <td>{$vl.content|stripslashes}</td>
			<td>{$vl.email|stripslashes}</td>
			<td>
				{$vl.date_add|date_format:"%d-%m-%Y %H:%M"}
			</td>
			<td class="text-center middle">
				<a href="javascript:void(0)" rel="{$base_url_admin}/{$control}/delete?id={$vl.id}" class="button_margin ask_pop text-danger" title="{$lable.btn_delete}"><i class="fa fa-trash-o fa-lg"></i></a>
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
{include file="modal_confirm.tpl"}
<script>
	var update_fail = "{$lable.update_fail}", notes_update_success = "{$lable.notes_update_success}", notes_update_fail = "{$lable.notes_update_fail}";

	{literal}
	$(document).ready(function(){

		$(".ask_pop").click(function(){
			var page = $(this).attr('rel');
			$('#confirm-footer').attr("href", page);
			$("#modal-confirm-delete").modal("show");
			$('#confirm-footer').on('click', '', function (e) {
				var page = $(this).attr('href');
				window.location.replace(page);
			});
		});

	});
	{/literal}
</script>