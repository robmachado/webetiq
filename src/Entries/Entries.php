<?php

namespace Webetiq\Entries;

use Webetiq\DBase\DBase;
use stdClass;
use Webetiq\DateTime\DateTime;

class Entries
{
    private $dbase;
    
    public function __construct()
    {
        $config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'legacy']);
        $this->dbase = new DBase($config);
    }
    
    public function getMaquinas($data)
    {
        $filter = '';
        if (!empty($data)) {
            $dt = DateTime::toDate($data);
            $sqlComm = "SELECT DISTINCT maq FROM apontamentos WHERE data='$dt' ORDER BY maq;";
            $rsp = $this->dbase->query($sqlComm);
            if (!empty($rsp)) {
                foreach ($rsp as $r) {
                    $a[] = "'" . $r['maq'] . "'";
                }
                $filter = ' WHERE maq NOT IN ('.implode(',',$a).')';
            }
        }
        $sqlComm = "SELECT * FROM maquinas $filter ORDER BY maq;";
        return $this->dbase->query($sqlComm);
    }
    
    
    public function getCodParadas()
    {
        $sqlComm = "SELECT * FROM motivoparada ORDER BY id;";
        return $this->dbase->query($sqlComm);
    }
    
    public function getAll($maq, $dia)
    {
        $sqlComm = "SELECT ap.*, pa.descricao FROM apontamentos ap INNER JOIN motivoparada pa ON ap.parada = pa.id "
            . "WHERE ap.maq='$maq' AND ap.data='$dia' ORDER BY ap.shifttimeini";
        $resp = $this->dbase->query($sqlComm);
        $r = [];
        $tot = 0;
        foreach ($resp as $d) {
            $minF = DateTime::convertShiftModeToDec($d['shifttimefim']);
            $minI = DateTime::convertShiftModeToDec($d['shifttimeini']);
            //$dif = $minF-$minI;
            $dif = ($d['shifttimefim']-$d['shifttimeini']) * 60;
            
            $tot += $dif;
            $hIn = DateTime::convertDecToTime($minI);
            $hOut = DateTime::convertDecToTime($minF);
            $cod = $d['parada'].'-'.$d['descricao'];
            $op = $d['numop'];
            $r[] = [
                'maq' => $d['maq'],
                'hIn' => $hIn,
                'hOut' => $hOut,
                'dif' => $dif,
                'cod' => $cod,
                'op' => $op
            ];
        }
        return ['totmin'=> $tot, 'lanc' => $r];
    }
    
    public function save(stdClass $std)
    {
        //maq,data,shifttimeini,shifttimefim,turno,parada,numop,qtd,uni,fator,setup,ops,velocidade,refile,aparas
        $sqlComm = "INSERT INTO apontamentos ("
            . "maq,data,shifttimeini,shifttimefim,turno,parada";
        if (!empty($std->numop)) {    
            $sqlComm .= ",numop,qtd,uni,fator,setup,ops,velocidade,refile,aparas";
        }
        $sqlComm .= ") VALUES ("
            . "'$std->maq',"
            . "'$std->data',"
            . "'$std->shifttimeini',"
            . "'$std->shifttimefim',"
            . "'$std->turno',"
            . "'$std->parada'";
        if (!empty($std->numop)) {    
            $sqlComm .= ",'$std->numop',"
                . "'$std->qtd',"
                . "'$std->uni',"
                . "'$std->fator',"
                . "'$std->setup',"
                . "'$std->ops',"
                . "'$std->velocidade',"
                . "'$std->refile',"
                . "'$std->aparas'";
        }
        $sqlComm .= ");";    
        if (!$this->dbase->execute($sqlComm)) {
            return "Não gravou DUPLICIDADE de dados.";
        }
        return "";
    }
}
