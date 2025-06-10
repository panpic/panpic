<input type="hidden" name="data[category_id]" value="" />
<div class="row" style="padding-top:10px;">
	<label class="col-md-5 control-label" for="portfolio_year">{$lable.year} (*)</label>
    <div class="col-md-7">
    <input type="text" name="data[portfolio_year]" id="portfolio_year" class="form-control" value="{$data.portfolio_year}" />
    </div>
    <p class="help-block">{$valid.portfolio_year}</p>
</div>
<div class="row">
    {include file="{$control}/slim_upload.tpl"}
</div>
<div class="col-md-12" style="padding:10px 0px 10px 10px;"> 
    <button type="button" id="btnAddBlog" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.btn_save}</button>
</div>