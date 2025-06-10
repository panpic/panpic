{include file="header.tpl"}
{include file="sidebar.tpl"}

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

                <div class="box-search">
                    <form method="get" action="{$action_url}" name="box_search">
                        <div class="col-md-4 pad-left-0">
                            <input class="form-control" id="appendedInputButtons" type="text" name="keyword" value="{$keyword}" placeholder="Tìm kiếm ..." />
                        </div>
                        <div class="col-md-2 pad-left-0">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit"><strong>{$lable.search}</strong></button>
							</div>
						</div>
                    </form>
                    <div class="col-md-3 pull-right">
                        <a href="{$action_url_add}" title="Add new" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add</a>
                        <a href="{$base_url_admin}/{$control}/listinactive" title="List Inactive" class="btn btn-danger"><i class="fa fa-trash-o"></i> List Inactive</a>
                    </div>
                    <div class="separator"></div>
                </div>
                <br/>

                <div class="table-responsive">
                    <form method="post" action="{$action_url_delete_multi}" name="memberForm">

                        <table class="table list-items table-bordered">
                            <tbody>
                                <tr style="background:#fafafa">
                                    <td width="3%">
										<!-- <input name="checkAll" id="checkAll" value="1" type="checkbox" /> -->
									 </td>
                                    <td width="35%"><b style="text-transform: uppercase;">User</b></td>
                                    <td width="20%"><b style="text-transform: uppercase;">Infomation</b></td>
                                    <td width="15%" class="col-md-1" style="text-align: center;text-transform: uppercase;"><b>Action</b></td>
                                </tr>
                                {if $items}
                                {foreach from=$items item=item}
                                    <tr>
                                        <td style="vertical-align: middle;">
											<!--<input type="checkbox" name="data.items[]" value="{$item.adminId}" />-->
										</td>
                                        <td style="vertical-align: middle;">
                                            {if $item.adminName}<p style="font-family: sans-serif;"><strong>{$item.adminName}</strong></p>{/if}

                                        </td>
                                        <td style="vertical-align: middle;">
                                            {if $item.adminLogin}<div><u>User Name : </u><strong>{$item.adminLogin}</strong></div>{/if}
                                            {if $item.adminRole}<div><u>Admin Role</u> : {$item.adminRole}</div>{/if}
                                            {if $item.adminDateAdd}<div><u>{$lable.date_add}</u> : {$item.adminDateAdd}</div>{/if}
                                        </td>
                                        <td style="text-align: center;vertical-align: middle;">
                                            
                                            {if $action eq 'index'}
                                            <a href="{$base_url_admin}/users/add/?id={$item.adminId}" id="btnLogin" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                            {if $item.adminId neq 1}
                                                <a data-toggle="confirmation" data-placement="left" href="javascript:void(o)" data-href="{$base_url_admin}/users/inactive/?id={$item.adminId}" class="ask btn btn-danger btn-sm" title="Remove"><i class="fa fa-trash-o"></i></a>
                                            {/if}
                                            {else}
                                                {if $item.adminId neq 1}
                                                    <a data-toggle="confirmation" data-placement="left" href="javascript:void(o)" data-href="{$base_url_admin}/users/remove/?id={$item.adminId}" class="ask btn btn-danger btn-sm" title="Remove"><i class="fa fa-times"></i></a>
                                                {/if}
                                            {/if}
                                        </td>
                                    </tr>
                                {/foreach}
                                {/if}
								
								<!--
                                <tr>
                                    <td>
                                        <input name="checkAll" id="checkAll" value="1" type="checkbox" />
                                    </td>
                                    <td colspan="10">
                                        <button data-placement="right" type="submit" class="ask btn btn-default" name="deleteMulti" id="deleteMulti">{$lable.delete.value}</button>
                                    </td>
                                </tr>
								-->
                            </tbody>
                        </table>
                    </form>
                </div>

            </div><!-- /.widget-body -->
        </div><!-- /.widget -->

        {$links}

    </div>    
</div>

{include file="footer.tpl"}

<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-confirmation.js"></script>
<script language="javascript">
{literal}
	$(document).ready(function () {
		!function (cash) {
			$(function () {
				$('[data-toggle="confirmation"]').confirmation();
			});
		}(window.jQuery)
	});
{/literal}
</script>