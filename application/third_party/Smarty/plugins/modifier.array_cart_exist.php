<?php

function smarty_modifier_array_cart_exist($product_id, $cart)
{
    $flag = 0;
    $qty = '';
    if($cart) {
        foreach ($cart as $vl){
            if($product_id == $vl['product_id']) {
                $flag = 1;
                $qty = $vl['qty'];
            }

        }
    }

    return array('flag'=> $flag, 'qty' => $qty);
}
