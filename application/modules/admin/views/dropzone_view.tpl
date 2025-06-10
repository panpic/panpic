{* 
<html>
<head>
<link rel="stylesheet" href="{$base_tlp_admin}/assets/components/common/forms/file_manager/dropzone/assets/lib/css/dropzone.css">


    

</head>
<body>
	<p class="scroll-invitation">
		<a href="#try-it-out"><span></span></a>
	</p>
	<div id="dropzone" multiple >
	<form action="{$base_url_admin}/dropzone/upload/" class="dropzone" id="demo-upload">
			<div class="fallback">
				<input name="file" type="file" multiple />
			</div>
		</form> 
	</div>

<script src="{$base_tlp_admin}/assets/components/common/forms/file_manager/dropzone/assets/lib/js/dropzone.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/file_manager/dropzone/assets/custom/dropzone_user.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
</body>
</html> *}

{* <form method="post" action="{$base_url_admin}/myfile/upload" enctype="multipart/form-data">
    <label>Ảnh kèm theo:</label><input type="file"  id="file" name="file[]" multiple>
    <br />
    <input type="submit" class="button" value="Upload" name='submit' />
</form> *}

<link rel="stylesheet" href="{$base_tlp_admin}/assets/components/common/forms/file_manager/dropzone/assets/lib/css/dropzone.css">

<script>
    
    var object_id   = "25";
    
    
    var control_file_upload = "{$base_url_admin}/myfile/upload/";
    var control_file_delete = "{$base_url_admin}/myfile/delete/";
    var control_file_view = "{$base_url_admin}/myfile/view/?object_id="+object_id+"&object_type=ts";
	
    var base_tpl_user = "{$base_tlp_admin}";
    var user_url = "{$base_url_admin}";
    var max_upload_product_image = 10; 
    
</script>

<div class="col-sm-offset-2">
	{include file="tour/dropzone.tpl"} 

</div>



<script src="{$base_tlp_admin}/assets/components/common/forms/file_manager/dropzone/assets/lib/js/dropzone.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>

<script src="{$base_tlp_admin}/assets/components/common/forms/file_manager/dropzone/assets/custom/dropzone_user.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>

