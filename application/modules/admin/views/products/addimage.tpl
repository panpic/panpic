{include file="header.tpl"}
{include file="sidebar.tpl"}

<div id="content">

    {include file="sidebar_header.tpl"}
    {include file="breadcrumb.tpl"}

	{if $alert neq ''} {include file="notes.tpl"} {/if}
    
    <div class="innerLR">
        
        <form class="form-horizontal margin-none" id="frm_data" name="frm_data" method="post" action="{$action_url}" autocomplete="off" enctype="multipart/form-data">
	      <input type="hidden" name="option" id="option" value="{$option}" />
           <input type="hidden" name="primary" id="primary" value="{$data.image_id}" />
           <input type="hidden" name="old[path_image_pg]" value="{$data.path_image}">
           <input type="hidden" name="old[path_image_thumb_pg]" value="{$data.path_image_thumb}" />
           
            <div class="widget">
                <div class="widget-head">
                    <h4 class="heading">{$data.product_title}</h4>
                </div>
                
                <div class="widget-body inner-2x">
                    <div class="row">
                      <div class="col-md-12">
                      	<div class="row">
                           <div class="col-md-2">{$lable.image}</div>		
                           <div class="col-md-4">         
                           		{include file="products/slim_upload.tpl"}
                           </div>
                           <div class="col-md-2">
                                <div class="form-actions">
                                    <button type="button" id="btSaveImage" class="btn btn-primary"><i class="fa fa-check-circle"></i>  {$lable.save}</button>
                                </div>									
                            </div>
                       </div>    
                     </div>
                     
                    </div><!-- // Row END -->
                   
                    </div>
                    <div class="separator"></div>   
                    
                    {include file="products/items-gallery.tpl"}
                                     
                </div>
            </div><!-- // Widget END -->
        </form>
        
        
    </div>    
</div>

{include file="footer.tpl"}
    
<script src="{$base_tlp_admin}/js/slim.kickstart.min.js"></script>
<script>
var please_input = "{$lable.please_input}";
{literal}
	
	setTimeout(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){ $(".alert").slideUp(500); }); 
    }, 2000);
	
	$('#btSaveImage').on('click', function(e) {
		$('#frm_data').submit();
	});
{/literal}
</script>