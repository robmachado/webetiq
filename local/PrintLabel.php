<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrintLabel
 *
 * @author administrador
 */
class PrintLabel
{
    public $printer = '';
    
    public function __construct()
    {
        
    }
    
    public function setPrinter()
    {
        
    }
    
    public function send($data)
    {
        // grava o arquivo temporário
        $filetemp = dirname(__FILE__) .
            DIRECTORY_SEPARATOR .
            substr(str_replace(',', '', number_format(microtime(true)*1000000, 0)), 0, 15).'.prn';
        
        if (file_put_contents($filetemp, $data)) {
            $msg = "OK!";
            //prepara a impressão
            //$comando = "lpr -P $printer $filetemp";
            // envia para impressora
            //system($comando, $retorno);
            //apagar arquivo temporario
            //unlink($filetemp);
        } else {
            $msg = "Falha da gravação do arquivo temporário. Verifique as permissões!";
        }
        return $msg;
    }
}
