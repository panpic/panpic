{if $paginator}
<div class="pagination">
{if $paginator->current >1}<a href="javascript:void(0)" onclick="page(1, '', '{$urlAjx}');">first</a> &nbsp;{/if}
{if $paginator->current ==1} <span class="disabled"><< prev</span> 
{else} <a href="javascript:void(0)" onclick="page({$paginator->previous}, '', '{$urlAjx}');"><< prev</a>{/if}
{foreach from=$paginator->pagesInRange item=vl}
	{if $vl == $paginator->current} <span class="current">{$vl}</span> &nbsp;
	{else} <a href="javascript:void(0)" onclick="page({$vl}, '', '{$urlAjx}');">{$vl}</a> &nbsp;
	{/if}
{/foreach}
{if $paginator->current == $paginator->last}<span class="disabled">next >></span> 
{else}<a href="javascript:void(0)" onclick="page({$paginator->next}, '', '{$urlAjx}');">next >></a>{/if} &nbsp; 
<a href="javascript:void(0)" onclick="page({$paginator->last}, '', '{$urlAjx}');">last</a>
</div>
{/if}