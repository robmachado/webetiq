<?php

namespace Webetiq;

use Webetiq\DBase\DBase;

class Units
{
    protected $dbase;
    protected $table = 'units';

    /**
     * função construtora
     * instancia a conexão com a base de dados
     * E carrega o array com as unidades com os registros da
     * base de dados, se houverem
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
            "CREATE TABLE `$this->table` (`id` int(11) NOT NULL, `unit` varchar(50) COLLATE utf8_unicode_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Units Table';",
            "ALTER TABLE `$this->table` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unit` (`unit`);",
            "ALTER TABLE `$this->table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;'"
        ];
        $this->dbase->execute($sqlComm);
    }
    
    /**
     * Insere nova unidade na base de dados
     * e no array base
     * @param string $unit
     */
    public function insert($unit)
    {
        $sqlComm = "INSERT INTO $this->table (unit) VALUES ('$unit');";
        return $this->dbase->execute($sqlComm);
    }
    
    /**
     * Retorna a unidade a partir de seu id
     * @param int $id
     * @return string
     */
    public function get($id)
    {
        $unit = '';
        $sqlComm = "SELECT unit FROM $this->table WHERE id='$id';";
        $resp = $this->dbase->query($sqlComm);
        if (!empty($resp)) {
            $unit = $resp[0]['unit'];
        }
        return $unit;
    }
    
    /**
     * Busca e retorna as unidades e seus ids
     * @return array
     */
    public function all()
    {
        $sqlComm = "SELECT * FROM $this->table ORDER BY unit;";
        $resp = $this->dbase->query($sqlComm);
        if (!empty($resp)) {
            $aUnit = array();
            foreach ($resp as $row) {
                $id = $row['id'];
                $unidade = $row['unit'];
                $aUnit[$id] = $unidade;
            }
        }
        return $aUnit;
    }
    
    public function delete()
    {
        
    }
       
    /**
     * Grava as unidades padrões na tabela da base de dados
     */
    public function pushDefault()
    {
        $aUnit = [
            1 => "pcs",
            2 => "cen",
            3 => "mil",
            4 => "kg",
            5 => "m",
            6 => "m²",
            7 => "bob",
            8 => "cj"
        ];
        $this->dbase->truncate($this->table);
        foreach ($aUnit as $unidade) {
            $this->insert($unidade);
        }
    }
}
