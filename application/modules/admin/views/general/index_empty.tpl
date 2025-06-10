<div class="multi-producttion">
<div class="box-generic">
    <div class="row">
        <input type="hidden" name="production[id][]" value="" class="form-control span8" />
        <input type="hidden" name="production[parent][]" value="{$data.id}" class="form-control span8" />
        <div class="col-md-6">                         
           <div class="form-group">
                <label class="col-md-4 control-label" for="name">{$lable.name} (*)</label>
                <div class="col-md-8">
                    <input class="form-control" name="production[name][]" value="" type="text" maxlength="80" />
                    <span class="help-block">{$valid.name}</span>
                </div>
            </div>
        </div>

        <div class="col-md-5">	
            <div class="form-group">
                <label class="col-md-3 control-label" for="dscr">{$lable.description}</label>
                <div class="col-md-9">
                    <textarea name="production[dscr][]" class="col-md-6 form-control" rows="2"></textarea>
                    <span class="help-block">{$valid.dscr}</span>
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <a data-placement="left" href="javascript:void(0)" class="btn btn-danger bt_remove_production">{$lable.delete}</a>
        </div>
    </div>
</div>
</div>