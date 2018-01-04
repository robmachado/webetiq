<?php
require_once '../bootstrap.php';

use Webetiq\Migrations\Migrate;

$mig = new Migrate();

//$mig->getMaxOP();
//die;

//$mig->syncProducts();
/*
$resp = $mig->pullOp('', 'I');
echo "<pre>";
print_r($resp);
echo "</pre>";

die;
 * 
 */
$resp = $mig->syncProducts();
echo "<h1>Produtos</h1><br/>";
echo "<pre>";
print_r($resp);
echo "</pre>";

/*
$resp = $mig->syncOrders();
echo "<h1>Ordens</h1><br/>";
echo "<pre>";
print_r($resp);
echo "</pre>";
*/