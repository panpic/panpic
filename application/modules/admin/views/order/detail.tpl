{include file="header.tpl"}
{include file="sidebar.tpl"}
<link rel="stylesheet" href="{$base_tlp_admin}/css/custom.css" />
<div id="content">
{include file="sidebar_header.tpl"}
{*include file="breadcrumb.tpl"*}
<div class="innerLR">

{if $msg neq ''} {include file="notes.tpl"} {/if}

<div id="pdfTarget">			
<div class="box-generic animated fadeInUp" style="visibility: visible;">
    <table class="table table-invoice">
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <p class="lead">{$lable.order_detail}: #{$data.id}</p>
                    <h2>{$data.order_fullname}</h2>
                    <address class="margin-none">
                        <abbr title="Address">{$lable.address}:</abbr> {$data.order_address}
                        <strong>{$data.district}</strong>
                        <br>
                        <abbr title="Phone">{$lable.order_phone}:</abbr> {$data.order_phone}
                        <br>
                        <abbr title="Phone">{$lable.email}:</abbr> {$data.order_email}
                        <br>
                        <abbr title="Phone">{$lable.date_born}:</abbr> {$data.date_add_born|date_format:"%d-%m-%Y"}
                        <br>
                        <abbr title="Phone">{$lable.order_date}:</abbr> {$data.date_add|date_format:"%d-%m-%Y %H:%M"}
                    </address>
                </td>
                <td class="right">
                    
                </td>
            </tr>
        </tbody>
    </table>
</div>
<table class="table table-bordered table-primary table-striped table-vertical-center">
    <thead>
        <tr>
            <th style="width:1%;" class="center">{$lable.no}</th>
            <th>{$lable.admin_service}</th>
            <th style="width:100px;">{$lable.product_qty}</th>
            <th style="width:120px;">{$lable.price}</th>
            <th style="width:140px;">{$lable.total_price}</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$items name=test item=vl}
        <tr>
            <td class="center">{$smarty.foreach.test.iteration}</td>
            <td>
                <h5>{$vl.title}</h5>
            </td>
            <td class="center">{$vl.qty}</td>
            <td class="center">{$vl.price|convert_vnd}</td>
            <td class="center">
            {math assign=gia_sanpham equation='x*y' x=$vl.qty y=$vl.price}
            {$gia_sanpham|convert_vnd}
            </td>
        </tr>
        {if $smarty.foreach.test.iteration eq 1}
            {assign var=total_gia_sanpham value=0}
        {/if}
        {math assign=total_gia_sanpham equation='x+y' x=$total_gia_sanpham y=$gia_sanpham}
    {/foreach}  
    <tr>
        <td colspan="4" class="text-right"><strong>{$lable.total_price}</strong></td>
        <td>{$total_gia_sanpham|convert_vnd}</td>
    </tr>  
    </tbody>
</table>

</div>    
</div>
{include file="footer.tpl"}