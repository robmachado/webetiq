<?php




$opstruct = [
    ['id','Número da OP','int',null,4],
    ['cliente','Cliente','varchar',null,60],
    ['codcli','CODIGO CLIENTE','varchar',null,100],
    ['pedido','Numero Pedido','int',null,4],
    ['prazo','Prazo de entrega','date','dateTime',8],
    ['nome','Nome da Peça','varchar',null,100],
    ['maq','Número da Máquina','varchar',null,40],
    ['matriz','Matriz','varchar',null,10],
    ['mp1q','kg','varchar','float',20],
    ['mp1qi','Kg ind','varchar','float',20],
    ['mp2q','kg2','varchar','float',20],
    ['mp2qi','kg2 ind','varchar','float',20],
    ['mp3q','kg3','varchar','float',20],
    ['mp3qi','kg3 ind','varchar','float',20],
    ['mp4q','Kg 4','varchar','float',20],
    ['mp4qi','kg4 ind','varchar','float',20],
    ['mp5q','kg5','varchar','float',20],
    ['mp5qi','kg5ind','varchar','float',20],
    ['mp6q','kg6','varchar','float',20],
    ['mp6qi','kg6ind','varchar','float',20],
    ['pesototal','Peso Total','float',null,8],
    ['pesomilheiro','peso milheiro','float',null,8],
    ['pesobobina','peso bobina','float',null,8],
    ['quantidade','Quantidade','float',null,8],
    ['bob','bol bobinas','tinyint',null,4],
    ['data','Data emissão','date','dateTime',8],
    ['metragem','metragem','int',null,4],
    ['dif','contador dif','int',null,4],
    ['iso','iso bobinas','tinyint',null,4],
    ['pedcli','pedcli','varchar',null,60],
    ['unidade','unidade','varchar',null,6]
];


function create($table, $array, $primindex) 
{
    $sqlComm = "CREATE TABLE `$table` (\n";
    foreach ($array as $field) {
        if ($field[0] == 'id') {
            $sqlComm .= "`id` INT(10) UNSIGNED NOT NULL PRIMARY KEY,";
        } else {
            if (!empty($field[3])) {
                $tipo = strtoupper($field[3]);
            } else {
                $tipo = strtoupper($field[2]);
            }
            $name = trim($field[0]);
            $strindex = "";
            if ($name == $primindex) {
                $strindex = " PRIMARY KEY";
            }
            switch ($tipo) {
                case 'INT':
                    $sqlComm .= "\n`" . $name . "` INT(10)  UNSIGNED NOT NULL".$strindex.",";
                    break;
                case 'VARCHAR':
                    $sqlComm .= "\n`" . $name . "` varchar(" . $field[4] . ") COLLATE utf8_unicode_ci NOT NULL DEFAULT ''".$strindex.",";
                    break;
                case 'FLOAT':
                    $sqlComm .= "\n`" . $name . "` double NOT NULL DEFAULT '0'".$strindex.",";
                    break;
                case 'TINYINT':
                    $sqlComm .= "\n`" . $name . "` tinyint(4) NOT NULL DEFAULT '0'".$strindex.",";
                    break;
                case 'TEXT':
                    $sqlComm .= "\n`" . $name . "` text COLLATE utf8_unicode_ci NOT NULL".$strindex.",";
                    break;
                case 'DATETIME':
                    $sqlComm .= "\n`" . $name . "` datetime NOT NULL".$strindex.",";
                    break;
            }
        }
    }
    $sqlComm = substr($sqlComm, 0, strlen($sqlComm)-1);
    return $sqlComm."\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
}

$prodstruct = [
    ['nome', 'Nome da peça','varchar', null,100],
    ['codigo', 'Código da Peça','varchar', null,60],
    ['ean', 'ean','varchar', null,26],
    ['validade', 'validade','int', null,4],
    ['mp1', 'Materia prima','varchar', null,100],
    ['mp1p', '%1','float', null,4],
    ['mp2', 'MP2','varchar', null,40],
    ['mp2p', '%2','float', null,4],
    ['mp3', 'MP3','varchar', null,40],
    ['mp3p', '%3','float', null,4],
    ['mp4', 'materia prima 4','varchar', null,40],
    ['mp4p', '% 4','float', null,4],
    ['mp5', 'mp5','varchar', null,40],
    ['mp5p', 'qmp5','float', null,4],
    ['mp6', 'mp6','varchar', null,40],
    ['mp6p', 'qmp6','float', null,4],
    ['densidade', 'densidade','float', null,8],
    ['gramatura', 'gramatura','float', null,8],
    ['tipobob', 'Tipo de Bobina','varchar', null,100],
    ['tratamento', 'Tratamento porcentagem','varchar', 'float',100],
    ['lados', 'Lados','varchar', null,100],
    ['largbob', 'Bobina Largura (cm)','varchar', 'float',40],
    ['largbobtols', 'tol largura bob','float', null,4],
    ['largbobtoli', 'tol largura bob -','float', null,4],
    ['refilar', 'refilar','varchar', null,100],
    ['bobvez', 'bobinas por vez','varchar', null,100],
    ['esp1', 'Bobina Espessura 1 (micras)','varchar', null,100],
    ['esp1tols', 'tol espess1','float', null,4],
    ['esp1toli', 'tol espess1 -','float', null,4],
    ['esp2', 'Bobina Espessura 2 (micras)','varchar', 'float',100],
    ['esp2tols', 'tol espess2','float', null,4],
    ['esp2toli', 'tol espess2 -','float', null,4],
    ['sanfbob', 'Bobina Sanfona (cm)','varchar', 'float',100],
    ['sanfbobtols', 'tol sanfona ext','float', null,4],
    ['sanfbobtoli', 'tol sanfona ext -','float', null,4],
    ['impressao', 'Impressão','varchar', null,100],
    ['cilindro', 'Dentes do Cilindro','int', null,4],
    ['cyrel1', 'Codigo Cyrel1','varchar', null,100],
    ['cyrel2', 'Codigo Cyrel2','varchar', null,100],
    ['cyrel3', 'Codigo Cyrel3','varchar', null,100],
    ['cyrel4', 'Codigo Cyrel4','varchar', null,100],
    ['cor1', 'Cor 1','varchar', null,100],
    ['cor2', 'Cor 2','varchar', null,100],
    ['cor3', 'Cor 3','varchar', null,100],
    ['cor4', 'Cor 4','varchar', null,100],
    ['cor5', 'Cor 5','varchar', null,100],
    ['cor6', 'Cor 6','varchar', null,100],
    ['cor7', 'Cor 7','varchar', null,100],
    ['cor8', 'Cor 8','varchar', null,100],
    ['modelosaco', 'Modelo Saco','varchar', null,100],
    ['ziper', 'Ziper','tinyint', null,0],
    ['zipernum', 'N Ziper','int', null,4],
    ['solda', 'Tipo Solda','varchar', null,100],
    ['cortarvez', 'Cortar por vez','varchar', null,100],
    ['largsaco', 'Saco Largura/Boca','float', null,8],
    ['largsacotols', 'tol largura','float', null,4],
    ['largsacotoli', 'tol largura -','float', null,4],
    ['compsaco', 'Saco Comprimento','float', null,8],
    ['compsacotols', 'tol comprimento','float', null,4],
    ['compsacotoli', 'tol comprimento -','float', null,4],
    ['espsaco', 'Saco Espessura','float', null,8],
    ['espsacotols', 'tol espessura','float', null,4],
    ['espsacotoli', 'tol espessura -','float', null,4],
    ['microperfurado', 'microperfurado','tinyint', null,0],
    ['estampado', 'estampado','tinyint', null,0],
    ['estampar', 'estampar','varchar', null,100],
    ['laminado', 'laminado','tinyint', null,0],
    ['laminar', 'laminar','varchar', null,100],
    ['bolha', 'bolha','tinyint', null,0],
    ['bolhar', 'bolhar','varchar', null,200],
    ['isolmanta', 'isolmanta','tinyint', null,0],
    ['isolmantar', 'isolmantar','varchar', null,100],
    ['colagem', 'colagem','varchar', null,20],
    ['dyna', 'teste dinas','varchar', null,100],
    ['sanfcorte', 'sanfona corte','varchar', 'float',100],
    ['sanfcortetols', 'tol sanf corte','float', null,4],
    ['sanfcortetol1', 'tol sanf corte -','float', null,4],
    ['aba', 'Aba','varchar', 'float',100],
    ['abatols', 'tol aba','float', null,4],
    ['abatoli', 'tol aba -','float', null,4],
    ['amarrar', 'AMARRAR','int', null,4],
    ['qtdpcbb', 'QT PECAS BOB BOLHA','int', null,4],
    ['fatiar', 'FATIAR EM','int', null,4],
    ['qtdpcbm', 'QT PECAS BOB MANTA','int', null,4],
    ['bolhafilm1', 'bolhaFilm1','varchar', null,100],
    ['bolhafilm2', 'bolhaFilm2','varchar', null,100],
    ['bolhafilm3', 'bolhaFilm3','varchar', null,100],
    ['bolhafilm4', 'bolhaFilm4','varchar', null,100],
    ['qtdpacote', 'PACOTE COM','int', null,4],
    ['embalagem', 'EMBALAGEM','varchar', null,90]
];

/*
echo "<pre>";
print_r(create('produtos', $prodstruct, 'nome'));
echo "</pre>";
die;
*/

//$ini = $_REQUEST['ini'];
//$fim = $_REQUEST['fim'];

$command = "echo 'SELECT * FROM OP WHERE \"Número da OP\" < 40' | mdb-sql -HFp -d \"|\" OP.mdb";

//$command = "echo 'describe table OP' | mdb-sql -HFp -d \"|\" OP.mdb";

//$command = "echo 'SELECT * FROM produtos' | mdb-sql -HFp -d \"|\" OP.mdb";

//$command = "echo 'describe table produtos' | mdb-sql -HFp -d \"|\" OP.mdb";

$last_line = shell_exec($command);

/*
echo "<pre>";
print_r($last_line);
echo "</pre>";
die;
*/

$aResp = explode("\n", $last_line);

foreach ($aResp as $r) {
    if (empty($r)) {
        continue;
    }
    $d = explode('|', $r);
    $aDados[$d[0]] = $d;
}
ksort($aDados);


$sqlComm = "INSERT INTO ordens (";
foreach($opstruct as $fields) {
    $sqlComm .= $fields[0].',';
}
$sqlComm = substr($sqlComm, 0, strlen($sqlComm)-1) .  ") VALUES (";

foreach($aDados as $key => $d) {
    $i = 0;
    $sql = "";
    foreach($d as $f) {
        $value = trim($f);
        $tipo = $opstruct[$i][2];
        if (!empty($opstruct[$i][3])) {
            $tipo = $opstruct[$i][3];
            //deve haver uma conversão
            $convert = $opstruct[$i][2].'To'. ucfirst($opstruct[$i][3]);
            $value = $convert($value);
        }
        if ($tipo == 'float' || $tipo == 'int' || $tipo == 'tinyint' ) {
            $value = (float) $value;
            if (empty($value)) {
                $value = 0;
            }
        }
        $sql .= "'$value',"; 
        $i++;
    }    
    $sql = $sqlComm . substr($sql, 0, strlen($sql)-1) .  ");";
    echo $sql."<br>";
}

function varcharToFloat($value)
{
    $value = preg_replace("/[^0-9,.]/", "", $value);
    $value = str_replace('.', '', $value);
    return (float) str_replace(',', '.', $value);
}

function dateToDateTime($value) 
{
    $dt = new DateTime($value);
    return $dt->format('Y-m-d H:i:s');
}

die;
echo "<pre>";
print_r($aDados);
echo "</pre>";
