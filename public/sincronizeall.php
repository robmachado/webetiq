<?php
require_once '../bootstrap.php';

use Webetiq\Migrations\Migrate;

$mig = new Migrate();

//pega todos as OP do MDB
$maxOp = $mig->getMaxOP();
$lastOp = $mig->getLastNumOrder();
do {
    $mig->syncOrders();
    $lastOp = $mig->getLastNumOrder();
    sleep(2);
} while ($lastOp < $maxOp);

//pega todos os produtos do MDB
$maxProd = $mig->getMaxProduct();
$lastProd = $mig->getLastNumProd();
do {
    $mig->syncProducts();
    $lastProd = $mig->getLastNumProd();
    sleep(2);
} while ($lastProd < $maxProd);

$redirect = 'pcp.php';
header("location:$redirect");

