<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$p = ['printer' => 'zebra'];

echo json_encode($p);


