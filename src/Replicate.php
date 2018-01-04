<?php

namespace Webetiq;

use Webetiq\DBase\DBase;

class Replicate
{
    public function __construct(DBase $dbase)
    {
        $this->dbase = $dbase;
        $this->storagePath = __DIR__ . DIRECTORY_SEPARATOR . '../storage/';
    }
    
    public function createOP()
    {
        $sqlComm = "CREATE TABLE `OP` (
            `id` int(11) NOT NULL,
            `numop` int(11) NOT NULL,
            `cliente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
            `codcli` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pedido` int(11) DEFAULT NULL,
            `prazo` datetime DEFAULT NULL,
            `produto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `codigo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `nummaq` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
            `matriz` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
            `kg1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg1ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg2ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg3` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg3ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg4` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg4ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg5` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg5ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg6` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `kg6ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pesototal` float DEFAULT NULL,
            `pesomilheiro` float DEFAULT NULL,
            `pesobobina` float DEFAULT NULL,
            `quantidade` float DEFAULT NULL,
            `bolbobinas` int(11) DEFAULT NULL,
            `dataemissao` datetime DEFAULT NULL,
            `metragem` int(11) DEFAULT NULL,
            `contadordif` int(11) DEFAULT NULL,
            `isobobinas` int(11) DEFAULT NULL,
            `pedcli` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
            `unidade` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    }
    
    public function insertOP()
    {
        
    }
    
    public function insertProduto()
    {
        
    }
}
