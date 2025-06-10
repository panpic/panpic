{include file="header.tpl"}
<main class="main-content" id="main-content">
    <section class="section">
        <div class="container">
            {include file="widget/breadcrumb_about.tpl"}
            <div class="row">
                <div class="col-xl-9 col-lg-8 order-lg-1">
                    <article class="single">
                        <h1 class="single-title text-uppercase">{$service.title|stripslashes}</h1>
                        <div class="row">
                            <div class="col-12 col-md-4 ms-auto">
                                <ul class="social-share d-flex m-0">
                                    <li class="me-2 category mt-1">Share</li>
                                    <li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ dịch vụ lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ dịch vụ lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ dịch vụ lên linkedin" target="_blank"><i class="fa bi-linkedin"></i></a></li>
                                    <li><div class="zalo-share-button" data-oaid="1069300263628412773" data-layout="2" data-color="blue" data-customize="false"></div></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single-content mb-5">{$service.content|stripslashes}</div>
                    </article>
                </div>
                {**if $isMobile eq ''}
                    {include file="sidebar-service.tpl"}
                {/if**}
            </div>
        </div>
    </section>
</main>
{include file="footer.tpl"}