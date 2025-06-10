<?php
function smarty_modifier_count_gallery_product($object_id) {
    $ci = &get_instance();
    $cond = " WHERE i.image_type = '".PRODUCT_TYPE_PRODUCT_GALLERY."' AND i.object_id = $object_id ";
    $items = $ci->products_model->getGalleryItems($cond);
    return sizeof($items);
}
