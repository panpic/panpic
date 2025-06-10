{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content award">
			<div class="heading mt-0 mb-4 mb-lg-5">
				<h1 class="heading-title lh-base h3">{$lable.award}</h1>
			</div>
			<div class="post-content">
				{foreach from=$category  item=vl}
					{assign var=category_id value=$vl.post_cat_id}

					<h3 class="border-bottom-1 clearfix"><span class="bg-main text-white text-uppercase">{$vl.cat_name}</span></h3>
					<div class="p-3 mb-4">
						<div class="row justify-content-center">
							<div class="col-12 col-sm-12 col-md-8 text-primary text-center text-uppercase">
								<strong>{$vl.cat_note|stripslashes}</strong>
							</div>
						</div>
					</div>

					{assign var=personal value=$items[$category_id]}
					{if $personal}
						<div class="row gx-2 gx-sm-3 clearfix">
							{foreach from=$personal item=p}

								<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 pl-25 pr-25">

									<div class="card">
										<figure class="thumbnail-object-fit thumbnail--4x6 ani-zoom">
										{include file="inc/image_card.tpl"
										thumbnail=$p.path_image_thumb
										image=$p.path_image
										title=$p.title}
										</figure>
										<div class="card-body">
											<div class="card-text text-primary"><strong>{$lable.fullname}</strong>: {$p.title|stripslashes}</div>
											<div class="card-text text-primary"><strong>{$lable.department_construction}</strong>: {$p.short|stripslashes}</div>
											<div class="card-text text-primary"><strong>{$lable.job_title}</strong> {$p.seo_title|stripslashes}</div>
											<div class="card-text text-primary">{$p.content|stripslashes}</div>
										</div>

									</div>
								<br />
								</div>
							{/foreach}
						</div>
					{/if}
				{/foreach}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
