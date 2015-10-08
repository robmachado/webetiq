<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Label;
use Webetiq\Factory;

$lbl = new Label();

$propNames = get_object_vars($lbl);
foreach ($propNames as $key => $value) {
    $lbl->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}
$printer = filter_input(INPUT_POST, 'printer', FILTER_SANITIZE_STRING);

$fact = new Factory();
$fact::setPrinter($printer);
$fact::make($lbl);
