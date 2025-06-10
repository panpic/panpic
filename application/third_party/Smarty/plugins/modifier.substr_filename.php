<?php

function smarty_modifier_substr_filename($filepatch)
{
    $file = explode('/', $filepatch);
    $tt = sizeof($file);
    return $file[$tt-1];
}
