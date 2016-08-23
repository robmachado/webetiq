<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

/*
$string = "String com numeros -12,3.456789 e símbolos !@#$%¨&*()_+";
echo $string.'<BR>';
$nova_string = preg_replace("/[^0-9,.\s]/", "", $string);
echo $nova_string;
*/
use Webetiq\Migrate;
use Webetiq\DBase;

ini_set('memory_limit', '2048M');

$migr = new Migrate();
$aProds = [1,2];
//$aProds = $migr->setProdsList();
//$aOPs  = $migr->setOPsList();

$dbase = new DBase();
$dbase->connect('localhost', '', 'root', 'monitor5');
$resp = $dbase->dbExists('webetiq');
if (!$resp) {
    $dbase->createDbase('webetiq');
    $dbase->disconnect();
}
$dbase->connect('localhost', 'webetiq', 'root', 'monitor5');

$migr->setFromProds($aProds);



