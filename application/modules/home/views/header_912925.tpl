<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" prefix="og: https://ogp.me/ns#" lang="vi">
<head>
{if $seo.seo_title eq ''}{assign var=seo_title value=$lable.seo_title_home|stripslashes}{assign var=seo_description value=$lable.seo_description_home|stripslashes}{else}{assign var=seo_title value=$seo.seo_title|stripslashes}{assign var=seo_description value=$seo.seo_description|stripslashes}{/if}
	<title>{$seo_title}</title>
	<link rel="canonical" href="{$current_url}" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="{$seo_description}" />
	<meta name="copyright" content="{$lable.copyright}" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=5">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes" />
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="fb:app_id" content="493481457478693" />
	<link rel="icon" type="image/x-icon" href="{$base_url}/favicon.ico" />
	<meta name='dmca-site-verification' content='b2pvSmE2SlgwdXVpODBlNkNWdjJqdz090' />
	<meta name="google-site-verification" content="oQESPNhkIzG25Z4HQGL6CgK8W3-2G0AWtuOfvrH48zE" />
	{if $seo.seo_image neq ''}{assign var=img_seo value=$seo.seo_image}{else}{assign var=img_seo value="`$lable.avatar_default`"}{/if}
	<meta property="og:url" content="{$current_url}"/>
	<meta property="og:type" content="article"/>
	<meta property="og:title" content="{$seo_title}"/>
	<meta property="og:description" content="{$seo_description}"/>
	<meta property="og:image" content="{$img_seo}"/>
	<meta property="og:image:alt" content="{$seo_title}" />
	{include file="schema.tpl"}
	{if $control neq 'services' && $control neq 'index'}
	<link rel="stylesheet" href="{$base_tlp_front}/libs/fancybox/jquery.fancybox.min.css">
	{/if}
	<link rel="stylesheet" href="{$base_tlp_front}/css/main.min.css?ver=7.1">
	<link rel="stylesheet" href="{$base_tlp_front}/css/custom.min.css?ver=7.8">
	<script type="text/javascript" src="{$base_tlp_front}/js/bundle.min.js"></script>
	<script type="text/javascript" src="{$base_tlp_front}/js/main.min.js"></script>
	<script type="text/javascript">let base_url="{$base_url}",current_lang="{$current_lang}",base_tlp_front="{$base_tlp_front}";please_input="{$lable.please_input}",title_alert="{$lable.modal_title_alert}",send_success="{$lable.send_success}";</script>{$header_script}
{literal}
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-6XRPFHJTXC"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-6XRPFHJTXC');
	</script>
	{**
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-EL6BYLTZWJ"></script>
	<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-EL6BYLTZWJ');</script>
	<script> (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'}); var f=d.getElementsByTagName(s)[0], j=d.createElement(s), dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-K5RWM936'); </script>
	**}
{/literal}
</head>
<body class="hidden">
{**
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K5RWM936" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
**}
<div class="wrapper">
{include file="widget/main-menu.tpl"}