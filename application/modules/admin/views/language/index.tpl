{include file="header.tpl"}
{include file="sidebar.tpl"}

<!-- Content -->
<div id="content">

    {include file="sidebar_header.tpl"}
    
    {include file="breadcrumb.tpl"}

    <div class="innerLR">
        
        <form class="form-horizontal margin-none" id="frm_data" name="frm_data" method="post" action="{$base_url_admin}/language/add/" autocomplete="off">
	   <input type="hidden" name="option" id="option" value="{$option}" />
		
		
            <!-- Widget -->
            <div class="widget">
                <!-- Widget heading -->
                <div class="widget-head">
                    <h4 class="heading">{$task}</h4>
                </div>
                <!-- // Widget heading END -->
                <div class="widget-body innerAll inner-2x">
                    <!-- Row -->
                    <div class="row innerLR">
                        <!-- Column -->
                        <div class="col-md-8">
							
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
							
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="primary">{$lable.variable}</label>
                                <div class="col-md-8">
                                    <input type="text" name="data[name]" class="form-control" value="{$data.name|stripslashes}" {if $data.name neq ''} readonly="readonly" {/if} style="width:300px;" maxlength="80" />
                                    <p class="help-block"><?php echo form_error('name'); ?></p>
                                </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-4 control-label" for="lang_value">{$lable.value_of_variable}</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="data[value]" rows="3">{$data.value|stripslashes}</textarea>
									
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-8">
                                    <div class="form-actions">
										<button type="submit" id="btLang" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.save}</button>
									</div>									
                                </div>
                            </div>                           
                           
                        </div>
                        <!-- // Column END -->
                    </div>
                    <!-- // Row END -->
                   
                    </div>
                    <div class="separator"></div>                    
                </div>
            </div>
            <!-- // Widget END -->
        </form>
        
    </div>    
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"}