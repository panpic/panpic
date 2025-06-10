<section class="section-paralax" style="background-image: url({$base_tlp_front}/images/background/paralax.png);">
    <div class="container">
        <div class="heading-center justify-content-center">
        <h3 class="text-uppercase text-center mb-7 heading-bb">{$lable.menu_services}</h3>
        </div>
        <div class="row">
            {assign var=service_1 value=$services_menu_home[0]}
            {assign var=service_2 value=$services_menu_home[1]}
            {assign var=service_3 value=$services_menu_home[2]}
            {assign var=service_4 value=$services_menu_home[3]}
            <div class="col-sm-6 col-lg-3 text-center mb-6 mb-lg-0">
                <a class="text-white" href="{$service_1.cat_slug|url_fe_service_detail:$service_1.post_cat_id}">
                    <i class="icon icon-paralax1"></i>
                    <h5 class="mb-0 mt-4 text-uppercase">{$service_1.cat_name|stripslashes}</h5>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 text-center mb-6 mb-lg-0">
                <a class="text-white" href="{$service_2.cat_slug|url_fe_service_detail:$service_2.post_cat_id}">
                    <i class="icon icon-paralax2"></i>
                    <h5 class="mb-0 mt-4 text-uppercase">{$service_2.cat_name|stripslashes}</h5>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 text-center mb-6 mb-sm-0">
                <a class="text-white" href="{$service_3.cat_slug|url_fe_service_detail:$service_3.post_cat_id}">
                    <i class="icon icon-paralax3"></i>
                    <h5 class="mb-0 mt-4 text-uppercase">{$service_3.cat_name|stripslashes}</h5>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 text-center mb-6 mb-sm-0">
                <a class="text-white" href="{$service_4.cat_slug|url_fe_service_detail:$service_4.post_cat_id}">
                    <i class="icon icon-paralax4"></i>
                    <h5 class="mb-0 mt-4 text-uppercase">{$service_4.cat_name|stripslashes}</h5>
                </a>
            </div>
        </div>
    </div>
</section>