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
		</div><!-- /.row -->
		
		<div class="row">{include file="body-footer.tpl"}</div><!-- /.row -->
		
	</div><!-- /#page-wrapper -->			
</div><!-- /#wrapper -->

{include file="footer.tpl"}
<!-- Page-Level Plugin Scripts - Tables -->
<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
{literal}
$(document).ready(function() { $('#dataTables-lang').dataTable(); });
{/literal}
</script>