<div class="col-md-12" style="padding-top:10px; padding-bottom:7px;border-bottom:1px solid">
	<div class="row">
        <label class="col-md-3 control-label" for="home_status">{$lable.lable_portfolio_typical_projects}</label>
        <div class="col-md-9">
        <input type="checkbox" name="data[{$k}][home_status]" id="home_status" class="" value="{$SHOW_HOME}" {if $data.home_status eq $SHOW_HOME} checked="checked"{/if} />
        </div>
    </div>
    <div class="row form-group">
        <label class="col-md-3 control-label">{$lable.portfolio_special}</label>
        <div class="col-md-9">
            <textarea rows="2" name="data[{$k}][portfolio_utility]" id="portfolio_utility" style="width:100%">{$data.portfolio_utility}</textarea>
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
        <label class="col-md-3 control-label" for="portfolio_clients">Clients</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_clients]" id="portfolio_clients" value="{$data.portfolio_clients}" class="form-control" />
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label" for="portfolio_skills">Skills</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_skills]" id="portfolio_skills" value="{$data.portfolio_skills}" class="form-control" />
        </div>
    </div>
</div>
{**
    <div class="row">
        <label class="col-md-3 control-label">{$lable.portfolio_function}</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_ntdul]" id="portfolio_ntdul" value="{$data.portfolio_ntdul}" class="form-control" />
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{$lable.lable_portfolio_investor}</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_dt]" id="portfolio_dt" value="{$data.portfolio_dt|stripslashes}" class="form-control" />
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{$lable.lable_portfolio_design_consultancy}</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_st]" id="portfolio_st" value="{$data.portfolio_st}" class="form-control" />
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{$lable.lable_portfolio_contractor}</label>
        <div class="col-md-9">
            <input name="data[{$k}][portfolio_qm]" id="portfolio_qm" value="{$data.portfolio_qm}" class="form-control" />
        </div>
    </div>

    <div class="row">
        <label class="col-md-3 control-label">{$lable.lable_portfolio_project_scale}</label>
        <div class="col-md-9">
            <textarea rows="2" name="data[{$k}][price]" id="price" class="form-control">{$data.price|stripslashes}</textarea>
        </div>
    </div>
    <div class="row" style="padding-top:10px;border-bottom:1px solid">
        <div class="col-md-12"></div>
    </div>

**}