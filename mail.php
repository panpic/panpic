<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", "on");

$host = 'smtp.gmail.com';
$port = '465';
$tval ='30';

$test = fsockopen('ssl://' . $host, $port, $errno, $errstr, $tval); 
if ($test == true){
print("OK");}
else
{
print $test;
}
?>