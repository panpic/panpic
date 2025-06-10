<?php

function smarty_modifier_convert_vnd_no_char($priceFloat, $echange){
	
	$priceFloat = $priceFloat+0;
	if($priceFloat == 0 && $echange == '') {
		return "";
	}
	
	//$arr = explode('.', $priceFloat);
	//$priceFloat = $arr[0];
	$priceFloat = $priceFloat * $echange;

	$priceAfter = !empty($arr[1]) ? '.'.$arr[1] : '';
	
	$symbol = '';
	$symbol_thousand = ',';
	$decimal_place = 0;
	$price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
	return $price.$priceAfter.$symbol;	
}