<footer class="footer" id="footer">
<div class="footer-top">
<div class="container">
<div class="row">
<div class="col-sm-12 col-lg-3 mb-5 mb-lg-0">
	<div class="footer-heading">{$lable.footer_contact_panpic}</div>
	<ul class="navbar-nav nav-contact">
		<li class="nav-item"><i class="bi bi-geo-alt-fill"></i><span>{$lable.address}: {$lable.footer_address|stripslashes}</span></li>
		<li class="nav-item"><i class="bi bi-telephone-fill"></i><span>{$lable.phone}: {$lable.footer_phone}</span></li>
		<li class="nav-item"><i class="bi bi-envelope-fill"></i><span>{$lable.email}: {$lable.footer_email}</span></li>
		<li class="nav-item"><i class="bi bi-globe2"></i><span>Website: {$lable.footer_website}</span></li>
	</ul>
	<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start">
		<div class="fst-italic me-4">{$lable.follow_us}:</div>
		<ul class="nav nav-social mb-2">
			<li class="nav-item"><a class="nav-link" href="{$lable.social_link_facebook}" target="_blank" title="Facebook Panpic"><i class="bi bi-facebook"></i></a></li>
			<li class="nav-item"><a class="nav-link" href="{$lable.social_link_youtube}" target="_blank" title="Youtube Panpic"><i class="bi bi-youtube"></i></a></li>
			<li class="nav-item"><a class="nav-link" href="{$lable.social_link_twitter}" target="_blank" title="Twitter Panpic"><i class="bi bi-twitter"></i></a></li>
		</ul>
	</div>
</div>
<div class="col-6 col-sm-6 col-lg-3 mb-5 mb-lg-0">
	<div class="footer-heading">{$lable.menu_services}</div>
	<ul class="navbar-nav footer-menu">
		{foreach from=$menu_services item=vl}<li class="nav-item"><a class="nav-link" href="{$vl.cat_slug|url_fe_service_detail:$vl.post_cat_id}" title="{$vl.cat_name|stripslashes}">{$vl.cat_name|stripslashes}</a></li>{/foreach}
	</ul>
</div>
<div class="col-6 col-sm-6 col-lg-3 mb-5 mb-sm-0">
<div class="footer-heading">{$lable.event}</div>
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
<div class="footer-heading">{$lable.footer_subscriber_title}</div><p class="fs-6">{$lable.subscriber_content}</p>
	<form class="contact-form" id="frm-sub" name="frm-sub" action="{$base_url}/subscriber">
		<div class="row">
			<div class="col-12"><input class="form-control" type="text" name="sub_fn" id="sub_fn" placeholder="Họ tên..." required></div>
			<div class="col-12"><input class="form-control" type="text" name="sub_e" id="sub_e" placeholder="{$lable.placeholder_email_subscriber}..." required></div>
			<div class="col-12"><input class="form-control" type="text" name="sub_p" id="sub_p" placeholder="Điện thoại hoặc Zalo..." required></div>
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
<div class="col-12 col-sm-12 col-xl-5"><p class="fs-7 mb-0 fw-bold">{$lable.copyright}</p></div>
<div class="col-12 col-sm-12 col-xl-7 order-xl-1 d-none d-md-block text-right">
<a href="{'cam-ket-chat-luong'|url_slug_page}" class="text-white">Cam kết chất lượng</a> | <a href="{'dieu-khoan-su-dung'|url_slug_page}" class="text-white">Điều khoản sử dụng</a> | <a href="{'chinh-sach-bao-mat'|url_slug_page}" class="text-white">Chính sách bảo mật</a>
<a href="//www.dmca.com/Protection/Status.aspx?ID=d8bfe3e5-89e6-4a48-8abc-77744f3d238e" title="DMCA.com Protection Status" rel="nofollow" class="dmca-badge" target="_blank"> <img loading="lazy" src ="https://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=d8bfe3e5-89e6-4a48-8abc-77744f3d238e" alt="DMCA.com Protection Status" /></a><script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"></script>
</div>
</div>
</div>
</div>
</footer>
<script src="{$base_tlp_front}/libs/fancybox/jquery.fancybox.min.js"></script>
<script src="{$base_tlp_front}/libs/ytb/ytb.min.js"></script>
<script src="{$base_tlp_front}/js/custom.min.js?ver=1.5"></script>
</div>
<div class="widget-action-sticky"><a class="widget-action-link" href="{$lable.social_link_zalo}" title="Zalo Panpic" target="_blank"><i class="sprite sprite-zalo"></i></a><a class="widget-action-link" href="https://m.me/100054436721848" title="Messenger Panpic" target="_blank"><i class="sprite sprite-messager"></i></a></div>
{include file="modal-notification.tpl"}
</body>
</html>