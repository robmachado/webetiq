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

//exec(__DIR__ . 'migrate.sh');

echo "MIGRANDO !!!";
sleep(10);
//carrega os dados na base opmigrate
$mig = new Migrate($dbase);
//converte os dados das OPs
//$aOP = $mig->setOPs();
//insere na base dados
//$mig->insertOPs();
//$mig->setFromLast();

/*
echo "<pre>";
print_r($aOP);
echo "</pre>";
*/