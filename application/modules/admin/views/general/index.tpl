{include file="header.tpl"}
{include file="sidebar.tpl"}

<div id="content">

    {include file="sidebar_header.tpl"}    
    {include file="breadcrumb.tpl"}
    <div class="innerLR">
        
        <form class="form-horizontal margin-none" id="langForm" name="langForm" method="post" action="{$base_url_admin}/general/add/" autocomplete="off">
            <input type="hidden" name="option" id="option" value="{$option}" />
            <input type="hidden" name="primary" id="primary" value="{$data.id}" />
            <input type="hidden" name="custom_type" value="{$data.type}" />
            <input type="hidden" name="b" value="{$data.type}" />
            
            <div class="widget widget-heading-simple widget-body-white">
                
                <div class="widget-head"><h4 class="heading">{$heading}</h4></div>                
                <div class="widget-body">
                    
                    <div class="row innerLR">
                        {if $alert neq ''} {include file="notes.tpl"} {/if}

                        <div class="box-generic">
                        <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                    <label class="col-md-4 control-label" for="name">{$lable.name} (*)</label>
                                    <div class="col-md-8">
                                        <input class="form-control" name="name" id="name" value="{$data.name|stripslashes|stripslashes}" type="text" maxlength="80" />
                                        <span class="help-block">{$valid.name}</span>
                                    </div>
                                </div>
                            </div>														
                        </div>	
                        </div><!-- /box-generic-->

                        {if $option neq 'edit'}
                            {if $multi|@count gt 0}
                                <div id="update_production">								
                                    {foreach from=$multi item=vl}
                                        {include file="general/index_multi.tpl" record=$vl}								
                                    {/foreach}								
                                </div>																		
                            {else}		
                                <div id="add_production"> &nbsp; </div>
                            {/if}
                        {/if}
						                        
                    </div><!-- // Row END -->
                   
                    </div>                    
                </div>
                                                
                {if $option neq 'edit'}
                <div class="btn-group btn-group-sm pull-left">
                    <button type="button" class="btn btn-primary {if $option eq 'edit'} btn_edit_production{else}btn_add_production{/if}"><i class="fa fa-fw fa-plus-circle"></i> {$lable.add_other}</button>
                </div>
                {/if}
                <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {$lable.btn_save}</button>
                </div>
				
            </div><!-- // Widget END -->
        </form>
        
    </div>    
</div>

<div id="production_empty" style="display:none;">
    {include file="general/index_empty.tpl"}
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"}

<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-confirmation.js"></script>
<script language="javascript">
{literal}	
    !function ($) {	
        $(function(){ 
            $('[data-toggle="confirmation"]').confirmation(); 
        }) 
    }(window.jQuery)	
{/literal}
</script>

<script src="{$base_tlp_admin}/js/general.js"></script>
