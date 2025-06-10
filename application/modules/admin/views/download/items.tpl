{include file="header.tpl"}
{include file="sidebar.tpl"}
{literal}
<style type="text/css">
.btn-sm, .btn-group-sm>.btn{padding:5px 7px;}
</style>
{/literal}

<link href="{$base_tlp_admin}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    
<div id="content">

{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">

    {if $alert neq ''}{include file='notes.tpl'}{/if}

    <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
        <div class="widget-head">
            {include file="blogs/filter.tpl"}
        </div>
        <div class="widget-body innerAll inner-2x">
                <div class="box-search">
                    <form method="get" action="" name="box_search">
                        <input type="hidden" name="t" value="{$tab}" />
                        <div class="col-md-4 pad-left-0">
                            <input class="form-control" id="appendedInputButtons" type="text" name="q" id="q" value="{$search}" placeholder="{$lable.please_input_search_title_content}" />
                        </div>
                        <div class="col-md-3">
                            <select name="cat" id="category_id" class="form-control">
                            	<option value="">--- Tất cả danh mục ---</option>
                                {$categories.cmb}
                            </select>
                        </div>
                        <div class="col-md-2 pad-left-0">
                            <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search-plus"></i> {$lable.search}</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-2 pull-right text-right">
                        <a href="{$base_url_admin}/{$control}/" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {$lable.add_new}</a>    
                    </div>
                </div>
                <br />
                <div class="tab-content"><!-- {$base_url_admin}/{$control}/deletemulti/ -->
                <form name="frm-data" id="frm-data" method="post" action="" name="memberForm">
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                        <thead>
                            <tr>
                                <th width="3%">&nbsp;</th>
                                <th width="5%" class="text-center">ID</th>
                                <th>{$lable.image}</th>
                                <th>{$lable.file}</th>
                                <th width="20%">{$lable.title}</th>
                                <th>{$lable.date_add}</th>
                                <th>{$lable.last_modify}</th>
                                <th class="text-center">{$lable.no_download}</th>
                                <th style="min-width:80px;">{$lable.action}</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$items item=item}
                            <tr class="parent-status">
                                <td class="check-id">
                                  <input name="checkAll[]" value="{$item.blog_id}" type="checkbox" />
                                </td>
                                <td class="text-center">{$item.blog_id}</td>
                                <td>
                                    {if $item.path_image neq ''}
                                        {assign var=img value=$item.path_image}
                                    {elseif $item.path_image_thumb neq ''}
                                        {assign var=img value=$item.path_image_thumb}
                                    {/if}
                                    <img src="{$link_upload}/{$img}" style="width:110px;height:80px;" />
                                </td>
                                <td>
                                	{if $item.title_2 neq ''}
                                	<a href="{$base_url_admin}/{$control}/downloadfile?id={$item.blog_id}" target="_blank">
                                    <i class="{$item.short|trim}" style="font-size:28px;"></i>{$item.title_2|substr_filename}
                                    </a> 
                                    {/if}
                                </td>
                                <td>
                                {if $item.avail eq 1}
                                	{$item.title|stripslashes}
                                {else}
                                    {$item.title|stripslashes}    
                                {/if}    
                                {if $item.avail eq $ACTIVE_DUPLICATE}
                                	(<i class="fa fa-copy" title="{$lable.duplicated}"></i>)
                                {/if}
                                {if $tab eq $BLOG_TAB_MEMBER}
                                	<br />
                                    {assign var=member value=$item.member_id|getmember}
                                    ({$lable.members}: {$member.fullname})
                                {/if}
                                </td>
                                <td>{$item.date_add|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td>{$item.last_update|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td class="text-center">{$item.hits}</td>
                                
                                <td style="text-align:center;">
                                	{if $tab eq $BLOG_TAB_INACTIVE}
                                        <a href="{$base_url_admin}/{$control}/restore/?id={$item.blog_id}" class="btn btn-sm btn-success button_margin" title="{$lable.restore}"><i class="fa fa-undo"></i></a>
                                    {else}
                                        <a href="{$base_url_admin}/{$control}/duplicate/?id={$item.blog_id}" class="btn btn-sm btn-success button_margin" title="Duplication item"><i class="fa fa-copy"></i></a> 
                                        <a href="{$base_url_admin}/{$control}/?id={$item.blog_id}&option=edit" class="btn btn-sm btn-success button_margin" title="Update"><i class="fa fa-pencil"></i></a>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                            <tr>
                                <td><input name="btnCheckAll" id="checkAll" value="1" type="checkbox" /></td>
                                <td colspan="10">
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
<script src="{$base_tlp_admin}/js/blog.js"></script>