<div>
    <label class="control-label" for="id_title_{$k}">{$lable.title}</label>
    <input type="text" name="data[{$k}][title]" id="id_title_{$k}" class="form-control" value="{$data.title|stripslashes}" />
    <p class="help-block">{$valid.title}</p>
</div>
<div> 
    <label class="control-label" for="short_{$k}">{$lable.short_description}</label>
    <textarea class="form-control" id="short_{$k}" name="data[{$k}][short]">{$data.short|stripslashes}</textarea>
 </div>
<div>
    <label class="control-label" for="short_{$k}">{$lable.content}</label>
    <textarea class="form-control" id="short_{$k}" name="data[{$k}][short]">{$data.content|stripslashes}</textarea>
</div>
 <div>  
    <label class="control-label" for="link_click_{$k}">Link click</label>
    <input type="text" name="data[{$k}][link_click]" id="link_click_{$k}" class="form-control" value="{$data.link_click|stripslashes}" />
</div>