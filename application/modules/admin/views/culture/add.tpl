{include file="header.tpl"}
{include file="sidebar.tpl"}
<link rel="stylesheet" type="text/css" href="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.css" />
<script src="{$base_url}/ckeditor/ckeditor.js" charset="utf-8"></script>
<script src="{$base_url}/ckfinder/ckfinder.js" charset="utf-8"></script>

<div id="content">
{include file="sidebar_header.tpl"}
{include file="breadcrumb.tpl"}

<div class="innerLR">
    <div class="relativeWrap">
        <form class="margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/add/" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="option" id="option" value="{$option}" />
            <div class="col-md-9 l-r-0">
            	{if $alert neq ''} {include file="notes.tpl"} {/if}
                <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
                    <div class="widget-head">
                        <ul>
                            {foreach from=$page_lang key=k item=l}
                            <li class="{if $k eq $default_lang}active{/if}">
                                <a href="#tab1-{$k}" class="glyphicons circle_plus" data-toggle="tab"><i></i><span><img src="{$base_tlp_admin}/images/flag/{$k}.png" /></span><span>{$l}</span></a>
                            </li>
                            {/foreach}
                        </ul>
                    </div><!-- .widget-tabs-responsive -->
                    <div class="widget-body">
                        <div class="tab-content">
                            {foreach from=$page_lang key=k item=l}
                            <div class="tab-pane {if $k eq $default_lang}active{/if}" id="tab1-{$k}">
                                {include file="blogs/form-post.tpl"}
                            </div>
                            {/foreach}
                        </div><!--.tab-content-->
                    </div>
                </div>
            </div><!--.col-md-9-->
            <div class="col-md-3 widget">
                {include file="{$control}/right.tpl"}
            </div><!--.col-md-3-->
        </form>
    </div><!--.relativeWrap-->
</div>
 
</div><!--#content-->
{include file="footer.tpl"}
{include file="script_validator.tpl"}
{include file="modal_small_danger.tpl"}

<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>
<script>
var please_input = "{$lable.please_input}";
var lable_title = "{$lable.title}";
	
{literal}
$(document).ready (function(){
	
	var editor = CKEDITOR.replace('full_content_vi');
	CKFinder.setupCKEditor(editor, '/ckfinder/');

    var editor_en = CKEDITOR.replace('full_content_en');
    CKFinder.setupCKEditor(editor_en, '/ckfinder/');

	
	$('#date_add').datetimepicker({format:'Y-m-d H:i'});
	$('#portfolio_year').datetimepicker({format:'Y-m-d',timepicker:false});
	
	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
	
	$('#btnAddBlog').click(function (e) {
		
		var flag = 0;
		var errors = '';
		var id_title = $('#id_title').val();
		
		if(id_title == '') {
			flag = 1; errors = please_input+' '+lable_title +'<br />';
		}
		
		if(flag == 1) {
			$('#content-danger').html(errors);
			$('#modal-danger').modal('show');
		} else {
			$('#frm_data').submit();
		}
		
	});
	
	
});
{/literal}
</script>