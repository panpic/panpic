{include file="header.tpl"}
<main class="main-content" id="main-content">
	<link rel="stylesheet" id="dflip-icons-style-css" href="{$base_tlp_front}/plugin/assets/css/themify-icons.css?ver=1.0.2" type="text/css" media="all" />
	<link rel="stylesheet" id="dflip-style-css" href="{$base_tlp_front}/plugin/assets/css/dflip.css?ver=1.0.2' type='text/css" media="all" />
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<ul class="nav nav-tabs mb-5" role="tablist">
				{foreach from=$menu_document item=cc}
					<li class="nav-item" role="presentation">
						<a class="nav-link {if $cc.post_cat_id eq $category.post_cat_id}active{/if}" href="{$cc.cat_slug|url_document_cat}">{$cc.cat_name}</a>
					</li>
				{/foreach}
			</ul>
			{include file="breadcrumb.tpl"}
			<div class="row mt-4">
				<div class="col-sm-12 col-md-12">
					<div>
						<h1 class="heading-title single-title">{$document.title|stripslashes}</h1>
					</div>
				</div>
				<div class="_df_book df-container df-loading" id="df_5904" wpoptions=true></div>
			</div>
		</div>
	</section>
</main>
{include file="footer.tpl"}
<script data-cfasync="false">
	var option_df_5904 = {
		"outline": [],
		"backgroundColor": "rgba(255, 255, 255, 0)",
		"height": "750",
		"hard": "cover",
		"forceFit": "true",
		"autoEnableOutline": "false",
		"autoEnableThumbnail": "false",
		"overwritePDFOutline": "false",
		"enableDownload": "false",
		"direction": "1",
		"pageMode": "0",
		"maxTextureSize": "1400",
		"source": "{$link_upload}/{$document.title_2}",
		"wpOptions": "true"
	};
</script>
<script type='text/javascript' data-cfasync="false" src='{$base_tlp_front}/plugin/assets/js/dflip.min.js?ver=1.2.7'></script>
<script data-cfasync="false">
	var dFlipLocation = base_tlp_front+"/plugin/assets/";
	var dFlipWPGlobal = {
		"text": {
			"toggleSound": "Turn on\/off Sound",
			"toggleThumbnails": "Toggle Thumbnails",
			"toggleOutline": "Toggle Outline\/Bookmark",
			"previousPage": "Previous Page",
			"nextPage": "Next Page",
			"toggleFullscreen": "Toggle Fullscreen",
			"zoomIn": "Zoom In",
			"zoomOut": "Zoom Out",
			"toggleHelp": "Toggle Help",
			"singlePageMode": "Single Page Mode",
			"doublePageMode": "Double Page Mode",
			"downloadPDFFile": "Download PDF File",
			"gotoFirstPage": "Goto First Page",
			"gotoLastPage": "Goto Last Page",
			"share": "Share"
		},
		"mainControls": "altPrev,pageNumber,altNext,outline,thumbnail,zoomIn,zoomOut,fullScreen,share,more",
		"hideControls": "",
		"scrollWheel": "false",
		"backgroundColor": "#777",
		"backgroundImage": "",
		"height": "100%",
		"duration": "800",
		"soundEnable": "true",
		"enableDownload": "false",
		"webgl": "false",
		"hard": "cover",
		"maxTextureSize": "1600",
		"zoomRatio": "1.2",
		"singlePageMode": "0"
	};
</script>