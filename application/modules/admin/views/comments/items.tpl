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
            {include file="comments/filter.tpl"}
        </div>
        <div class="widget-body innerAll inner-2x">
                <div class="box-search">
                    <form method="get" action="" name="box_search">
                        <input type="hidden" name="t" value="{$tab}" />
                        <div class="col-md-4 pad-left-0">
                            <input class="form-control" id="appendedInputButtons" type="text" name="q" id="q" value="{$search}" placeholder="{$lable.blog} / {$lable.comment}" />
                        </div>
                        <div class="col-md-2 pad-left-0">
                            <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search-plus"></i> {$lable.search}</button>
                            </div>
                        </div>
                    </form>
                    <!-- <div class="col-md-2 pull-right text-right">
                        <a href="{$base_url_admin}/{$control}/" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {$lable.add_new}</a>    
                    </div> -->
                </div>
                <br />
                <div class="tab-content">
                <form name="frm-data" id="frm-data" method="post" action="" name="memberForm">
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                        <thead>
                            <tr>
                                <th width="3%">&nbsp;</th>
                                <th width="5%" class="text-center">ID</th>
                                <th>{$lable.blog}</th>
                                <th width="20%">{$lable.comment}</th>
                                <th>{$lable.date_add}</th>
                                <th>{$lable.members}</th>
                                <th class="text-center">{$lable.admin_verify}</th>
                                <th class="text-center">{$lable.active}</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$items item=item}
                            <tr class="parent-status">
                                <td class="check-id">
                                  <input name="checkAll[]" value="{$item.id}" type="checkbox" />
                                </td>
                                <td class="text-center">{$item.id}</td>
                                <td>
                                {if $item.post_avail eq 1 && $item.post_admin_avail eq 1}
                                	{assign var=blog_url value=$item.slug|url_blog_detail}
                                    <a href="{$blog_url}" target="_blank">{$item.title|stripslashes}</a>
                                {else}
                                	{$item.title|stripslashes}
                                {/if}    
                                </td>
                                <td>{$item.comments}</td>
                                <td>{$item.date_add|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td>
                                	{if $item.email neq ''}
                                    	{$item.email}<br />{$item.fullname}
                                    {else}
                                    	{$item.comment_email}<br />{$item.comment_fullname}
                                    {/if}
                                </td>
                                <td class="text-center" id="home-display-{$item.id}">
                                    <input type="checkbox" name="display_home-{$item.id}" class="display-home" rel="{$item.id}" value="{$item.ADMIN_BLOG_VERIFY}" {if $item.comment_verify eq $ADMIN_BLOG_VERIFY} checked="checked"{/if} />
                                </td>
                                <td class="text-center update-status" id="status-{$item.id}">
                                    <input type="checkbox" name="avail" class="avail" id="{$item.id}" value="{$item.avail}" {if $item.avail eq 1} checked="checked"{/if} />
                                </td>
                            </tr>
                        {/foreach}
                            <tr>
                                <td>
                                    <input name="btnCheckAll" id="checkAll" value="1" type="checkbox" />
                                </td>
                                <td colspan="7">
                                {if $tab eq $BLOG_TAB_INACTIVE}
                                    <button onclick="return confirm('{$lable.are_you_sure_empty_recycle}')" data-placement="right" type="submit" class="ask btn btn-danger" name="emptyRecycleBin" id="emptyRecycleBin"><i class="fa fa-trash-o"></i> {$lable.empty_reycle_bin}</button>
                                {else}
                                    <button onclick="return confirm('{$lable.are_you_sure_delete}')" data-placement="right" type="submit" class="ask btn btn-default" name="deleteMulti" id="deleteMulti"><i class="fa fa-trash-o"></i> {$lable.btn_delete}</button>
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

<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script language="javascript">
{literal}
$(document).ready(function() { 

    $('#dataTables-lang').dataTable(); 
	
	$("#deleteMulti").on('click', function(){
	   var frm_action = base_url_admin+'/'+current_control+'/deletemulti/'
	   $('#frm-data').attr('action', frm_action);
	   $('#frm-data').submit();	       
	});
	
	// empty recycle bin
	$("#emptyRecycleBin").on('click', function(){
	   var frm_action = base_url_admin+'/'+current_control+'/removemulti/'
	   $('#frm-data').attr('action', frm_action);
	   $('#frm-data').submit();	       
	});

    $('.avail').on('click', function(e) {     
        var blog_id = $(this).attr('id');
        var status_id = $(this).val();

        $.ajax({
            url: base_url_admin + '/comments/update_status/',
            type: 'POST',
            data: "id="+blog_id+"&s="+status_id,
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

    $('.display-home').on('click', function(e) {     
        var blog_id = $(this).attr('rel');
        var display_home; // = $(this).val();
		var name_field = 'display_home-'+blog_id;
		
		if ( $('input[name='+name_field+']').get(0).checked == true ) { //Checked
			display_home = 1
		} else { // No checked
			display_home = 0
		} 

        $.ajax({
            url: base_url_admin + '/comments/updateVerify',
            type: 'POST',
            data: "id="+blog_id+"&d="+display_home,
            success: function(data){
				if(data == 1) { }
            }
        });
    });
});
{/literal}
</script>