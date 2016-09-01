<?php

namespace Webetiq\Printers;

class Printer
{
    /**
     * Id da printer na base de dados
     * @var int
     */
    public $printId = 0;
    /**
     * Nome da impressora no cadastro -> Unique Key
     * @var string
     */
    public $printName = '';
    /**
     * Tipo de impressora
     * T termica, D deskjet, L laser, S sublimação
     * @var string
     */
    public $printType = '';
    /**
     * Descrição da impressora
     * @var string
     */
    public $printDesc = '';
    /**
     * Printer IP para uso de impressão por IPP
     * @var string
     */
    public $printIP = '';
    /**
     * Linguagem da impressora
     * Para definir o template a ser usado
     * @var string
     */
    public $printLang = '';
    /**
     * Interface de comunicação a ser usada
     * LPR, IPP, Local(QZ)
     * @var string
     */
    public $printInterface = '';
    /**
     * Flag de bloqueio para impedir o uso
     * usado em fase de manutenção da impressora
     * @var bool
     */
    public $printBlock = 0;    
}
