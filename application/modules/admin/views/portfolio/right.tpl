<div style="padding-top:10px;">
	<label class="control-label" for="category_id">{$lable.category} <span class="red">(*)</span></label>
    <select name="data[category_id]" id="category_id" class="form-control">
        {$categories.cmb}
    </select>
    <p class="help-block">{$valid.category_id}</p>
</div>
{**
<div style="padding-top:10px;">
	<label class="control-label" for="portfolio_category_id">{$lable.by_zone} <span class="red">(*)</span></label>
    <select name="data[portfolio_category_id]" id="portfolio_category_id" class="form-control">
        {$category_pos.cmb}
    </select>
    <p class="help-block">{$valid.portfolio_category_id}</p>
</div>
**}
<div class="row" style="padding-top:10px;">
	<label class="col-md-5 control-label" for="portfolio_year">{$lable.year_portfolio} <span class="red">(*)</span></label>
    <div class="col-md-7">
    <input type="text" name="data[portfolio_year]" id="portfolio_year" class="form-control" value="{$data.portfolio_year}" />
    </div>
    <p class="help-block">{$valid.portfolio_year}</p>
</div>
{**
<div class="row" style="padding-top:10px;">
	<label class="col-md-5 control-label" for="portfolio_year">{$lable.portfolio_status} (*)</label>
    <div class="col-md-7">
    	<div>
        	<label class="col-md-9 control-label l-r-0" for="portfolio_status_0">{$lable.portofolio_progressing}</label>
        	<input type="radio" name="data[portfolio_status]" id="portfolio_status_0" value="0" {if $data.portfolio_status neq '' && $data.portfolio_status eq 0} checked="checked"{/if} />
        </div>
        <div>
        	<label class="col-md-9 control-label l-r-0" for="portfolio_status_1">{$lable.portofolio_complete}</label>
        	<input type="radio" name="data[portfolio_status]" id="portfolio_status_1" value="1" {if $data.portfolio_status neq '' && $data.portfolio_status eq 1} checked="checked"{/if} />
        </div>
    </div>
    <p class="help-block">{$valid.portfolio_year}</p>
</div>
**}

<div class="row">
    <label class="col-md-5 control-label" for="date_add">{$lable.date_add}</label>
    <div class="col-md-7">
    <input type="text" name="data[date_add]" id="date_add" class="form-control" value="{$data.date_add}" />
    </div>
</div>
{**
<div>
    <label class="col-md-6 control-label" for="admin_verify">{$lable.admin_verify}</label>
    <div class="col-md-6">
    <input type="checkbox" name="data[admin_verify]" id="admin_verify" class="form-control" value="{$ADMIN_BLOG_VERIFY}" {if $data.admin_verify eq $ADMIN_BLOG_VERIFY} checked="checked"{/if} />
    </div>
</div>**}

<div class="row">         
    {include file="portfolio/slim_upload.tpl"}
</div>
{**
<div style="padding-top:10px;">
    <label class="control-label" for="portfolio_services_id">{$lable.menu_services}</label>
    <select name="data[portfolio_services_id]" id="portfolio_services_id" class="form-control">
        {$category_services.cmb}
    </select>
    <p class="help-block">{$valid.portfolio_services_id}</p>
</div>
**}
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBlog" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>