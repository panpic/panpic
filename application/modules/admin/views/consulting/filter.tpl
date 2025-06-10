<div class="row">
    <div class="col-md-3">
        <input class="form-control" type="text" name="q" value="{$search.q}" placeholder="{$lable.placeholder_search}" />
    </div>
    <div class="col-md-3">
        <label class="col-md-3 text-center vmiddle">{$lable.from}</label>
        <div class="col-md-9">
            <input class="form-control" type="text" id="from" name="from" value="{$search.from}" autocomplete="off">
        </div>	
    </div>
    <div class="col-md-3">
        <label class="col-md-4 text-center vmiddle">{$lable.to}</label>
        <div class="col-md-8">
            <input class="form-control" type="text" id="to" name="to" value="{$search.to}" autocomplete="off">
        </div>	
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search-minus"></i> {$lable.bt_search}</button>
    </div>
    <div class="col-md-4"> 
    </div>
</div>