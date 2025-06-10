<div class="multi-general">
<div class="row">
    <form class="form-horizontal margin-none" name="appForm" method="post" action="{$base_url_admin}/general/add/">
    <input type="hidden" name="option" value="add" />
    <input type="hidden" name="primary" value="" />
    <input type="hidden" name="custom_type" id="custom_type" value="" />	
    <div class="col-md-11">                         
       <div class="form-group">
            <label class="col-md-2 control-label" for="name">{$lable.name}</label> 
            <div class="col-md-10">
                    <input class="form-control" name="name" value="" type="text" maxlength="80" />
                    <span class="help-block">{$valid.name}</span>
            </div>
        </div>
    </div>

    <div class="col-md-1">
            <div class="form-actions pull-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> {$lable.btn_save}</button>
            </div>
    </div>
    </form>
</div>
</div>