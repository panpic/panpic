{include file="header.tpl"}
<main class="main-content" id="main-content">
	<section class="section">
		<div class="container">
			{include file="widget/breadcrumb_about.tpl"}
			<div class="row">
				<div class="col-lg-8 order-lg-1">
					<div class="heading mt-0">
						<h1 class="heading-title lh-base h3">{$lable.page_document_title}</h1>
					</div>
					<div class="row gx-2 gx-sm-3">
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead>
							<tr>
								<th>{$lable.page_document_table_col1}</th>
								<th>{$lable.page_document_table_col2}</th>
								<th>{$lable.page_document_table_col3}</th>
								<th>{$lable.page_document_table_col4}</th>
							</tr>
							</thead>
							<tbody>
							{foreach from=$document item=itemDocument}
								<tr>
									<td>
										<div class="document-item">
											<div class="item-icon">
												<span class="{$itemDocument.short|stripslashes}"></span>
											</div>
											<div class="item-main">
												<div class="item-main-title">{$itemDocument.title|stripslashes}</div>
												<i class="item-main-desc">Lượt xem {$itemDocument.hits}</i>
											</div>
										</div>
									</td>
									<td>{$itemDocument.cat_name}</td>
									<td>{$itemDocument.date_add|date_format:"%d/%m/%Y"}</td>
									<td>
										<a href="{$itemDocument.slug|url_fe_document_detail:$itemDocument.cat_slug}">
											{$lable.view_more}
										</a>
									</td>
								</tr>
							{/foreach}
							</tbody>
						</table>
					</div>
				</div>
				{include file="sidebar-service.tpl"}
			</div>
		</div>
	</section>
</main>
{include file="footer.tpl"}
<script>
    search_filter = "{$lable.search}";

    $('#example').DataTable({
        "language": {
            "paginate": {
                "previous": "<span class='glyphicon glyphicon-chevron-left'></span>",
                "next": "<span class='glyphicon glyphicon-chevron-right'></span>"
            },
            "search": search_filter,
        },
        'searching': true,
        'lengthChange': false,
        "paging": false,
        "info": false,
        "autoWidth": false
    });
</script>
