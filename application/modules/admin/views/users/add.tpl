{include file="header.tpl"}
{include file="sidebar.tpl"}

<!-- Content -->
<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}
    <div class="innerLR">

        {if $alert neq ''} {include file="notes.tpl"} {/if}
        <link href="{$base_tlp_admin}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <div class="widget">
            <div class="widget-head">
                <h4 class="heading">{$lable.add}</h4>
            </div>
            <div class="widget-body innerAll inner-2x">
            
                <form class="form-horizontal margin-none" name="frm_data" id="frmAdminUser" method="post" action="{$action_url}" enctype="multipart/form-data">
                    <input type="hidden" value="{$data.adminId}" name="data[adminId]" />

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">* </span> {$lable.username}</label>
                        <div class="col-sm-4">
                            <input type="text" name="data[adminLogin]" id="adminLogin" value="{$data.adminLogin}" class="form-control"/>
                            <span id="valid_adminLogin" class="red"></span>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">* </span> {$lable.password}</label>
                        <div class="col-sm-4">
                            <input type="password" name="data[adminPass]" id="adminPass" value="" class="form-control"/>
                            <span id="valid_adminPass" class="red"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">* </span> {$lable.confirm_password}</label>
                        <div class="col-sm-4">
                            <input type="password" name="" id="re-adminPass" value="" class="form-control"/>
                            <span id="valid_re-adminPass" class="red"></span>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">* </span> {$lable.fullname}</label>
                        <div class="col-sm-4">
                            <input type="text" name="data[adminName]" id="adminName" value="{$data.adminName}" class="form-control"/>
                            <span id="valid_adminName" class="red"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">* </span>Vai trò</label>
                        <div class="col-sm-4">
                            <input type="radio" name="mod" value="MOD" {if $data.adminRole eq 'MOD'} checked {/if}  />&nbsp;MOD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="mod" value="ADMINISTRATOR" {if $data.adminRole eq 'ADMINISTRATOR'} checked {/if} />&nbsp;ADMINISTRATOR
                            <span id="valid_adminName" class="red"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span class="red">* </span>Chức năng</label>
                        <div class="col-sm-10">
                        {foreach from=$arr_permision item=item key=key}
                            {assign var=k_exist  value=$key|array_key_exist:$data.adminPermission}
                            <input type="checkbox" name="permission[]" value="{$key}" {if $k_exist} checked="checked" {/if} />&nbsp;{$item.name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {/foreach}
                            
                            <span id="valid_adminName" class="red"></span>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-xs-2"> &nbsp; </div>
                        <div class="col-xs-2">
                            <button type="button" id="btnSaveAminUser" class="btn btn-primary"> {$lable.btn_save} </button>
                        </div>
                    </div>
                </form>




            </div><!-- /.widget-body -->
        </div><!-- /.widget -->

        

    </div>    
</div>

{include file="footer.tpl"}

<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap-confirmation.js"></script>

<script language="javascript">
    var requireMsg = "{$lable.requireMsg}";
    {literal}
        $(document).ready(function () {
            !function (cash) {
                $(function () {
                    $('[data-toggle="confirmation"]').confirmation();
                });
            }(window.jQuery)
        });
    {/literal}
</script>
<script language="javascript">
    var id = "{$id}";
    // alert(id);
    
</script>