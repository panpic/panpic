{if $control eq 'about' || $control eq 'index'}
    {include file="widget/schema_organization.tpl"}
{/if}
{if $control eq 'about'}
    {include file="widget/schema-local-business.tpl"}
{/if}
{if $control eq 'news' && $action eq 'index'}
    {include file="widget/schema_article.tpl"}
    {include file="widget/schema-blog.tpl"}
{/if}
{if $control eq 'contact'}
    {include file="widget/schema_contact.tpl"}
{/if}
