<div class="tab-content">
<table class="table list-items table-bordered table-condensed" id="dataTables-member">
    <thead>
        <tr>
            <th width="5%" class="text-center">ID</th>
            <th>{$lable.image_xe}</th>
            <th>{$lable.portfolio}</th>
            <th>{$lable.date_add}</th>
            <th>{$lable.action}</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$items item=item}
        <tr class="parent-status">
            <td class="text-center">{$item.image_id}</td>
            <td>
                {if $item.path_image neq ''}
                    <img src="{$link_upload}/{$item.path_image}" style="width:110px;height:80px;" />
                {/if}
            </td>
            <td>
                {$item.title|stripslashes}
            </td>
            <td>{$item.g_date_add|date_format:"%d-%m-%Y %H:%M"}</td>
            <td style="text-align:center;line-height:40px;">
                
                <a href="{$base_url_admin}/{$control}/addimage?p={$item.product_id}&id={$item.image_id}&option=edit" class="btn btn-sm btn-success button_margin" title="Update "><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
</div>