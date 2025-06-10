{include file="header.tpl"}
{include file="sidebar.tpl"}
<div id="content">
    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}

    <div class="innerLR">
        <form class="margin-none" id="frm_data" name="frm_data" method="post" action="#">
            <div class="widget">
                <div class="widget-head">
                    <h4 class="heading">{$task}</h4>
                </div>
                
                <div class="widget-body">
                    <div class="row">
                    	<div class="col-md-9">
                            {if $alert neq ''} {include file="notes.tpl"} {/if}
                        </div>
                        <div class="col-md-3">
                        	
                        </div>
                    </div><!-- // Row END -->
                    </div>
                    <div class="separator"></div>                    
                </div>
            </div><!-- // Widget END -->
        </form>
    </div>    
</div>

{include file="footer.tpl"}
{include file="script_validator.tpl"} 
<script>
{literal}
$(document).ready (function(){
	
	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert").slideUp(500);
		}); 
    }, 2000);
	
});
{/literal}
</script>
