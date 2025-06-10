<form class="form" method="post" id="form-contact">
    <div class="form-group">
        <label class="bi bi-person" for="name"></label>
        <input class="form-control" type="text" placeholder="{$lable.contact_form_placeholder_fullname}"
               name="data[fullname]" id="fullname" data-fullname="{$lable.contact_form_fullname}" required>
    </div>
    <div class="form-group">
        <label class="bi bi-telephone" for="address"></label>
        <input class="form-control" type="text" placeholder="{$lable.contact_form_placeholder_phone}"
               name="data[address]" id="address" data-address="{$lable.contact_form_placeholder_phone}" required>
    </div>
    <div class="form-group">
        <label class="bi bi-envelope" for="email"></label>
        <input class="form-control" type="text" placeholder="{$lable.contact_form_placeholder_email}"
               name="data[email]" id="email" data-email="{$lable.contact_form_email}" required>
    </div>
<div class="form-group">
        <textarea class="form-control" rows="5" placeholder="{$lable.contact_form_placeholder_content}"
name="data[content]" id="content" data-content="{$lable.contact_form_content}">{$content}</textarea>
    </div>
    <div class="d-flex flex-column flex-sm-row pt-1">
        <div class="col-sm-7 pl-sm-0 d-flex flex-column">
            {$captcha.widget}
            {$captcha.script}
        </div>
        <div class="col-sm-5">
            <button class="btn btn-primary">{$lable.btn_send}</button>
        </div>
    </div>
</form>