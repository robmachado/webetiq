<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

/* 
 * Este arquivo executa a importação automatica dos dados das OP
 * para a tabela MySql opmigrate
 */
use Webetiq\DBase\DBase;
use Webetiq\Migrate;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);


//exec('/var/www/webetiq/console/migrate.sh');
//carrega os dados na base opmigrate
$mig = new Migrate($dbase);
//converte os dados dos produtos
$aProds = $mig->setProdsList();
//converte os dados das OPs
$aOP = $mig->setOPsList();

$mig->setAllOPs();

echo "<pre>";
print_r($aOP);
echo "</pre>";
