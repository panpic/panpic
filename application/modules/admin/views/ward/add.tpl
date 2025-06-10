{include file="header.tpl"}
{include file="sidebar.tpl"}

<div id="content">

{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

    {if $alert neq ''}{include file='notes.tpl'}{/if}
	<form class="form-horizontal margin-none" id="fdistrict" name="fdistrict" method="post" action="{$base_url_admin}/{$control}/add?id={$data.district_id}&option={$option}" autocomplete="off" novalidate="novalidate">
	
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
						<label class="col-md-4 control-label" for="state_id">{$lable.city_province}</label>
						<div class="col-md-8">
							<select id="state_id" name="data[state_id]" class="form-control">
                            	{foreach from=$provience item=vl}
                                	<option value="{$vl.state_id}">{$vl.state}</option>
                                {/foreach}
                            </select>
							<span class="error red"></span>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-4 control-label" for="district_id">{$lable.district}</label>
						<div class="col-md-8">
							<select id="district_id" name="data[district_id]" class="form-control">
                            	{foreach from=$district item=d}
                                	<option value="{$d.district_id}">{$d.district}</option>
                                {/foreach}
                            </select>
							<span class="error red"></span>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-4 control-label" for="state">{$lable.ward}</label>
						<div class="col-md-8">
							<input class="form-control" id="district" name="data[district]" type="text" data-staterequired="{$lable.state_name_required}" value="{$data.district}" />
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
                                <button type="button" id="btn-save" class="btn btn-primary"><i class="fa fa-check-circle"></i> {$lable.btn_save}</button>
                                <a href="{$base_url_admin}/{$control}" class="btn btn-default"><i class="fa fa-times"></i> {$lable.cancel}</a>
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
	
	
	$("#state_id").on('change', function(){
		var state_id = $('#state_id').val();
		if(state_id != '') {
			$.ajax({
				url: base_url_admin +'/ward/ajaxDistrict/',
				type: 'GET',
				data: "id="+state_id,
				success: function(data){ 
					$('#district_id').html(data);
				}
			});
		}
	});
	
	$("#btn-save").on('click', function(){
		var district = $('#district').val();
		if(district == '') {
			alert("Bạn phải nhập Quận/Huyện");
		} else {
			$('#fdistrict').submit();
		}
	});
	
});
{/literal}
</script>