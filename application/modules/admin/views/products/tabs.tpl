<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#sub21" data-toggle="tab">{$lable.product_detail}</a>
        </li>
        <li><a href="#sub22" data-toggle="tab">{$lable.product_technical}</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="sub21">
            <textarea class="form-control" id="full_content" name="data[{$current_lang}][content]" onChange="hideFieldRequire('#valid_content)">{$data.content|stripslashes}</textarea>
        </div>
        <div class="tab-pane fade" id="sub22">
            <textarea class="form-control" id="full_technical" name="data[{$current_lang}][technical]">{$data.technical|stripslashes}</textarea>
        </div>
    </div>
</div>