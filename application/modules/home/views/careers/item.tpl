{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">
			<div class="heading mt-0 mb-4 mb-lg-5">
				<h1 class="heading-title lh-base h3">{$lable.menu_recruitment}</h1>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="recruit-slider" id="recruit-slider">
                        {foreach from=$banners item=bn}
							<div class="recruit-slider-item">
								<figure class="thumbnail-object-fit main-slider-thumb">
									<img src="{$link_upload}/{$bn.banner_file}" alt="{$bn.title|stripslashes}">
								</figure>
								<div class="recruit-slider-text">
									<a href="{$bn.link_click|stripslashes}"
									   title="{$bn.title|stripslashes}">{$bn.title|stripslashes}</a>
								</div>
							</div>
                        {/foreach}
					</div>
					<script>
                        $(function () {
                            app.Slider({
                                el: "#recruit-slider",
                                options: {
                                    dots: false
                                }
                            });
                        });
					</script>
				</div>
				<div class="col-12">
					<div class="page-heading my-4">
						<h4 class="page-title">{$lable.careers_table_title}</h4>
						<div class="line line-sm"></div>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered mt-3 fs-14">
							<thead>
							<tr class="text-primary">
								<th class="text-center">{$lable.no}</th>
								<th>{$lable.careers_table_position}</th>
								<th class="text-center">{$lable.careers_table_quantity}</th>
								<th>{$lable.careers_table_address}</th>
								<th>{$lable.careers_table_date}</th>
							</tr>
							</thead>
							<tbody>
							{foreach from=$career key=$key item=careerItem}
								<tr>
									<th class="text-center">{sprintf("%02d", ($key + 1))}</th>
									<td>
										<a href="{$careerItem.slug|url_careers_detail:$careerItem.blog_id}">
											{$careerItem.title|stripslashes}
										</a>
									</td>
									<td class="text-center">{sprintf("%02d", $careerItem.price)}</td>
									<td>{$careerItem.short}</td>
									<td>{$careerItem.career_effect|date_format:"%d/%m/%Y"} - {$careerItem.career_expire|date_format:"%d/%m/%Y"}</td>
								</tr>
							{/foreach}
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
