{include file="header.tpl"}
{include file="sidebar.tpl"}
{literal}
<style type="text/css">
.btn-sm, .btn-group-sm>.btn{padding:5px 7px;}
</style>
{/literal}
<div id="content">

{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

    {if $alert neq ''}{include file='notes.tpl'}{/if}

    <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
		<div class="widget-head">
            {include file="provience/filter.tpl"}
        </div>
        
        <div class="widget-body innerAll inner-2x">
                <div class="box-search">
                    <form method="get" action="" name="box_search">
                        <input type="hidden" name="t" value="{$tab}" />
                        <div class="col-md-4 pad-left-0">
                            <input class="form-control" id="appendedInputButtons" type="text" name="q" id="q" value="{$search.q}" placeholder="{$lable.please_input_search_title_content}" />
                        </div>
                        <div class="col-md-2 pad-left-0">
                            <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search-plus"></i> {$lable.search}</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-2 pull-right text-right">
                    	{**
                        <a href="{$base_url_admin}/{$control}/" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {$lable.add_new}</a>    **}
                    </div>
                </div>
                <br />
                <div class="tab-content">
                <form name="frm-data" id="frm-data" method="post" action="{$base_url_admin}/{$control}" name="memberForm">
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                        <thead>
                            <tr>
                                <th width="3%">&nbsp;</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">{$lable.city_province}</th>
                                <th class="text-center">{$lable.pos}</th>
                                <th class="text-center">{$lable.action}</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$items item=item}
                            <tr class="parent-status">
                                <td class="check-id">
                                  <input name="checkAll[]" id="check_id" value="{$item.state_id}" type="checkbox" />
                                </td>
                                <td class="text-center">{$item.state_id}</td>
                                <td class="text-center">{$item.state}</td>
                                <td class="text-center">{$item.pos}</td>
                                <td style="text-align:center;">
                                    {if $tab eq $BLOG_TAB_INACTIVE}
                                    	<a href="{$base_url_admin}/{$control}/restore?id={$item.state_id}" class="btn btn-sm btn-danger button_margin" title="Restore"><i class="fa fa-undo"></i></a>
                                    {else}
                                        <a href="{$base_url_admin}/{$control}/add?id={$item.state_id}&option=edit" class="btn btn-sm btn-success button_margin" title="Update"><i class="fa fa-pencil"></i></a>
                                        {**
                                        <a href="{$base_url_admin}/{$control}/del?id={$item.state_id}" class="btn btn-sm btn-danger button_margin" title="Delete"><i class="fa fa-trash-o"></i></a>
                                        **}
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                            <tr>
                                <td><input name="btnCheckAll" id="checkAll" value="1" type="checkbox" /></td>
                                <td colspan="10">
                                {if $tab eq $BLOG_TAB_INACTIVE}
                                    <button onclick="return confirm('{$lable.are_you_sure_empty_recycle}')" data-placement="right" type="button" class="ask btn btn-danger" name="emptyRecycleBin" id="emptyRecycleBin"><i class="fa fa-trash-o"></i> {$lable.empty_reycle_bin}</button>
                                {else}
                                    <button onclick="return confirm('{$lable.are_you_sure_delete}')" data-placement="right" type="button" class="ask btn btn-default" name="deleteMulti" id="deleteMulti"><i class="fa fa-trash-o"></i> {$lable.btn_delete}</button>
                                 {/if}   
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                </div>
                <div class="">
                    <div class="pull-right">
                       {$links}
                    </div>
                </div>
                <div class="clearfix"></div>
        </div><!-- /.widget-body -->

    </div><!-- /.widget -->
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
	
	// Delete to Recycle bin
	$("#deleteMulti").on('click', function(){
		var has_checked = 0;
		$('#check_id').each(function() {
			if(this.checked){
				has_checked = 1;
			}
		});
		
		if(has_checked == 1) {
		   var frm_action = base_url_admin+'/'+current_control;
		   $('#frm-data').attr('action', frm_action);
		   $('#frm-data').submit();	       
		}
	});
	
	// Empty recycle bin
	$("#emptyRecycleBin").on('click', function(){
		var has_checked = 0;
		$('#check_id').each(function() {
			if(this.checked){
				has_checked = 1;
			}
		});
		
		if(has_checked == 1) {
			var frm_action = base_url_admin+'/'+current_control+'/removemulti/'
		   	$('#frm-data').attr('action', frm_action);
		   	$('#frm-data').submit();
		}   
	});
	
});
{/literal}
</script>