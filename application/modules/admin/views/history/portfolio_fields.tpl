<div class="col-md-12" style="padding-top:10px; padding-bottom:7px;border-bottom:1px solid">
    <div class="row form-group">
        <label class="col-md-3 control-label">{$lable.portfolio_special}</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_utility]" id="portfolio_utility" value="{$data.portfolio_utility}" class="form-control" placeholder="{$lable.placeholder_portfolio_utility}" />
        </div>
    </div>
</div>

<div class="col-md-12" style="padding-top: 10px;">
	<div class="row" style="padding-top:10px;border-bottom:1px solid">
        <div class="col-md-12">
            <h3>{$lable.lable_portfolio_architecture}</h3>
        </div>
    </div>
    <div class="row form-group" style="padding-top:7px;">
        <label class="col-md-3 control-label">{$lable.lable_portfolio_address}</label>
        <div class="col-md-9">
            <input name="data[{$k}][title_2]" id="title_2" value="{$data.title_2}" class="form-control" />
        </div>
    </div>

    <div class="row">
        <label class="col-md-3 control-label">{$lable.lable_portfolio__investor}</label>
        <div class="col-md-9">
            <input name="data[{$k}][content_2]" id="content_2" value="{$data.content_2|stripslashes}" class="form-control" />
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{$lable.lable_portfolio_project_scale}</label>
        <div class="col-md-9">
            <input name="data[{$k}][price]" id="price" value="{$data.price}" class="form-control" />
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{$lable.portfolio_package}</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_ntc]" id="portfolio_ntc" value="{$data.portfolio_ntc}" class="form-control" />
        </div>
    </div>
	
    {**
    <div class="row form-group">
        <div class="col-md-3 control-label">
        	<input name="data[{$k}][portfolio_json][portfolio_1]" value="{$portfolio_json.portfolio_1}" class="form-control" placeholder="Tên 1" />
        </div>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_json][portfolio_1_value]" value="{$portfolio_json.portfolio_1_value}" class="form-control" placeholder="Giá trị 1" />
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-3 control-label">
        	<input name="data[{$k}][portfolio_json][portfolio_2]" value="{$portfolio_json.portfolio_2}" class="form-control" placeholder="Tên 2" />
        </div>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_json][portfolio_2_value]" value="{$portfolio_json.portfolio_2_value}" class="form-control" placeholder="Giá trị 2" />
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-3 control-label">
        	<input name="data[{$k}][portfolio_json][portfolio_3]" value="{$portfolio_json.portfolio_3}" class="form-control" placeholder="Tên 3" />
        </div>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_json][portfolio_3_value]" value="{$portfolio_json.portfolio_3_value}" class="form-control" placeholder="Giá trị 3" />
        </div>
    </div>
    **}
    <div class="row" style="padding-top:10px;border-bottom:1px solid">
        <div class="col-md-12"></div>
    </div>
</div>