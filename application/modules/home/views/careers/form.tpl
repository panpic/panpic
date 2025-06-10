<div class="heading">
	<h4 class="heading-title">{$lable.apply_recruitment}</h4>
</div>
<form name="form-apply" id="form-apply" class="form" role="form" method="post" action="{$detail_link}" enctype="multipart/form-data">
<input type="hidden" name="data[career_pos]" id="career_pos" value="{$news.title|stripslashes}">
	<div class="form-group">
		<a href="{$lable.link_download_form_cv_candidate}" target="_blank"><i class="far fa-file-word"></i> {$lable.title_cv_from_apply}</a>
	</div>
	<div class="form-group">
		<input type="text" name="data[fullname]" id="fullname" placeholder="{$lable.fullname} (*)" class="form-control radius--20" data-fullname="Nhập họ tên" required="required">
	</div>
	<div class="form-group">
		<input type="text" name="data[phone]" id="phone" placeholder="{$lable.contact_form_placeholder_phone} (*)" class="form-control radius--20"data-phone="Nhập số điện thoại" required="required">
	</div>
	<div class="form-group">
		<input type="text" name="data[email]" id="email" placeholder="{$lable.email}" class="form-control radius--20">
	</div>
	<div class="form-group pl-3 pl__pc--20">
		<div class="form__upload mb-3">
			<div class="button fileinput-button">
				<span class="fa fa-plus" aria-hidden="true"></span>
				<label class="mb-0 custom-attach-file" for="attachment">{$lable.add_attach}</label>
				<input class="custom-attach-file" id="attachment" type="file" name="file1" style="display:none;" />
			</div>
			<div id="custom-input-filename"></div>
		</div>
	</div>
	<div class="form-group">
		<textarea name="data[linkedin]" id="linkedin" rows="7" class="form-control radius--20" placeholder="{$lable.content}"></textarea>
	</div>
	<div class="col-12">
		<div class="mb-3 text-right">
			<button class="btn bg-secondary text-white">{$lable.btn_send}</button>
		</div>
	</div>
</form>
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