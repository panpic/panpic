<section class="content p-t-30">
    <div class="box-header p-l-0 p-r-0">
        <h4 class="box-title text-purple">Add language</h4>
        <div class="group-btn">
            <a class="hoverJS" href="javascript:void(0);" data-toggle="modal" data-target="#modalAddlang" title="Create">
                <img src="{$base_tlp_admin}/img/icon/icon-add.png">
            </a>
        </div>
    </div>
    <div class="box-header p-l-0 p-r-0">
        <form method="get" action="" name="box_search">
            <div class="col-md-4 pad-left-0 p-r-0">
                <input class="form-control" id="appendedInputButtons" type="text" name="keyword" value="{$keyword}" placeholder="Tìm kiếm ..." />
            </div>
            <div class="col-md-2 pad-left-0 p-r-0">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><strong>{$lable.search}</strong></button>
                </div>
            </div>
        </form>
        <div class="separator"></div>
    </div>
    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-custom text-center variables-list">
            <tr class="text-purple text-bold f-16">
                <th style="min-width: 100px; width: 100px;">Name</th>
                <th style="min-width: 150px; width: 150px;">Lang</th>
                <th>Value</th>
                <th>&nbsp;</th>
            </tr>
            {foreach from=$list key=k item=v}
            <tr>
                <td >{$v->name}</td>
                <td>{$v->lang}</td>
                <td>
                <label class="lab-{$v->name}__{$v->lang}">{$v->value}</label>
                <input class="form-control" onkeyup="update(this, event);" value="{$v->value}" style="display:none" id="{$v->name}__{$v->lang}"  name="{$v->name}__{$v->lang}" />
                </td>
                <td style="width:120px;">
               <!-- <a class="hoverJS" href="javascript:void(0);" title="Delete">
                    <img src="{$base_tlp_admin}/img/icon/icon-delete.png">
                </a>-->
                <a class="btn btn-sm btn-success lang_values" data-id="{$v->name}__{$v->lang}" href="javascript:void(0);" title="Edit" style="border-radius:50%; padding:4px7px;">
                    <i class="fa fa-edit"></i>
                </a>
                </td>
            </tr>
            {/foreach}
        </table>
    </div>
    {$links}
    <!-- /Table -->
    
    <!-- modal-Addlang -->
    <div class="modal modal-purple fade" id="modalAddlang">
        <div class="modal-dialog modal-purple">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Add language</h4>
                    <button type="button" class="close">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body-content">
                        <form name="fAddLang" id="fAddLang" class='form-horizontal' method="post" action="{$base_url_admin}/setup/add">
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                Name
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input id="name" name="name" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                Language
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-9">
                                    <select id="lang" name="lang" class="form-control" style="padding-top:1px;" >
                                        <option value="vi">Vietnam</option>
                                    </select>                        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                Value
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-9">
                                    <input id="value" name="value" class="form-control" />
                                </div>
                            </div>
                            
                            <hr class="row clearfix m-lr-25"></hr>
                            <div class="row">
                                <div class="col-xs-6">
                                </div>
                                <div class="col-xs-6">
                                    <button type="submit" class="btn bg-danger btn-custom btn-block">Thêm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal-addlang -->
</section>
