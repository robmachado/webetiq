<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../../bootstrap.php';

use Webetiq\Entries\Entries;
/*
$en = new Entries();

$rs = $en->getMaquinas('2018-01-23');
echo "<pre>";
print_r($rs);
echo "</pre>";
die;
 * 
 */
use Webetiq\DateTime\DateTime;

$codparada = explode('-', '0');


$d = DateTime::convertTimeToDec('06:25');
$t = DateTime::convertDecToShiftMode($d);


$t = DateTime::convertShiftModeToDec(24);

$h = DateTime::convertDecToTime($t);

echo $h;