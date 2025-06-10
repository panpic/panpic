{include file="header.tpl"}
<main class="main-content" id="main-content">
    <div class="container">
        {include file="breadcrumb.tpl"}
        <section class="page-content">
            <div class="row">
                <div class="col-lg-8 order-lg-1">
                    <article class="single mb-5">
                        <h1 class="single-title">{$page.page_title}</h1>
                        <p class="single-exerpt">{$page.page_short}</p>
                        <div class="single-content text-justify">
                            {$page.page_detail}
                        </div>
                    </article>
                </div>
                {include file="sidebar-careers.tpl"}
            </div>
        </section>
    </div>
</main>
{include file="footer.tpl"}
