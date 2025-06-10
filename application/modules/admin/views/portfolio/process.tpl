{include file="header.tpl"}
<link href="{$base_tlp_admin}/js/sweet-alert/sweetalert.css" rel="stylesheet" />
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

    <link href="{$base_tlp_admin}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">

        <div class="widget-head">
            {include file="services/filter_process.tpl"}
        </div>
        <div class="widget-body innerAll inner-2x">
                <div class="box-search">
                    {include file="portfolio/form_process.tpl"}
                </div>
                <br />
                <div class="tab-content">
                <hr />
                <form name="frm-items" id="frm-items" method="get" action="">
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">ID</th>
                                <th>{$lable.image}</th>
                                <th width="35%">{$lable.title}</th>
                                <th>{$lable.date_add}</th>
                                <th>{$lable.last_modify}</th>
                                <th style="min-width:80px;">{$lable.action}</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$items item=item}
                            <tr class="parent-status">
                                <td class="text-center">{$item.id}</td>
                                <td>
                                    {if $item.path_image neq ''}
                                        <img src="{$link_upload}/{$item.path_image}" style="width:110px;height:80px;" />
                                    {/if}
                                </td>
                                <td>
                                {$item.title_process|stripslashes}
                                </td>
                                <td>{$item.date_add|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td>{$item.last_update|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td style="text-align:center;">
                                	<a href="{$base_url_admin}/{$control}/process/?s={$item.blog_id}&id={$item.id}&option=edit" class="btn btn-sm btn-success button_margin" title="Update"><i class="fa fa-pencil"></i></a>
                                    
                                    <a href="javascript:void(0)" data-href="{$base_url_admin}/{$control}/process_delete?s={$item.blog_id}&id={$item.id}" class="btn btn-sm btn-danger button_margin confirm" title="{$lable.delete}"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </form>
                </div>
                <div class="clearfix"></div>
        </div><!-- /.widget-body -->

    </div><!-- /.widget -->
</div>
</div>
{include file="footer.tpl"}

<script src="{$base_url}/ckeditor/ckeditor.js" charset="utf-8"></script>
<script src="{$base_url}/ckfinder/ckfinder.js" charset="utf-8"></script>
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>

<script src="{$base_tlp_admin}/js/sweet-alert/sweetalert.min.js"></script>
<script src="{$base_tlp_admin}/js/sweet-alert.js"></script>

<script language="javascript">
var are_you_sure_delete = "{$lable.are_you_sure_delete}";
var yes_delete_it = "{$lable.yes_delete_it}";

{literal}
$(document).ready(function() { 
	
	var content_process = CKEDITOR.replace('content_process');
	CKFinder.setupCKEditor( content_process, '/ckfinder/');
	
    setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
		
	$('#btn_add_process').click(function (e) {
		var title_process = $('#title_process').val();
		
		if(title_process == '') {
			alert("Vui lòng nhập tên logo!");
		} else {
			$('#frm_data').submit();	
		}
	});
	
	$(".confirm").click(function(){
		var _href = $(this).data("href")
		swal({
			title: are_you_sure_delete,
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: yes_delete_it,
			closeOnConfirm: false
		}, function() {
				location.replace( _href );
			}
		);
	});
	
});
{/literal}
</script>