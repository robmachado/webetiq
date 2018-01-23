<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Entries\Entries;

$data = filter_input(INPUT_GET, 'd', FILTER_SANITIZE_STRING);

$en = new Entries();
echo json_encode($en->getMaquinas($data));