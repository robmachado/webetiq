<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Op;

$op = new Op();

$num = $op->getLastOp();


