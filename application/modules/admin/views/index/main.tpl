
<div class="row">
    <div class="col-md-8">

        <!-- Widget	 -->
        <div class="widget">
            <div class="widget-head innerAll half">
                <h4 class="margin-none"><i class="fa fa-fw icon-star"></i> Trends</h4>
            </div>
            <!-- Widget -->
            <div class="widget-body innerAll inner-2x">
                <table class="table table-striped margin-none">
                    <thead>
                        <tr>
                            <th>Chức năng</th>
                            <th class="text-center">Tổng số mẩu tin</th>
                            <th class="text-right" style="width:150px;">Đang kích hoạt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>1.</strong> {$lable.portfolio}</td>
                            <td class="text-center">{$statistics.servicesTotal}</td>
                            <td class="text-right">{$statistics.servicesActive}</td>
                        </tr>
                        <tr>
                            <td><strong>2.</strong> {$lable.post_knowledge}</td>
                            <td class="text-center">{$statistics.blogTotal}</td>
                            <td class="text-right">{$statistics.blogsActive}</td>
                        </tr>
                        {**
                        <tr>
                            <td><strong>3.</strong> {$lable.recruitment}</td>
                            <td class="text-center">{$statistics.recruitementTotal}</td>
                            <td class="text-right">{$statistics.recruitementActive}</td>
                        </tr>
                        **}
                        <tr>
                            <td><strong>4.</strong> {$lable.download}</td>
                            <td class="text-center">{$statistics.promotionTotal}</td>
                            <td class="text-right">{$statistics.promotionActive}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- // End Widget Body -->
        </div>
        <!-- // End Widget -->

        <!-- Widget -->


        <div class="row">
            <div class="col-sm-3">
                <div class="widget">
                    <a href="{$base_url_admin}/portfolio/items/" class="display-block bg-success innerAll text-center text-white"><i class="fa fa-tasks fa-5x"></i>
                    </a>
                    <div class="text-center innerAll">
                        <a href="{$base_url_admin}/portfolio/items/" class="strong">{$lable.portfolio}</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="widget">
                    <a href="{$base_url_admin}/download/items" class="display-block bg-lightred innerAll text-center text-white"><i class="fa fa-file fa-5x"></i>
                    </a>
                    <div class="text-center innerAll">
                        <a href="{$base_url_admin}/download/items" class="strong">{$lable.download}</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="widget">
                    <a href="{$base_url_admin}/blogs/items/" class="display-block bg-gray border-bottom innerAll text-center"><i class="fa fa-stack-exchange fa-5x"></i>
                    </a>
                    <div class="text-center innerAll">
                        <a href="{$base_url_admin}/blogs/items/" class="strong">{$lable.mn_news}</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            {**
            <div class="col-sm-3">
                <div class="widget">
                    <a href="{$base_url_admin}/recruitment/items/" class="display-block bg-gray border-bottom innerAll text-center"><i class="fa fa-list-ol fa-5x"></i>
                    </a>
                    <div class="text-center innerAll">
                        <a href="{$base_url_admin}/recruitment/items/" class="strong">{$lable.recruitment}</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            **}
        </div>


    </div>
    <!-- //  End Col -->

    <div class="col-md-4">
        <!-- Widget -->
        {**
        <div class="widget">
            <div class="bg-primary text-center innerAll">
                <div class="innerTB">
                    <h4 class="innerTB text-white">Products</h4>
                    <div class="strong text-xlarge text-white">
                        <p class="innerB margin-none text-xlarge text-condensed strong"><i class="fa fa-th-large"></i> {$statistics.productsTotal}</p>
                    </div>
                </div>
            </div>
            <div class="row row-merge">
                <div class="col-md-6">
                    <div class="text-center innerAll">
                        <p class="margin-none">Active</p>
                        <p class="lead check-none strong">{$statistics.productsActive}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center innerAll">
                        <p class="margin-none">Inactive</p>
                        <p class="lead margin-none strong">{$statistics.productsInactive}</p>
                    </div>
                </div>
            </div>
        </div>
        **}
        <!-- //Widget -->    

        <!-- Widget -->
        <div class="widget widget-body-gray">
            <!-- Widget Heading -->
            <div class="widget-head">
                <h4 class="heading glyphicons calendar"><i></i>Calendar</h4>
            </div>
            <!-- // Widget Heading END -->
            <div class="widget-body innerAll inner-2x">
                <div id="datepicker-inline"></div>
            </div>
        </div>
        <!-- // Widget END -->

    </div>
    <!-- //End Col -->
