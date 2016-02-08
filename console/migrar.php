<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';


/* 
 * Este arquivo executa a importação automatica dos dados das OP
 * para a tabela MySql opmigrate
 */

use Webetiq\Migrate;

//converte os dados usando mdbtools
$mig = new Migrate();


//
$mig->setFromLast();
$mig->setProds();
//$mig->setProds();

var_dump($mig->error);


