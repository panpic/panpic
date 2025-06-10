{assign var=records value=$items[$key]}
<a name="{$key}"></a>
<div class="widget">	
    <div class="widget-head" style="background-color:#3695d5;">
            <h4 class="heading my-white">{$nameset}</h4>
    </div>
    <div class="widget-body overflow-x">
        <table class="dynamicTable fixedHeaderColReorder table">
            <thead class="bg-gray">
                <tr>
                    <th>{$lable.name}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$records item=vl}
                {assign var=set value=$vl.record}
                <tr class="gradeX">
                        <td>{$set.name|stripslashes}</td>
                        <td>
                        <div class="form-actions pull-right">
                        <a href="{$base_url_admin}/general/index/?id={$set.id}&option=edit" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                        <!--
                        <a data-toggle="confirmation" data-placement="left" href="javascript:void(0)" data-href="{$base_url_admin}/general/del/?id={$set.id}&option=list" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                        -->

                        </div>
                        </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        <div class="add-multi"> &nbsp; </div>

        <div class="form-actions pull-right">
            <div class="separator"></div>
            <button type="button" class="btn btn-primary btn_add_general" name="{$key}"><i class="fa fa-fw fa-plus-circle"></i> {$lable.add}</button>			
        </div>

    </div>
</div>