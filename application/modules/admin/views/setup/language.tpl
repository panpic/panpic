<div class="innerLR">
    <h2 class="margin-none">{$lable.admin_language}</h2>
    <div class="widget widget-heading-simple widget-body-white">					
        <div class="widget-body">
            <form class="form-horizontal" role="form">	
            <div class="row">
            	
                <div class="col-md-2">						
                    <div class="form-group">
                        <label for="language_name" class="col-sm-6 control-label">{$lable.admin_language}</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="language" name="lang">
                                {foreach from=$langArr item=vl}
                                <option {if isset($smarty.get.lang) && $smarty.get.lang eq $vl}selected{/if} value="{$vl}">{$vl}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">						
                    <div class="form-group">
                        <label for="language_name" class="col-sm-2 control-label">{$lable.keyword}</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" 
                            placeholder="{$lable.btn_search}" name="keyword" value="{$keyword}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-default" type="submit" title="{$lable.btn_search}">
                            <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                	<a href="#modal-language" data-toggle="modal" class="btn btn-success mb-15">
                        <i class="fa fa-plus"></i> {$lable.language_add_label}
                    </a>
                </div>
            </div>    
            </form>
        </div>
    </div>
   
    <!-- Table -->
    <div class="widget">
    <div class="widget-head">
        <h4 class="heading">{$lable.language_list_label}</h4>
    </div>
    <div class="widget-body innerAll inner-2x">
        <table class="table table-striped table-responsive swipe-horizontal table-primary variables-list">
           <thead>
                <tr>
                    <th>{$lable.language_name}</th>
                    <th>{$lable.admin_language}</th>
                    <th>{$lable.language_value}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            {foreach from=$list key=k item=v}
                {if $keyword != '' && stristr($v, $keyword) || $keyword != '' && stristr($k, $keyword) || $keyword == ''}
            <tr class="gradeA">
                <td>{$k}</td>
                <td>{$current_lang}</td>
                <td>
                <label class="lab-{$k}__{$current_lang}">{htmlentities($v, ENT_QUOTES, "UTF-8")}</label>
                <input class="form-control" onkeyup="update(this, event);" value="{htmlentities($v, ENT_QUOTES, "UTF-8")}" style="display:none" id="{$k}__{$current_lang}"  name="{$k}{$current_lang}" />
                </td>
                <td style="width:120px;">                           
                <a data-toggle="modal" class="btn btn-sm btn-success lang_values" data-id="{$k}__{$current_lang}" href="javascript:void(0)" title="Edit" style="border-radius:50%; padding:4px 7px;">
                    <i class="fa fa-edit"></i>
                </a>
                </td>
            </tr>
                {/if}
            {/foreach}
        </table>
    </div>
    </div>
    <!-- /Table -->
    
     <!-- Modal -->
    <div class="modal fade" id="modal-language">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal heading -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">{$lable.language_info_label}</h3>
                </div>
                <!-- // Modal heading END -->
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="innerAll">
                        <div class="innerLR">
                            <form name="fAddLang" id="fAddLang" class='form-horizontal' method="post" action="{$base_url_admin}/setup/add" data-namerequired="{$lable.language_name_required}" data-valuerequired="{$lable.language_value_required}">
                                <input type="hidden" name="paramLang" value="{if isset($smarty.get.lang)}{$smarty.get.lang}{/if}">
                                <div class="form-group">
                                    <label for="language_name" class="col-sm-2 control-label">{$lable.admin_language}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="lang" name="lang">
                                            {foreach from=$langArr item=vl}
                                            <option {if isset($smarty.get.lang) && $smarty.get.lang eq $vl}selected{/if} value="{$vl}">{$vl}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>		
                                <div class="form-group">
                                    <label for="language_name" class="col-sm-2 control-label">{$lable.language_name}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="{$lable.language_name}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="language_value" class="col-sm-2 control-label">{$lable.language_value}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="value" name="value" placeholder="{$lable.language_value}">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">{$lable.btn_save}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- // Modal body END -->
            </div>
        </div>
    </div><!-- // Modal END -->
</div>
