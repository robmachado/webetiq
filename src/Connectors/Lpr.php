<?php

namespace Webetiq\Connectors;

/**
 * Description of Lpr
 *
 * @author administrador
 */
class Lpr
{
    public $printer;
    public $filename;
    
    public function send()
    {
        $retorno = '';
        $comando = "lpr -P $this->printer $this->filename";
        // envia para impressora
        system($comando, $retorno);
        //apagar arquivo temporario
        unlink($this->filename);
        return $retorno;
    }
}
