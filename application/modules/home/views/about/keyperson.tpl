{include file="header.tpl"}
{assign var=file value="{$link_upload}/`$banner.banner_file`"}
<main class="main-content" id="main-content">
	{if $banner.banner_file neq ''}
		{assign var=file value="{$link_upload}/`$banner.banner_file`"}
	{else}
		{assign var=file value=$lable.bg_default}
	{/if}
	<section class="page-header" style="background-image: url({$file})">
		<div class="page-header-inner">
			<div class="page-header-inner-content">
				<h1 class="page-title">{$lable.menu_aboutus}</h1>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
			{include file="about/tab.tpl"}
			<article class="single">
				<h1 class="single-title text-uppercase">{$page.page_title}</h1>
				{include file="widget/breadcrumb_about.tpl"}
				<div class="single-content mb-5">
					{$page.page_detail|stripslashes}
				</div>
			</article>
		</div>
	</section>
</main>
{include file="footer.tpl"}
{include file="modal-keystaff.tpl"}
<script type="text/javascript" src="{$base_tlp_front}/plugin/map/jquery.rwdImageMaps.js"></script>
<script type="text/javascript" src="{$base_tlp_front}/js/key_staff.js"></script>