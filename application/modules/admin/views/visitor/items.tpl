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
                <h4 class="heading">{$task}</h4>
            </div>
            <div class="widget-body innerAll inner-2x">
                <br />
                <div class="box-search">
                    <form method="get" action="" name="box_search">
                        <div class="col-md-4 pad-left-0">
                            <input class="form-control" id="appendedInputButtons" type="text" name="keyword" value="{$search.value}" placeholder="Enter agency name / ID" />
                        </div>
                        <div class="col-md-2 pad-left-0"><div class="input-group-btn"><button class="btn btn-default" type="submit"><strong>Tìm</strong></button></div></div>
                    </form>
                    <div class="separator"></div>
                </div>
                <br />
        
                <form method="post" action="{$base_url_admin}/visitor/deletemulti/" name="memberForm" id="visitor">
                    <table class="table list-items table-bordered table-condensed" id="dataTables-member">
                        <thead>
                            <tr>
                                <th width="5%">&nbsp;</th>
                                <th width="5%">Visitor ID</th>
                                <th >Visitor Name</th>
                                <th>Email</th>
                                <th>Last Login Day</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                        {foreach from=$items  item=item}
                            <tr class="parent-status">
                                <td>
                                  <input name="checkAll[]" value="{$item.id}" type="checkbox" />
                                </td>
                                <td>VI-{$item.id}</td>
                                <td>{$item.name}</td>   
                                <td>{$item.email}</td>
                                <td>{$item.last_update|date_format:"%d-%m-%Y"}</td>
                                <td style="text-align: center"><button onclick="return confirm('Bạn có chắc là muốn xóa không?')" data-placement="right" type="submit" class="ask btn btn-primary">Xóa</button></td>
                            </tr>
                        {/foreach}
                          
                            <tr>
                                <td>
                                        <input name="checkAll[]" id="checkAll" value="1" type="checkbox" />
                                </td>
                                <td colspan="7">
                                        <button onclick="return confirm('Bạn có chắc là muốn xóa không?')" data-placement="right" type="submit" class="ask btn btn-primary" name="deleteMulti" id="deleteMulti">Xóa</button>
                                        <button  data-placement="right" type="button" id="send_letter_visitor" class="ask btn btn-default">Send new letter</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
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

<script src="{$base_tlp_admin}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{$base_tlp_admin}/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<script src="{$base_tlp_admin}/js/duy.js"></script>

<script language="javascript">
{literal}
$(document).ready(function() { 
    $('#dataTables-lang').dataTable(); 
});
{/literal}
</script>
