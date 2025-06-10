<form method="post" action="{$base_url_admin}/{$control}/process/?s={$blog_id}&id={$data.id}&option={$option}" name="frm_data" id="frm_data">
    <input type="hidden" name="data[vi][blog_id]" value="{$blog_id}" />
    {if $data.path_image neq ''}
        <input type="hidden" name="old[path_image]" value="{$data.path_image}">
        <input type="hidden" name="old[path_image_thumb]" value="{$data.path_image_thumb}">
    {/if}
    <div class="col-md-9">
        <div class="col-md-12 pad-left-0">
            <input class="form-control" id="title_process" type="text" name="data[vi][title_process]" value="{$data.title_process|stripslashes}" placeholder="Tên logo" />
        </div>
        {**
        <div class="col-md-12 pad-left-0" style="padding-top:10px;">
            <textarea class="form-control" id="content_process" name="data[vi][content_process]">{$data.content_process|stripslashes}</textarea>
        </div>
        **}
     </div>
     <div class="col-md-3">
        {include file="portfolio/slim_upload.tpl"}
        <div class="col-md-12">
            <div class="input-group-btn top-10">
                <button id="btn_add_process" class="btn btn-primary" type="button"><i class="fa fa-search-plus"></i> {$lable.btn_save}</button>
            </div>
        </div>
     </div>   
</form>