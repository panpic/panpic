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
           <input type="hidden" name="old_file" value="{$data.title_2}">
           <input type="hidden" name="old[path_image]" value="{$data.path_image}">
           <input type="hidden" name="old[image_id]" value="{$data.image_id}" />

            <div class="col-md-9 l-r-0">
            	{if $alert neq ''}{include file="notes.tpl"}{/if}
                <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
                    <div class="widget-head">
                        <ul>
                            {foreach from=$items key=k item=l}
                            <li class="{if $k eq $current_lang}active{/if}">
                                <a href="#tab1-{$k}" class="glyphicons circle_plus" data-toggle="tab"><i></i><span><img src="{$base_tlp_admin}/images/flag/{$k}.png" /></span><span>{$page_lang[$k]}</span></a>
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

    </div>    
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"}

<script src="{$base_tlp_admin}/js/slug.js"></script>
<script type="text/javascript" src="{$base_url}/assets/data/jquery/pickertime/jquery.datetimepicker.js"></script>
<script type="text/javascript">
{literal}
$(document).ready (function(){
    $('#date_add').datetimepicker({format:'Y-m-d H:i'});
});
{/literal}
</script>
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script src="{$base_tlp_admin}/js/slug.js"></script>
<script src="{$base_tlp_admin}/js/blog.js"></script>
