<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty convert_vnd Vietnamese modifier plugin
 * contact@panpic.vn
 *
 * @param float $priceFloat
 * @param float $echange
 * 
 * @return string
 */
function smarty_modifier_convert_vnd($priceFloat){
	
	$priceFloat = $priceFloat+0;
	if($priceFloat == 0 || $priceFloat == '') {
		return 'Liên hệ';
	}
	
	$symbol = 'đ';
	$symbol_thousand = ',';
	$decimal_place = 0;
	$price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
	return $price.$symbol;
}