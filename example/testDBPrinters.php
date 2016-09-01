<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBPrinter;

$dbp = new DBPrinter();
$all = $dbp->getAll();
echo "<pre>";
print_r($all);
echo "</pre>";
echo "<BR>";
$p = $dbp->getPrinter('newZebra');
echo "<pre>";
print_r($p);
echo "</pre>";
echo "<BR>";