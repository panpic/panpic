{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
		{include file="breadcrumb.tpl"}
	</div>
	<div class="page-content mb-0">
		<section class="section-timeline bg-gradient3 py-6">
			<div class="container">
				<h1 class="section-title text-secondary">{$lable.page_history_title|stripslashes}</h1>
				<p class="text-center mb-4 mb-md-6">{$lable.page_history_desc|stripslashes}</p>
				<div class="cd-horizontal-timeline">
					<div class="timeline">
						<div class="events-wrapper">
							<div class="events">
								<ul class="list-unstyled">
									{foreach from=$history key=$keyHistory item=historyItem}
										<li>
											{if $keyHistory == 0}
											<a class="selected" href="#0"
											   data-date="{$historyItem.portfolio_year|date_format:"%d/%m/%Y"}" rel="{$historyItem.portfolio_year|date_format:"%Y"}">
												{else}
												<a href="#{$keyHistory}"
												   data-date="{$historyItem.portfolio_year|date_format:"%d/%m/%Y"}" rel="{$historyItem.portfolio_year|date_format:"%Y"}">
													{/if}
													{$historyItem.portfolio_year|date_format:"%Y"}
												</a>
										</li>
									{/foreach}
								</ul>
								<span class="filling-line" aria-hidden="true"></span>
							</div>
						</div>
						<ul class="list-unstyled cd-timeline-navigation">
							<li>
								<a class="prev inactive" href="#0">
									<i class="bi bi-chevron-left"></i>
								</a>
							</li>
							<li>
								<a class="next" href="#0">
									<i class="bi bi-chevron-right"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="events-content">
						<ol class="list-unstyled">
							{foreach from=$history key=$keyHistory item=historyItem}
								{if $keyHistory == 0}
									<li class="selected"
										data-date="{$historyItem.portfolio_year|date_format:"%d/%m/%Y"}">
										{else}
									<li data-date="{$historyItem.portfolio_year|date_format:"%d/%m/%Y"}">
								{/if}
								<div class="row gx-2 gx-md-3">
									{if !is_null($historyItem.path_image) }
									<div class="col-md-4" title="{$historyItem.title|stripslashes}">
										<figure class="thumbnail-object-fit thumbnail--6x4 ani-zoom">
											<img src="{$link_upload}/{$historyItem.path_image}"
												 alt="{$historyItem.title|stripslashes}">
										</figure>
									</div>
									<div class="timeline-content col-md-8 mt-3 mt-md-0">
										{else}
										<div class="timeline-content col-md-12 mt-3 mt-md-0">
											{/if}
											<h4>{$historyItem.title|stripslashes}</h4>
											<p>{$historyItem.content|stripslashes}</p>
										</div>
									</div>
								</li>
							{/foreach}
						</ol>
					</div>
				</div>
			</div>
		</section>
		<div class="container mt-4">
			{$page.page_short|stripslashes}
		</div>
		<div class="container mt-4">
			{$page.page_detail|stripslashes}
		</div>
		{include file="about/services.tpl"}
	</div>
</main>
{include file="footer.tpl"}
<script src="{$base_tlp_front}/libs/timeline.js?ver=1.0.1"></script>
