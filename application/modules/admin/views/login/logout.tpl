{include file="header.tpl"}

<div class="container">

<div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="login-panel panel panel-default">
<div class="panel-body">
	{if $alert neq ''} {include file="notes.tpl"} {/if}
</div>
</div>
</div>
</div>
</div>

<!-- Core Scripts - Include with every page -->
<script src="{$base_tlp_admin}/js/jquery-1.10.2.js"></script>
<script src="{$base_tlp_admin}/js/bootstrap.min.js"></script>
<script src="{$base_tlp_admin}/js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- SB Admin Scripts - Include with every page -->
<script src="{$base_tlp_admin}/js/sb-admin.js"></script>

</body>
</html>