{include file="header.tpl"}
{include file="sidebar.tpl"}

<!-- Content -->
<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}
    
    <div class="innerLR">
			
			{if $alert neq ''} {include file="notes.tpl"} {/if}
			
			<link href="{$base_tlp_admin}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
			
			<div class="widget">
				<div class="widget-head">
					<h4 class="heading">{$lable.list_items}</h4>
				</div>
				<div class="widget-body innerAll inner-2x">
					
					<table class="table table-bordered table-condensed" id="dataTables-lang">
						<thead>
							<tr>
								<th>{$lable.variable}</th>
								<th>{$lable.value_of_variable}</th>								
							</tr>
						</thead>
						<tbody>
						{foreach from=$lable key=k item=vl}
							<tr>
								<td>
									<a href="{$base_url_admin}/language/?id={$k}&option=edit" title="{$lable.modify_update}">{$k}
									</a>
								</td>
								<td>
									<input class="form-control" type="text" name="value" value="{$vl|stripslashes}" style="width:400px;" />
								</td>								
							</tr>
						{/foreach}								
						</tbody>
					</table>
					
					<a href="{$base_url_admin}/language/" id="btnLogin" class="btn btn-primary btn-sm">{$lable.add}</a>
				
				</div><!-- /.widget-body -->
			</div><!-- /.widget -->
			 
    </div>    
</div>

{include file="footer.tpl"}

<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script language="javascript">
{literal}
$(document).ready(function() { 
	$('#dataTables-lang').dataTable(); 
});
{/literal}
</script>