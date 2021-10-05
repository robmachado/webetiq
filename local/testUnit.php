<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Units;

$unid = new Units();

$unid->push();

$todas = $unid->all();
var_dump($todas);



