<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';


$string = "String com numeros -12,3.456789 e símbolos !@#$%¨&*()_+";
echo $string.'<BR>';
$nova_string = preg_replace("/[^0-9,.\s]/", "", $string);
echo $nova_string;

//use Webetiq\Migrate;

//$migr = new Migrate();

