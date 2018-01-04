<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use PDO;

$query = 'SELECT * FROM OP';
$mdb_file = '/var/www/webetiq/storage/OP.mdb';
$uname = explode(" ",php_uname());
$os = $uname[0];
switch ($os){
  case 'Windows':
    $driver = '{Microsoft Access Driver (*.mdb)}';
    break;
  case 'Linux':
    $driver = 'MDBTools';
    break;
  default:
    exit("Don't know about this OS");
}
$dataSourceName = "odbc:Driver=$driver;DBQ=$mdb_file;";
$connection = new PDO($dataSourceName);
$result = $connection->query($query)->fetchAll(\PDO::FETCH_ASSOC);
print_r($result);