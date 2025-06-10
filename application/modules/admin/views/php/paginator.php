{if $paginator}
    <div class="row">
        <div class="col-sm-4">
            <div class="dataTables_info" id="dataTables-lang_info" role="alert" aria-live="polite" aria-relevant="all">
                &nbsp;
            </div>
        </div>
        <div class="col-sm-8">
            <div class="dataTables_paginate paging_simple_numbers" id="dataTables-lang_paginate">
                <ul class="pagination">
                    {if $paginator->current > 1}
                        <li class="paginate_button previous" aria-controls="dataTables-lang" tabindex="0" id="dataTables-lang_previous">
                            <a href="{$pageUrl}{$paginator->first}">{$lable.paging_first.value}</a>
                        </li>
                    {/if}

                    {if $paginator->current ==1} 
                        <li class="paginate_button previous disabled" aria-controls="dataTables-lang" tabindex="0" id="dataTables-lang_previous"><a><< {$lable.paging_prev.value}</a></li>
                        {else} 
                        <li class="paginate_button previous" aria-controls="dataTables-lang" tabindex="0" id="dataTables-lang_previous">
                            <a href="{$pageUrl}{$paginator->previous}"> &laquo; {$lable.paging_prev.value}</a>
                        </li>
                    {/if}
                    {foreach from=$paginator->pagesInRange item=vl}
                        {if $vl == $paginator->current}
                            <li class="paginate_button active" aria-controls="dataTables-lang" tabindex="0"><a>{$vl}</a></li>
                                {else}
                            <li class="paginate_button " aria-controls="dataTables-lang" tabindex="0">
                                <a href="{$pageUrl}{$vl}">{$vl}</a>
                            </li>	
                        {/if}
                    {/foreach}	

                    {if $paginator->current == $paginator->last}
                        <li class="paginate_button next disabled" aria-controls="dataTables-lang" tabindex="0" id="dataTables-lang_next"><a>{$lable.paging_next.value} >></a></li> 
                        {else}
                        <li class="paginate_button next" aria-controls="dataTables-lang" tabindex="0" id="dataTables-lang_next">
                            <a href="{$pageUrl}{$paginator->next}">{$lable.paging_next.value} &raquo;</a>
                        </li>
                    {/if}	
                    <li class="paginate_button next" aria-controls="dataTables-lang" tabindex="0" id="dataTables-lang_next">
                        <a href="{$pageUrl}{$paginator->last}">{$lable.paging_last.value}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}