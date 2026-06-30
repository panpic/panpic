{include file="header.tpl"}
<main class="main-content ai_hub" id="main-content">
<link rel="stylesheet" href="{$base_tlp_front}/css/ai_hub.css?ver=1.0">
    <section class="section">
        <div class="container">
            {include file="widget/breadcrumb_services.tpl"}
            {include file="services/breadcrumb/{$action}.tpl"}
        </div>
    </section>

    {include file="services/ai_hub/section_1.tpl"}
    {include file="services/ai_hub/section_2.tpl"}
    {include file="services/ai_hub/section_3.tpl"}
    {include file="services/ai_hub/section_4.tpl"}
    {include file="services/ai_hub/section_5.tpl"}
    {**include file="services/ai_hub/section_6.tpl"**}
    {include file="services/ai_hub/section_7.tpl"}
    {include file="services/ai_hub/section_8.tpl"}

</main>
{include file="services/rating.tpl"}
{include file="services/schema_faq.tpl"}
{include file="footer.tpl"}

<script src="{$base_tlp_front}/js/ai_hub.js?ver=1.0"></script>
