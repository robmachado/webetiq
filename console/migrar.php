<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '/var/www/webetiq/bootstrap.php';

/* 
 * Este arquivo executa a importação automatica dos dados das OP
 * para a tabela MySql opmigrate
 */
use Webetiq\DBase\DBase;
use Webetiq\Migrate;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

exec(__DIR__ . '/migrate.sh');

$mig = new Migrate($dbase);
sleep(1);
$mig->setFromLast();
