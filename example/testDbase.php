<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';


use Webetiq\DBase;

$dbase = new DBase('../config/config.json');
$dbase->connect();
$sqlComm = "SELECT * FROM printers WHERE printType = 'T' AND printBlock = '0'";
$sqlComm .= " ORDER BY printName";
$dados = $dbase->querySql($sqlComm);
print_r($dados);
