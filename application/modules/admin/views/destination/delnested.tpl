{include file="header.tpl"}
{include file="sidebar.tpl"}

<link rel="stylesheet" href="{$base_tlp_admin}/css/custom.css" />
<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}

    <div class="innerLR">
        <div class="widget">
            <!-- Widget heading -->
            <div class="widget-head">
                <h4 class="heading">{$task}</h4>
            </div>

            <div class="widget-body innerAll inner-2x">
                <div class="row innerLR">
                    <div class="col-md-6">
                        {if $msg neq ''} {include file="notes.tpl"} {/if} 
                    </div>
                </div>
            </div>
            <div class="separator"></div>                    
        </div>
    </div>

</div>
{include file="footer.tpl"}