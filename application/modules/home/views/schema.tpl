{if $control eq 'about' || $control eq 'index'}
    {include file="widget/schema_organization.tpl"}
{/if}
{if $control eq 'about'}
    {include file="widget/schema-local-business.tpl"}
{/if}
{if $control eq 'news' && $action eq 'index'}
    {if $news.admin_id eq 2}
        {include file="widget/schema_personal.tpl"}
    {else}
        {include file="widget/schema_article.tpl"}
    {/if}
    {include file="widget/schema-blog.tpl"}
{/if}
{if $control eq 'contact'}
    {include file="widget/schema_contact.tpl"}
{/if}
