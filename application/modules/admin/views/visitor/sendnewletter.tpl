<meta charset="utf-8" />


<table>
        <thead>
            <tr>
                <td>STT</td>
                <td style="width:60px;">Visitor Id</td>
                <td>Visitor Name</td>
                <td>Email</td>
                <td>Last Login Day</td>
            </tr>
        </thead>
        
        <tbody class="list_item">        
                {foreach from=$items item=item key=key name=name}
                    {assign var="k" value=$key+1 }
                    <tr class='row_{$item.id}'>
                        <td class="textC">{$k}</td>
                        <td class="textC">VI-{$item.id}</td>
                        <td class="textC">{$item.name}</td>
                        <td class="textC">{$item.email}</td>
                        <td class="textC">{$item.last_update}</td>
                    </tr>
                {/foreach}
        </tbody>
</table>