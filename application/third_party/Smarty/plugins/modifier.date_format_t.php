<?php
function smarty_modifier_date_format_t($param=1)
{
    $time = time();
    return date("Y-m-d\TH:i:s.000\Z", $time);
}
