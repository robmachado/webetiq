<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

//$units = new \Webetiq\Units($dbase);

//$printers = new \Webetiq\Printers($dbase);

$ops = new \Webetiq\Ops($dbase);

