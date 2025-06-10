<?php

function smarty_modifier_convert_saleoff($product_sale_percent){
	$priceFloat = $product_sale_percent+0;
	if($priceFloat > 0) {
        return "$product_sale_percent%";
	} else {
        return '';
    }
}