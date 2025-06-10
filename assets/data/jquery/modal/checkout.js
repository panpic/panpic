/**
* WDNV/Checkout
* last update Jan 28 2015
* @subpackage doanhnghiep
* @since May 08 2015
*/

function popupCart(title, data) { $(document).ready( function(){ $.popup.show(title, '<div class="popup_cart">'+data+'</div>'); } ); }

function addItem(form_id) {	
	$.ajax({
		type: "POST",
		url: base_url+"/cartajxv2/add/",
		async: false,		
		data: $('#'+form_id).serialize(),
		success: addToCartOk,
		error: addToCartFail
	});
}


function addToCartOk(product) {
	$('#cart-num').html( product.cart_num );
	popupCart( shop_cart, product.cart_content);
}


function addToCartFail(obj, status) {
	popupCart( shop_cart, "Hệ thống đang bận, Sản phẩm không thể thêm vào giỏ hàng, vui lòng quay lại sau.");
}

$(".btnmua").click(function() { addItem('add-to-cart'); });