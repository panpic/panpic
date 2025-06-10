{include file="header.tpl"}
{include file="sidebar.tpl"}

<div id="content">

{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

    {if $alert neq ''}{include file='notes.tpl'}{/if}
	<form class="form-horizontal margin-none" id="fstate" name="fstate" method="post" action="{$base_url_admin}/provience/add?id={$data.state_id}&option={$option}" autocomplete="off" novalidate="novalidate">
	<input type="hidden" value="{$data.state_id}" name="data[state_id]" id="state_id">
	<!-- Widget -->
	<div class="widget">

		<!-- Widget heading -->
		<div class="widget-head">
			<h4 class="heading">{$lable.admin_state_add}</h4>
		</div>

		<!-- // Widget heading END -->
		<div class="widget-body innerAll inner-2x">

			<!-- Row -->
			<div class="row innerLR">
				<!-- Column -->
				<div class="col-md-6">
					<!-- Group -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="state">{$lable.city_province}</label>
						<div class="col-md-8">
							<input class="form-control" id="state" name="data[state]" type="text" data-staterequired="{$lable.state_name_required}" value="{$data.state}" />
							<span class="error red"></span>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-4 control-label" for="pos">{$lable.pos}</label>
						<div class="col-md-2">
							<input class="form-control" id="pos" name="data[pos]" type="text" value="{$data.pos}" />
							<span class="error red"></span>
						</div>
					</div>
					<!-- // Group END -->
                    
                    <div class="separator"></div>
                    <!-- Form actions -->
        			<div class="form-group">
                    	<div class="col-md-4"> </div> 
                        <div class="col-md-8">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {$lable.btn_save}</button>
                                <a href="{$base_url_admin}/provience" class="btn btn-default"><i class="fa fa-times"></i> {$lable.cancel}</a>
                            </div>
                        </div>
                    </div>

				</div>
				<!-- // Column END -->
			</div>
			<!-- // Row END -->
			
			<!-- // Form actions END -->
		</div>
	</div>
	<!-- // Widget END -->
</form>

</div>
</div>
{include file="footer.tpl"}

<script language="javascript">
{literal}
$(document).ready(function() { 

    setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
	
});
{/literal}
</script>