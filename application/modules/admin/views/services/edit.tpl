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
                <input type="hidden" name="primary" id="primary" value="{$data.blog_id}" />
                <input type="hidden" name="old[path_image]" value="{$data.path_image}">
                <input type="hidden" name="old[path_image_thumb]" value="{$data.path_image_thumb}">
                <input type="hidden" name="old[image_id]" value="{$data.image_id}" />
                <div class="col-md-9 l-r-0">
                    {if $alert neq ''}{include file="notes.tpl"}{/if}
                    <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
                        <div class="widget-head">
                            <ul>
                                {foreach from=$items key=k item=l}
                                <li class="{if $k eq $current_lang}active{/if}">
                                    <a href="#tab1-{$k}" class="glyphicons circle_plus" data-toggle="tab">
                                        <i></i><span><img src="{$base_tlp_admin}/images/flag/{$k}.png" /></span><span>{$page_lang[$k]}</span>
                                    </a>
                                </li>
                                {/foreach}
                            </ul>
                        </div><!-- .widget-tabs-responsive -->
                        <div class="widget-body">
                            <div class="tab-content">
                                {foreach from=$items key=k item=l}
                                <div class="tab-pane {if $k eq $current_lang}active{/if}" id="tab1-{$k}">
                                    {include file="{$control}/form-post.tpl" data=$l}
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

        {**
        <form class="margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/{$control}/add/" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="data[lang]" id="lang" value="{$data.lang}" />
            <div class="widget">
                <div class="widget-head">
                    <h4 class="heading">{$task}</h4>
                </div>
                <div class="widget-body">
                    <div class="row">
                    	<div class="col-md-9">
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
                            {include file="{$control}/form-post.tpl" k=$current_lang}
                        </div>
                        <div class="col-md-3">
                        	{include file="{$control}/right.tpl"}
                        </div>
                    </div><!-- // Row END -->
                    </div>
                    <div class="separator"></div>
                </div>
            </div><!-- // Widget END -->
        </form>**}
    </div>
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"}

<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>
<script>
{literal}
$(document).ready (function(){

	$('#date_add').datetimepicker({format:'Y-m-d H:i'});
	setTimeout(function(){ $(".alert").fadeTo(2000, 500).slideUp(500, function(){ $(".alert").slideUp(500); }); }, 2000);

	$('#btnAddBlog').click(function(e){
		var flag = 0, errors = '', id_title = $('#id_title').val();

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
<script src="{$base_tlp_admin}/js/editor_fields.js?ver=1.0.2"></script>
