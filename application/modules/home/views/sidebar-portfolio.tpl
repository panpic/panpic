<div class="col-md-4 col-xl-3 col-lg-4 mt-5 mt-lg-0">
    <div class="heading mb-5">
        <a href="{'portfolio'|url_menu_page}">
            <h5 class="heading-title">{$lable.all_portfolio}</h5>
        </a>
    </div>
    <div class="widget widget-menu">
        <h3 class="widget-title">{$lable.to_portfolio_function}</h3>
        <ul class="navbar-nav list-unstyled">
            {foreach from=$menu_duan item=cc}
                <li class="nav-item">
                    <a class="nav-link {if $cc.post_cat_id eq $category.post_cat_id}active{/if}" href="{$cc.cat_slug|url_fe_portfolio_cat}" title="{$cc.cat_name}">
                        <div class="bi bi-chevron-double-right text-dark"></div><span>{$cc.cat_name}</span>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
    <div class="widget widget-menu">
        <h3 class="widget-title">{$lable.by_year}</h3>
        <ul class="navbar-nav list-unstyled">
            {foreach from=$menu_year_portfolio key=$keyYear item=mnYearPortfolio}
                {if $keyYear <= 3}
                    {assign var=yy value=$mnYearPortfolio.portfolio_year|date_format:"%Y"}
                    <li class="nav-item">
                        <a class="nav-link {if $yy eq $year || $yy eq $portfolio.year}active{/if}" href="{$mnYearPortfolio.portfolio_year|date_format:"%Y"|url_fe_portfolio_year}" title="{$mnYearPortfolio.portfolio_year|date_format:"%Y"}">
                            <div class="bi bi-chevron-double-right text-dark"></div><span>{$mnYearPortfolio.portfolio_year|date_format:"%Y"}</span>
                        </a>
                    </li>
                {/if}
                {if $keyYear == 4}
                    {$tempYear = $mnYearPortfolio.portfolio_year|date_format:"%Y"}
                    {assign var=yy value=$tempYear}
                {/if}
                {if $keyYear == $menu_year_portfolio_count}
                    <li class="nav-item">
                        <a class="nav-link {if $yy eq $year|| $yy eq $portfolio.year}active{/if}" href="{$tempYear|url_fe_portfolio_year}" title="{$mnYearPortfolio.portfolio_year|date_format:"%Y"}">
                            <div class="bi bi-chevron-double-right text-dark"></div><span>{$mnYearPortfolio.portfolio_year|date_format:"%Y"} - {$tempYear}</span>
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    </div>
    <div class="widget widget-menu">
        <h3 class="widget-title">{$lable.menu_testimonial_short}</h3>
        <ul class="navbar-nav list-unstyled">
            <li class="nav-item">
                <a class="nav-link {if $action eq 'testimonial' || $action eq 'testimonial_detail'}active{/if}" href="{'testimonial'|url_fe_portfolio_cat}" title="{$lable.mn_testimonial}">{$lable.mn_testimonial}</a>
            </li>
        </ul>
    </div>
</div>