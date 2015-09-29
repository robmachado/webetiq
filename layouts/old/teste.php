<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'on');

echo "Aqui";

$driver = 'MDBTools';
$mdb_file = '/var/www/mdb/OP.mdb';
$dataSourceName = "odbc:Driver=$driver;DBQ=$mdb_file;";
$connection = new \PDO($dataSourceName);
echo $dataSourceName;


$op = '58666';
$campo = "NÃºmero da OP";
//$sqlComm = "SELECT * FROM OP"; // WHERE \"".$campo."\"=$op";

$result = $connection->query($query)->fetchAll(\PDO::FETCH_ASSOC);
print_r($result);

