<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;
use Webetiq\Extruder;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

$numop = filter_input(INPUT_GET, 'op', FILTER_SANITIZE_STRING);
//$numop = 66460;

$ext = new Extruder($dbase);

$data = $ext->get($numop);

/*
$dados = [
    '68434',
    '0',
    '12.4',
    '12.9',
    '1',
    date('Y-m-d H:i:s'),
    'roberto'
];
$ext->set(... $dados);
*/


echo json_encode($data);