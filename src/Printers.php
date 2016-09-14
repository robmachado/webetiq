<?php

namespace Webetiq;

use Webetiq\DBase\DBase;
use Webetiq\Printer;

class Printers
{
    private $dbase;
    private $table = 'printers';
    
    /**
     * Construtora, instancia classe de acesso a base de dados
     * e se receber um nome de impressora procura e carrega os dados
     * @param string $printName
     */
    public function __construct(DBase $dbase)
    {
        $this->dbase = $dbase;
        $this->dbase->connect();
        if (! $this->dbase->tableExists($this->table)) {
            $this->create();
            $this->pushDefault();
        }
    }
    
    public function create()
    {
        $sqlComm = [
            "CREATE TABLE `$this->table` (`id` int(11) NOT NULL,`name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,`type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,`language` varchar(20) COLLATE utf8_unicode_ci NOT NULL,`interface` varchar(20) COLLATE utf8_unicode_ci NOT NULL,`location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,`description` varchar(200) COLLATE utf8_unicode_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Printers Table';",
            "ALTER TABLE `$this->table` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);",
            "ALTER TABLE `$this->table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
        ];
        $this->dbase->execute($sqlComm);
    }
    
    public function pushDefault()
    {
        $print = new Printer();
        $print->name = 'newZebra';
        $print->type = 'Thermal';
        $print->location = '192.168.0.1';
        $print->description = 'Zebra Z230';
        $print->interface = 'file';
        $print->language = 'ZPL2';
        
        $aP = [
            0 => $print
        ];
        $this->dbase->truncate($this->table);
        foreach ($aP as $printer) {
            $this->insert($printer);
        }
    }
    
    public function update(Printer $printer)
    {
        if ($printer->id == 0) {
            return false;
        }
        $fields = get_object_vars($printer);
        $fields = array_slice($fields, 1, count($fields)-1);
        $sqlComm = "UPDATE $this->table SET ";
        foreach($fields as $key => $value) {
            $sqlComm .= "$key = '$value',";
        }
        $sqlComm = substr($sqlComm, 0, strlen($sqlComm)-1)." ";
        $sqlComm .= "WHERE id = $printer->id";
        return $this->dbase->execute($sqlComm);
    }
    
    public function insert(Printer $printer)
    {
        $fields = get_object_vars($printer);
        $fields = array_slice($fields, 1, count($fields)-1);
        $sqlComm = "INSERT INTO $this->table (";
        $x = 0;
        $fldstr = '';
        $vlestr = '';
        foreach($fields as $key => $value) {
            $fldstr .= "$key,"; 
            $vlestr .= "'$value',";
        }
        $sqlComm .= substr($fldstr, 0, strlen($fldstr)-1);
        $sqlComm .= ") VALUES (";
        $sqlComm .= substr($vlestr, 0, strlen($vlestr)-1);
        $sqlComm .= ");";
        return $this->dbase->execute($sqlComm);
    }
    
    public function delete(Printer $printer)
    {
        $sqlComm = "DELETE FROM $this->table WHERE id = $printer->id;";
        return $this->dbase->query($sqlComm);
    }
    
    /**
     * Carrega o nome de todas as impressoras
     * @return array
     */
    public function all()
    {
        $sqlComm = "SELECT * FROM $this->table ORDER BY name";
        $dados = $this->dbase->query($sqlComm);
        if (! is_array($dados)) {
            return '';
        }
        $aPrinters = [];
        foreach ($dados as $printer) {
            $aPrinters[] = $this->loadFields($printer);
        }
        return $aPrinters;
    }
    
    /**
     * Obtem os dados da impressora
     * e carrega os parametros da classe
     * @return Printer
     */
    public function get($search)
    {
        if ($search == '') {
            return '';
        }
        $sqlComm = "SELECT * FROM $this->table WHERE name='$search'";
        $dados = $this->dbase->query($sqlComm);
        $print = new Printer();
        foreach ($dados as $printer) {
            $print = $this->loadFields($printer);
        }
        return $print;
    }
    
    /**
     * Load Printer Class
     * @param array $dados
     * @return Printer
     */
    private function loadFields($dados)
    {
        $p = new Printer();
        foreach ($dados as $key => $field) {
            if (!is_numeric($key)) {
                $p->$key = $field;
            }
        }
        return $p;
    }
}
