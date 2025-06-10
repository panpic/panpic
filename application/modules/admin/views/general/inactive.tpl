{include file="header_main.tpl"}

<div id="wrapper">
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
		{include file="nav_bar_toplink.tpl"}
		{include file="nav_bar_left.tpl"}	
	</nav>
	
	<!-- Page-Level Plugin CSS - Tables -->
    <link href="{$base_tlp_admin}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		
	<div id="page-wrapper">
	
		{include file="breadcrumb.tpl"}
		
		<div class="row">
			{if $alert neq ''} {include file="notes.tpl"} {/if}
			
			<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">{$heading}</div>
				<div class="panel-body">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-lang">
						<thead>
							<tr>
								<th>Parent</th>
								<th>{$lang.category.value}</th>
								<th>Thao tác</th>									
							</tr>
						</thead>
						<tbody>
						{foreach from=$items item=vl}
							<tr class="{cycle values="odd gradeX, event gradeC"}">
								<td>{$vl.parents}</td>
								<td>
									{if $vl.level eq 0}
										<b style="color:red">{$vl.cat_name}</b>
									{elseif $vl.level eq 1}
										+ <b>{$vl.cat_name}</b>
									{else}			
										{math assign="sub_level" equation='x*y' x=8 y=$vl.level}
										<span style="padding-left:{$sub_level}px;"> - - {$vl.cat_name}</span>
									{/if}
								</td>
								<td>
								<a href="{$base_url_admin}{$form.control}/del/?id={$vl.cat_id}&option=restore" title="Sửa">{$lang.restore.value}</a> 
								{if $ss_admin->admin_role eq 'ADMINISTRATOR'}
								<br />
								<!--
								<a href="{$base_url_admin}{$form.control}/remove/?id={$vl.cat_id}" class="ask btn_remove" title="{$lang.remove_out.value}">{$lang.remove_out.value}</a>
								-->
								{/if}
								</td>
							</tr>
						{/foreach}								
						</tbody>
					</table>
					
					{include file="paginator.tpl"}					
					
					<a href="{$base_url_admin}{$form.control}/" id="btnLogin" class="btn btn-primary btn-sm">{$lang.add.value}</a> &nbsp;
					<a href="{$base_url_admin}{$form.control}/view/" id="btnView" class="btn btn-primary btn-sm">{$lang.list.value}</a>					
					
					</div><br class="clear" />				
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col-lg-12 -->			
		</div><!-- /.row -->
		
		<div class="row">{include file="body-footer.tpl"}</div>
		
	</div><!-- /#page-wrapper -->			
</div><!-- /#wrapper -->

{include file="footer.tpl"}

<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="{$base_tlp_admin}/js/jconfirmaction.jquery.js"></script>
<script language="javascript">
{literal}
$(document).ready(function() { 
	$('.ask').jConfirmAction({question : "Xóa vĩnh viễn ?", yesAnswer : "Xóa", cancelAnswer : "Không"}); 
	$('.ask').jConfirmAction(); $('#flashMsg').delay(4000).fadeOut("slow");
});
{/literal}
</script>