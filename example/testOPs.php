<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;
use Webetiq\Ops;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

$ops = new Ops($dbase);

$op = $ops->get('7');

echo "<pre>";
print_r($op);
echo "</pre>";
