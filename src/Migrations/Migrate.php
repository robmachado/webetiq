<?php
namespace Webetiq\Migrations;

use Webetiq\DBase\DBase;
use \DateTime;

class Migrate
{
    protected $table_op = [
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
        ['unidade','unidade','varchar',null,6],
        ['prod_id', 'prod_id', 'int',null, 4]
    ];
    
    protected $table_prod = [
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
        ['esp1', 'Bobina Espessura 1 (micras)','varchar', 'float',100],
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
        ['embalagem', 'EMBALAGEM','varchar', null,90],
        ['id','id','int',null,4]
    ];

    protected $aUnit = [
        1 => "pcs",
        2 => "cen",
        3 => "mil",
        4 => "kg",
        5 => "m",
        6 => "m²",
        7 => "bob",
        8 => "cj"
    ];
    
    protected $db;
    protected $mdbpath;

    public function __construct()
    {
        $config = json_encode(
            [
                'host' => 'localhost',
                'user'=>'root',
                'pass'=>'monitor5',
                'db'=>'legacy'
            ]);
        $this->db = new DBase($config);
        $this->db->connect(); 
        $this->mdbpath = realpath('../storage/OP.mdb');
    }
    
    public function getMaxOP()
    {
        $command = "echo 'SELECT \"Número da OP\" FROM OP '| mdb-sql -HFp -d \"|\" $this->mdbpath";
        $data = shell_exec($command);
        $d = explode("\n", $data);
        $data = null;
        asort($d);
        $d = array_filter($d, function($value) { return $value !== ''; });
        return max($d);
    }
    
    public function getMaxProduct()
    {
        $command = "echo 'SELECT \"id\" FROM produtos '| mdb-sql -HFp -d \"|\" $this->mdbpath";
        $data = shell_exec($command);
        $d = explode("\n", $data);
        $data = null;
        asort($d);
        $d = array_filter($d, function($value) { return $value !== ''; });
        return max($d);
    }
    
    public function syncOrders($num = '')
    {
        $last = $this->getLastNumOrder();
        $limitsup = $last+1000;
        $limitinf = $last;
        if (!empty($num)) {
            $command = "echo 'SELECT * FROM OP WHERE \"Número da OP\" = $num'| mdb-sql -HFp -d \"|\" $this->mdbpath";
        } else {
            $command = "echo 'SELECT * FROM OP WHERE \"Número da OP\" > $limitinf AND \"Número da OP\" <= $limitsup'| mdb-sql -HFp -d \"|\" $this->mdbpath";
        }            
        //$command = "echo 'describe table OP' | mdb-sql -HFp -d \"|\" OP.mdb";
        $data = shell_exec($command);
        $sql = $this->sqlRender('OP', $data);
        $this->saveOrders($sql);
        return $sql;
    }
    
    public function syncProducts($num = '')
    {
        $last = $this->getLastNumProd();
        $limitsup = $last+1000;
        $limitinf = $last;
        if (!empty($num)) {
            $command = "echo 'SELECT * FROM produtos WHERE id=$num'| mdb-sql -HFp -d \"|\" $this->mdbpath";            
        } else {
            $command = "echo 'SELECT * FROM produtos WHERE id > $limitinf AND id <= $limitsup'| mdb-sql -HFp -d \"|\" $this->mdbpath";
        }    
        $data = shell_exec($command);
        $sql = $this->sqlRender('produtos', $data);
        $this->saveProducts($sql);
        return $sql;
    }
    
    public function sqlRender($table, $data)
    {
        $aResp = explode("\n", $data);
        foreach ($aResp as $r) {
            if (empty($r)) {
                continue;
            }
            $d = explode('|', $r);
            if ($table == 'produtos') {
                $aDados[$d[90]] = $d;
            } else {
                $aDados[$d[0]] = $d;
            }
        }
        ksort($aDados);
        $aSql = [];
        $key = 'produtos';
        $arrayStruct = $this->table_prod;
        if ($table == "OP") {
            $key = 'ordens';
            $arrayStruct = $this->table_op;
        }
        $sqlComm = "INSERT INTO $key (";
        foreach($arrayStruct as $fields) {
            $sqlComm .= $fields[0].',';
        }
        $sqlComm = substr($sqlComm, 0, strlen($sqlComm)-1) .  ") VALUES (";
        foreach($aDados as $key => $d) {
            $i = 0;
            $sql = "";
            foreach($d as $f) {
                $value = trim($f);
                $namedestino = $arrayStruct[$i][0];
                $nameorigem = $arrayStruct[$i][1];
                $tipoorigem = $arrayStruct[$i][2];
                $tipodestino = $arrayStruct[$i][3];
                $length = $arrayStruct[$i][4];
                
                $tipo = $tipoorigem;
                if (!empty($tipodestino)) {
                    $tipo = $tipodestino;
                    //deve haver uma conversão
                    $convert = $tipoorigem.'To'. ucfirst($tipodestino);
                    $value = $this->$convert($value);
                } else {
                    if ($tipo == 'float' || $tipo == 'int' || $tipo == 'tinyint' ) {
                        $value = (float) $value;
                        if (empty($value)) {
                            $value = 0;
                        }
                    } elseif ($tipo == 'varchar') {
                        //$value = str_replace([chr(34), chr(39)], '', trim($value));
                        $value = $this->replaceSpecialsChars($value);
                    }
                }    
                $sql .= "'$value',"; 
                $i++;
            }    
            $sql = $sqlComm . substr($sql, 0, strlen($sql)-1) .  ");";
            $aSql[] = $sql;
        }
        return $aSql;
    }
    
    public function pullOp($ini, $fim)
    {
        
        $sqlComm = "SELECT "
            . "op.id, "
            . "op.cliente, "
            . "op.prazo, "
            . "op.nome, "
            . "op.pesototal, "
            . "op.quantidade, "
            . "op.data, "
            . "prod.codigo, "
            . "prod.solda, "
            . "prod.largsaco, "
            . "prod.compsaco, "
            . "prod.espsaco, "
            . "prod.largbob, "
            . "prod.esp1, "
            . "prod.impressao, "
            . "prod.cyrel1, "    
            . "prod.cilindro, "
            . "op.maq, "
            . "op.matriz, "
            . "op.bob, "    
            . "op.mp1q, "
            . "op.mp2q, "
            . "op.mp3q, "
            . "op.mp4q, "
            . "op.mp5q, "
            . "op.mp6q, "
            . "prod.mp1, "
            . "prod.mp2, "
            . "prod.mp3, "
            . "prod.mp4, "
            . "prod.mp5, "
            . "prod.mp6 "
            . "FROM ordens op "
            . "INNER JOIN produtos prod ON prod.nome = op.nome "
            . "WHERE op.fechada = 0 AND op.id >= $ini AND op.id <= $fim;";
        
        $resp = $this->db->query($sqlComm);
        
        $nresp = [];
        foreach($resp as $n => $op) {
            $nresp[$n] = [];
            foreach($op as $key => $value) {
                if (is_numeric($key)) {
                    continue;
                }
                $nresp[$n][$key] = $value;
            }    
        }
        return $nresp;
    }
    
    public function getLastNumOrder()
    {
        $resp = $this->db->query('SELECT max(id) as num FROM ordens');
        if (!empty($resp[0][0])) {
            return $resp[0][0];
        }
        return 0;
    }
    
    public function getLastNumProd()
    {
        $resp = $this->db->query('SELECT max(id) as num FROM produtos');
        if (!empty($resp[0][0])) {
            return $resp[0][0];
        }
        return 0;
    }
    
    public function getCodes()
    {
        $resp = $this->db->query('SELECT DISTINCT codigo FROM products');
        return $resp;
    }
    
    public function saveOrders($sql)
    {
        $this->db->execute($sql);
    }
    
    public function saveProducts($sql)
    {
        $this->db->execute($sql);
    }
    
    public function varcharToFloat($value)
    {
        $value = preg_replace("/[^0-9,.]/", "", $value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return (float) $value;
    }
    
    public function dateToDateTime($value)
    {
        $dt = new DateTime($value);
        return $dt->format('Y-m-d H:i:s');
    }
    
   
    public function createTable($table, $array, $primindex) 
    {
        if ($this->db->tableExists($table)) {
            $this->db->drop($table);
        }
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
        $sqlComm .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        return $this->db->execute($sqlComm);
    }
    
    public function replaceSpecialsChars($string)
    {
        $string = trim($string);
        $aFind = ['&','á','à','ã','â','é','ê','í','ó','ô','õ','ú','ü',
            'ç','Á','À','Ã','Â','É','Ê','Í','Ó','Ô','Õ','Ú','Ü','Ç'];
        $aSubs = ['e','a','a','a','a','e','e','i','o','o','o','u','u',
            'c','A','A','A','A','E','E','I','O','O','O','U','U','C'];
        $newstr = str_replace($aFind, $aSubs, $string);
        $newstr = preg_replace("/[^a-zA-Z0-9 @,-.;:\/]/", "", $newstr);
        return $newstr;
    }    
}
