<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;
$db['default'] = array(
'dsn'	=> '',
'hostname' => 'db',
'username' => 'root',
'password' => 'root',
'database' => 'pp',
'dbdriver' => 'mysqli',
'dbprefix' => '',
'pconnect' => FALSE,
'db_debug' => TRUE,
'cache_on' => TRUE,
'cachedir' => '',
'char_set' => 'utf8mb4',
'dbcollat' => 'utf8mb4_unicode_ci',
'swap_pre' => '',
'encrypt' => FALSE,
'compress' => TRUE,
'stricton' => FALSE,
'failover' => array(),
'save_queries' => TRUE
);
