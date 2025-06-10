<footer class="footer" id="footer">
<div class="footer-top">
<div class="container">
<div class="row">
<div class="col-sm-12 col-lg-3 mb-5 mb-lg-0" itemscope itemtype="https://schema.org/LocalBusiness">
	<h3 class="footer-heading" itemprop="name">{$lable.footer_contact_panpic}</h3>
	<ul class="navbar-nav nav-contact">
		<li class="nav-item" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"><i class="bi bi-geo-alt-fill"></i><span>{$lable.address}: {$lable.footer_address|stripslashes}</span></li>
		<li class="nav-item"><i class="bi bi-telephone-fill"></i><span itemprop="telephone">{$lable.phone}: {$lable.footer_phone}</span></li>
		<li class="nav-item"><i class="bi bi-envelope-fill"></i><span itemprop="email">{$lable.email}: {$lable.footer_email}</span></li>
		<li class="nav-item"><i class="bi bi-globe2"></i><span>Website: {$lable.footer_website}</span></li>
	</ul>
	<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start">
		<div class="fst-italic me-4">{$lable.follow_us}:</div>
		<ul class="nav nav-social mb-2">
			<li class="nav-item"><a class="nav-link" href="{$lable.social_link_facebook}" target="_blank" title="Facebook PANPIC"><i class="bi bi-facebook"></i></a></li>
			<li class="nav-item"><a class="nav-link" href="{$lable.social_link_youtube}" target="_blank" title="Youtube PANPIC"><i class="bi bi-youtube"></i></a></li>
			<li class="nav-item"><a class="nav-link" href="{$lable.social_link_twitter}" target="_blank" title="Twitter PANPIC"><i class="bi bi-twitter"></i></a></li>
		</ul>
	</div>
</div>
<div class="col-6 col-sm-6 col-lg-3 mb-5 mb-lg-0">
	<h3 class="footer-heading">{$lable.menu_services}</h3>
	<ul class="navbar-nav footer-menu">
		{foreach from=$menu_services item=vl}<li class="nav-item"><a class="nav-link" href="{$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}" title="{$vl.cat_name|stripslashes}">{$vl.cat_name|stripslashes}</a></li>{/foreach}
	</ul>
</div>
<div class="col-6 col-sm-6 col-lg-3 mb-5 mb-sm-0">
	<h3 class="footer-heading">{$lable.event}</h3>
	<ul class="navbar-nav footer-menu">
		{foreach from=$menu_tintuc item=mn_news name=k}
			{if not $smarty.foreach.k.last}
				<li class="nav-item"><a class="nav-link" href="{$mn_news.cat_slug|url_news_cat}" title="{$mn_news.cat_name|stripslashes}">{$mn_news.cat_name|stripslashes}</a></li>
			{else}
				<li class="nav-item"><a class="nav-link" href="{'document'|url_menu_page}" title="{$lable.menu_tailieu}">{$lable.menu_tailieu}</a></li>
				<li class="nav-item"><a class="nav-link" href="{$mn_news.cat_slug|url_news_cat}" title="{$mn_news.cat_name|stripslashes}">{$mn_news.cat_name|stripslashes}</a></li>
			{/if}
		{/foreach}
	</ul>
</div>
<div class="col-sm-12 col-lg-3">
	<h3 class="footer-heading">{$lable.footer_subscriber_title}</h3><p class="fs-6">{$lable.subscriber_content}</p>
	<form class="contact-form" id="frm-subscriber" name="frm-subscriber" action="{$base_url}/subscriber">
		<div class="row">
			<div class="col-12"><input class="form-control" type="text" name="subscriber_fullname" id="subscriber_fullname" placeholder="Họ và tên..." required></div>
			<div class="col-12"><input class="form-control" type="text" name="subscriber_email" id="subscriber_email" placeholder="{$lable.placeholder_email_subscriber}..." required></div>
			<div class="col-12"><input class="form-control" type="text" name="subscriber_phone" id="subscriber_phone" placeholder="Điện thoại hoặc Zalo..." required></div>
			<div class="col-12"><button class="btn btn-sm bg-orange text-white btnSubscriber">{$lable.btn_send}</button></div>
		</div>
	</form>
</div>
</div>
</div>
</div>
<div class="footer-bottom">
<div class="container">
<div class="row align-items-center">
<div class="col-12 col-sm-12 col-xl-5"><h3 class="fs-7 mb-0 fw-bold">{$lable.copyright}</h3></div>
<div class="col-12 col-sm-12 col-xl-7 order-xl-1 d-none d-md-block text-right">
<a href="{'cam-ket-chat-luong'|url_slug_page}" class="text-white">Cam kết chất lượng</a> | <a href="{'dieu-khoan-su-dung'|url_slug_page}" class="text-white">Điều khoản sử dụng</a> | <a href="{'chinh-sach-bao-mat'|url_slug_page}" class="text-white">Chính sách bảo mật</a>
<a href="//www.dmca.com/Protection/Status.aspx?ID=d8bfe3e5-89e6-4a48-8abc-77744f3d238e" title="DMCA.com Protection Status" class="dmca-badge" target="_blank"> <img loading="lazy" src ="https://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=d8bfe3e5-89e6-4a48-8abc-77744f3d238e" alt="DMCA.com Protection Status" /></a><script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"></script>
</div>
</div>
</div>
</div>
</footer>
{if $control neq 'services'}
<script src="{$base_tlp_front}/libs/fancybox/jquery.fancybox.min.js"></script>
{/if}
<script src="{$base_tlp_front}/libs/ytb/ytb.min.js"></script>
<script src="{$base_tlp_front}/js/custom.min.js?ver=1.5"></script>
{literal}<script async src="https://www.googletagmanager.com/gtag/js?id=UA-16288383-15"></script><script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date());gtag('config', 'UA-16288383-15');</script>{/literal}
</div>
<div class="widget-action-sticky"><a class="widget-action-link" href="{$lable.social_link_zalo}" title="Zalo Panpic" target="_blank"><i class="sprite sprite-zalo"></i></a><a class="widget-action-link" href="https://m.me/100054436721848" title="Messenger Panpic" target="_blank"><i class="sprite sprite-messager"></i></a></div>
{include file="modal-notification.tpl"}
{if $control neq 'index'}
<script src="https://sp.zalo.me/plugins/sdk.js"></script>
{/if}
{**
{include file="widget/loading.tpl"}
{literal}<script type="text/javascript">(function(d, t){var g = d.createElement(t), s = d.getElementsByTagName(t)[0];g.src = "https://cdn.pushalert.co/integrate_d903b3596fdef2ecd95c1453d6542e69.js";s.parentNode.insertBefore(g, s);}(document, "script"));</script>{/literal}
**}
</body>
</html>