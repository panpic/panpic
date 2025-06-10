{include file="header.tpl"}
{include file="sidebar.tpl"}
<link rel="stylesheet" type="text/css" href="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.css" />

<div id="content">
{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}
<div class="innerLR">
<div class="relativeWrap">
           
    <div class="col-md-9 l-r-0">
        <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
            
            <div class="widget-body">
                <div class="tab-content">
                    {if $alert neq ''} {include file="notes.tpl"} {/if}
                    
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                    <thead>
                        <tr>
                            <th>Album</th>
                            <th width="5%" class="text-center">ID</th>
                            <th>{$lable.image}</th>
                            <th width="20%">{$lable.title}</th>
                            <th>{$lable.date_add}</th>
                            <th class="text-center">{$lable.active}</th>
                            <th style="min-width:80px;">{$lable.action}</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach from=$gallery item=item}
                        <tr class="parent-status">
                            <td class="check-id">
                              {$item.album_name}
                            </td>
                            <td class="text-center">{$item.id}</td>
                            <td>
                                {if $item.path_image neq ''}
                                    <img src="{$link_upload}/{$item.path_image}" style="width:110px;height:80px;" />
                                {/if}
                            </td>
                            <td>
                                {$item.title|stripslashes}    
                            </td>
                            <td>{$item.date_add|date_format:"%d-%m-%Y %H:%M"}</td>
                            <td class="text-center update-status" id="status-{$item.id}">
                                <input type="checkbox" name="avail" class="avail_gallery" id="{$item.id}" value="{$item.avail}" {if $item.avail eq 1} checked="checked"{/if} />
                            </td>
                            <td style="text-align:center;">
                                <a href="{$base_url_admin}/{$control}/gallery?album={$item.album_id}&id={$item.id}&option=edit" class="btn btn-sm btn-success" title="Update"><i class="fa fa-pencil"></i></a>
                                <a data-toggle="confirmation" data-placement="left" href="javascript:void(0)" data-href="{$base_url_admin}/{$control}/gallery_delete?id={$item.id}&a={$item.album_id}" class="btn btn-sm btn-danger" title="Remove"><i class="fa fa-trash-o"></i></a>
							
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                <div class="separator"></div> 
                <div class="separator"></div>     
                </div><!--.tab-content-->
            </div><!--.widget-body-->
        </div><!--.widget-->
        
    </div><!--.col-md-9-->
    <div class="col-md-3 widget">
        {include file="album/right_gallery.tpl"}
    </div><!--.col-md-3-->
        
</div>
</div><!--.innerLR-->   
</div><!--#content-->
{include file="footer.tpl"}
{include file="script_validator.tpl"}
{include file="modal_small_danger.tpl"}

<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>

<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-confirmation.js"></script>

<script>
	var please_input = "{$lable.please_input}";
	var lable_title = "{$lable.title}";
	
{literal}
$( document ).ready(function() {
	
	!function ($) {	
		$(function(){ $('[data-toggle="confirmation"]').confirmation(); }) 
	}(window.jQuery);
	
	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
	
	$('.avail_gallery').on('click', function(e) {     
        var blog_id = $(this).attr('id');
        var status_id;
		
		if( $(this).is(':checked') ) {
			status_id = 1;
		} else {
			status_id = 0;
		}
		
        $.ajax({
            url: base_url_admin +'/album/gallery_avail/',
            type: 'POST',
            data: "id="+blog_id+"&s="+status_id,
            success: function(data){ 
				if(data == 1) {
                    if(status_id == 1) {
                        $(this).val(1);
                        $(this).attr('checked', 'checked');
                    } else {
                        $(this).val(0);
                        $(this).removeAttr('checked');
                    }
                }
            }
        });
    });
	
});
{/literal}	
</script>
<script src="{$base_tlp_admin}/js/blog.js"></script>