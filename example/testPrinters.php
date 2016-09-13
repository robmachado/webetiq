<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Printers;
use Webetiq\DBase\DBase;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

$dbp = new Printers($dbase);
$all = $dbp->all();
echo "<pre>";
print_r($all);
echo "</pre>";
echo "<BR>";
$p = $dbp->get('newZebra');
echo "<pre>";
print_r($p);
echo "</pre>";
echo "<BR>";