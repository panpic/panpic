{include file="header.tpl"}
{include file="sidebar.tpl"}

<div id="content">

    {include file="sidebar_header.tpl"}    
    {include file="breadcrumb.tpl"}
    <div class="innerLR">
			
		<div class="widget">			
			<div class="widget-head">
				<h4 class="heading">{$heading}</h4>
			</div>				
			
			<div class="widget-body overflow-x">
				{if $alert neq ''} {include file="notes.tpl"} {/if}				
			</div>
		</div>
			 
    </div>    
</div>

{include file="footer.tpl"}
