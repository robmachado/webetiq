<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Models\Printer;

$printer = 'Local';
$objPrinter = new Printer($printer);


print_r($objPrinter);
