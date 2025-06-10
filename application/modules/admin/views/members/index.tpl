{include file="header.tpl"}
{include file="sidebar.tpl"}

<div id="content">

{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

    {if $alert neq ''}{include file='notes.tpl'}{/if}

    <link href="{$base_tlp_admin}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">

        <div class="widget-head">
            {include file="members/filter.tpl"}
        </div>
        <div class="widget-body innerAll inner-2x">
                <div class="box-search">
                    <form method="get" action="" name="box_search">
                        <input type="hidden" name="t" value="{$tab}" />
                        <div class="col-md-4 pad-left-0">
                            <input class="form-control" id="appendedInputButtons" type="text" name="q" id="q" value="{$search}" placeholder="Email / Tên / Họ" />
                        </div>

                        <div class="col-md-2 pad-left-0">
                            <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search-plus"></i> {$lable.search}</button>
                            </div>
                        </div>
                    </form>
                    <!--<div class="col-md-2 pull-right text-right">
                        <a href="{$base_url_admin}/{$control}/" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {$lable.add_new}</a>    
                    </div>-->
                </div>
                <br />
                <div class="tab-content"><!-- {$base_url_admin}/{$control}/deletemulti/ -->
                <form name="frm-data" id="frm-data" method="post" action="" name="memberForm">
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">ID</th>
                                <th>{$lable.avatar}</th>
                                <th width="20%">{$lable.email}</th>
                                <th class="text-center">{$lable.account_social}</th>
                                <th>{$lable.firstname}</th>
                                <th>{$lable.last_name}</th>
                                <th class="text-center">Ngày đăng ký</th>
                                <th class="text-center">{$lable.last_modify}</th>
                                <th class="text-center">{$lable.active}</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$items item=item}
                            <tr class="parent-status">
                                <td class="text-center">#{$item.user_id}</td>
                                <td>
                                    {if $item.avatar_url neq ''}
                                        {if $item.avatar_url|strstr:'http'}
                                            <img src="{$item.avatar_url}" style="width:100px;height:100px;" />
                                        {else} 
                                            <img src="{$link_upload}/{$item.avatar_url}" style="width:100px;height:100px;" />
                                        {/if}    
                                    {/if}
                                </td>
                                <td>
                                	{$item.email}<br />
                                    {if $item.phone neq ''}
                                    	ĐT: {$item.phone}<br />
                                    {/if}
                                    {if $item.date_birthday neq ''}
                                    	Birthday: {$item.date_birthday|date_format:"%d-%m-%Y"}<br />
                                    {/if}
                                    {if $item.gender neq ''}
                                    	Giới tính: <span style="text-transform:capitalize;">{$item.gender}</span>
                                    {/if}
                                </td>
                                <td style="max-width:200px !important;overflow:hidden;">
                                	{if $item.profile_url neq ''}
                                    <a href="{$item.profile_url}" title="{$item.profile_url}">{$item.profile_url}</a>
                                    {/if}
                                </td>
                                <td>{$item.first_name}</td>
                                <td>{$item.last_name}</td>
                                <td class="text-center">{$item.date_add|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td class="text-center">
                                    {$item.last_update|date_format:"%d-%m-%Y %H:%M"}
                                </td>
                                <td class="text-center update-status" id="status-{$item.user_id}">
                                    <input type="checkbox" name="avail" class="avail" id="{$item.user_id}" value="{$item.avail}" {if $item.avail eq 1} checked="checked"{/if} />
                                </td>
                            </tr>
                        {/foreach}
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

<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script language="javascript">
{literal}
$(document).ready(function() { 

    $('#dataTables-lang').dataTable(); 
	
    $('.avail').on('click', function(e) {     
        var user_id = $(this).attr('id');
        var status_id = $(this).val();

        $.ajax({
            url: base_url_admin +'/members/update_status/',
            type: 'POST',
            data: "id="+user_id+"&s="+status_id,
            success: function(data){ 
				
                if(data == 1) {
                    if(status_id == 1) {
                        $(this).val(0);
                        $(this).removeAttr('checked');
                    } else {
                        $(this).val(1);
                        $(this).attr('checked', 'checked');
                    }
                    event.preventDefault();
                }
            }
        });
    });

});
{/literal}
</script>