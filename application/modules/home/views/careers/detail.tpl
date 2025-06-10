{include file="header.tpl"}
<main class="main-content" id="main-content">
	<div class="container">
        {include file="breadcrumb.tpl"}
		<section class="page-content">
			<div class="row">
                {if $alert neq '' && $msg neq ''}
					<div class="col-md-12">
                        {include file="notes.tpl"}
					</div>
                {/if}
				<div class="col-lg-8 order-lg-1">
					<article class="single mb-5">
						<h1 class="single-title">{$careers.title|stripslashes}</h1>
						<div class="single-exerpt">
							<div>{$lable.careers_table_address}: {$careers.short}</div>
							<div>{$lable.careers_table_quantity}: {sprintf("%02d", $careers.price)}</div>
							<div>{$lable.careers_table_date}: {$careers.career_effect|date_format:"%d/%m/%Y"}
								- {$careers.career_expire|date_format:"%d/%m/%Y"}</div>
						</div>
						<div class="single-content text-justify mt-4">
                            {$careers.content|stripslashes}
						</div>
					</article>
					<div>
						<h3 class="page-title">{$lable.apply_recruitment}</h3>
                        {include file="careers/form.tpl"}
					</div>
				</div>
                {include file="sidebar-careers.tpl"}
			</div>
		</section>
	</div>
</main>
{include file="footer.tpl"}
<script src="{$base_tlp_front}/validator/assets/lib/jquery-validation/dist/jquery.validate.min.js"
        type="text/javascript" charset="utf-8"></script>
<script>
    var lable_remove_file = "{$lable.remove_file}";
    {literal}
    jQuery(document).ready(function () {

        $('#form-apply').validate({
            rules: {
                "data[fullname]": {required: true},
                "data[phone]": {required: true},
            },
            messages: {
                "data[fullname]": {
                    required: $("#fullname").data('fullname')
                },
                "data[phone]": {
                    required: $("#phone").data('phone')
                },
            },
            submitHandler: function (form) {
                form.submit();
                return false;
            }
        });

        $(document).on('change', 'input.custom-attach-file', function (e) {
            var fileName = e.target.files[0].name;
            fileName += ' <a href="javascript:void(0);" title="' + lable_remove_file + '" id="btn-file-reset"><span class="label label-danger">X</span></a>';

            $('#custom-input-filename').html(fileName);
            // Remove file attach
            $('#btn-file-reset').on('click', function (e) {
                var $el = $('#attachment');
                $el.wrap('<form>').closest('form').get(0).reset();
                $el.unwrap();
                $('#custom-input-filename').html('');
            });
        });

    });
    {/literal}
</script>
