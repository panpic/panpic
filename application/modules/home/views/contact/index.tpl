{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section bg-light">
		<div class="container">
            {include file="widget/breadcrumb_about.tpl"}
			<div class="row">
                {if $alert neq '' && $msg neq ''}
                    <div class="col-12 mt-5">
						{include file="notes.tpl"}
					</div>
				{/if}
                <div class="mt-0 mb-4 mb-lg-5">
                    <h1 class="heading-title lh-base h3">{$page.page_title|stripslashes}</h1>
                </div>
				<div class="col-lg-6 mb-5 mb-lg-0">
					<div class="heading">
						<h5 class="heading-title">{$lable.footer_contact_title}</h5>
					</div>
					<div class="border-0 rounded-0">
						<div class="card-body">
							{$page.page_detail|stripslashes}
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="heading">
						<h5 class="heading-title">{$lable.form_contact_title}</h5>
					</div>
					{include file="contact/form.tpl"}
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-5 mb-md-0">
					<div class="heading">
						<h5 class="heading-title">{$lable.contact_office}</h5>
					</div>
					<div class="map map--1x1 border" id="map1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7838.196545500897!2d106.63926678090891!3d10.803784950722873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175293ca05e5a49%3A0x5ec179e39b891e0d!2sPanpic%20technology!5e0!3m2!1sen!2s!4v1659672130862!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
                {**
				<div class="col-md-6">
					<div class="heading">
						<h5 class="heading-title">{$lable.contact_office_hanoi}</h5>
					</div>
					<div class="map map--1x1 border" id="map2"></div>
				</div>
				**}
			</div>
		</div>
	</section>
</main>
<script src="{$base_tlp_front}/validator/assets/lib/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
{**
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&amp;key=AIzaSyBMfBIfwo82J18tKitHHHSs0fzhrGyhUAo"></script>
**}
<script type="text/javascript">
    var map_address = "{$lable.map_address}";
    var map_content = '<div style="max-width:300px;"><div class="text-center"><img src="'+ base_url +'/assets/front/images/logo-contact.png" alt="PANPIC Logo"></div><div style="font-family:Arial;">'+ map_address +'</div></div>';
    var map_lat = "{$lable.map_lat}", map_long = "{$lable.map_long}";

    var map_address_sub1 = "{$lable.map_address_2}";
    var map_content_sub1 = '<div style="max-width:300px;"><div class="text-center"><img src="'+ base_url +'/assets/front/images/logo-contact.png" alt="PANPIC Logo"></div><div style="font-family:Arial;">'+ map_address_sub1 +'</div></div>';
    var map_lat_sub1 = "{$lable.map_lat_2}", map_long_sub1 = "{$lable.map_long_2}";

    {literal}
    /*
    function initMap(eleId, map_content, map_lat, map_long) {
        var locations = [[map_content, map_lat, map_long, 5]];
        var map = new google.maps.Map(document.getElementById(eleId), {
            zoom: 15,
            scrollwheel: true,
            center: new google.maps.LatLng(map_lat, map_long),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
        }
    }
    */

    jQuery(document).ready(function(){
        // initMap('map1', map_content, map_lat, map_long);
        // initMap('map2', map_content_sub1, map_lat_sub1, map_long_sub1);
        $('#form-contact').validate({
            rules: {
                "data[fullname]": {required: true},
                "data[email]": {required: true},
                "data[address]": {required: true},
                "data[content]": {required: true},
            },
            messages: {
                "data[fullname]": {
                    required: $("#fullname").data('fullname')
                },
                "data[email]": {
                    required: $("#email").data('email')
                },
                "data[address]": {
                    required: $("#address").data('address')
                },
                "data[content]": {
                    required: $("#content").data('content')
                },
            },
            submitHandler: function(form){
                form.submit(); return false;
            }
        });
    });
    {/literal}
</script>
{include file="footer.tpl"}