<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBaseLabel;

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//executa a migração dos dados do banco MDB
// ../local/OP.mdb => ../sql/OP.sql 
// e ../sql/produtos.sql
exec('../src/migrate.sh');

//uma vez que os dados foram extraidos carrega-los na base de dados migrate
//carrega classe de acesso a base de dados
$dbase = new Webetiq\DBaseLabel();
$listaProd = '../sql/produtos.sql';
$listaOP = '../sql/OP.sql';
if (is_file($listaProd) && is_file($listaOP)) {
    //se existem os dois arquivos 
    if (isset($id)) {
        //foi passado um id
        if ($id == 'Full') {
            //se o id é = Full forçar uma cópia completa
            //isso irá apagar as tabelas 
        } else {
            //se o id é um numero
        }
    } else {
        //se não foi passado nenhum id
    }
}
