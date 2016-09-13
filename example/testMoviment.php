<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;
use Webetiq\Movements;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

$mov = new Movements($dbase);

//$mov->insert(14, 1, 100, 'pcs', 2.56, 3.01, 10);