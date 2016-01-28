<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Migrate;

$f = filter_input(INPUT_GET, 'f', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

echo $f . '  id= ' . $id;
exit();

//de for passado um id carregar essa op e seu produto na base de dados e chamar a pagina
//etiqueta 

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
    if (! isset($id)) {
        //não foi passado um id
        if ($f == 'Full') {
            //se o id é = Full forçar uma cópia completa
            //isso irá apagar as tabelas
        } elseif ($f == 'Last') {
            //puxar as 10 ultimas OPS
        }
    } else {
        //se foi passado nenhum id
        if (is_numeric($id)) {
            //se o id é um numero
        }
    }
}
