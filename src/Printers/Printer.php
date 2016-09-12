<?php

namespace Webetiq\Printers;

class Printer
{
    /**
     * Id da printer na base de dados
     * @var int
     */
    public $id = 0;
    /**
     * Nome da impressora no cadastro -> Unique Key
     * @var string
     */
    public $name = '';
    /**
     * Tipo de impressora
     * T termica, D deskjet, L laser, S sublimação
     * @var string
     */
    public $type = '';
    /**
     * Descrição da impressora
     * @var string
     */
    public $description = '';
    /**
     * Printer IP para uso de impressão por IPP
     * @var string
     */
    public $location = '';
    /**
     * Linguagem da impressora
     * Para definir o template a ser usado
     * @var string
     */
    public $language = '';
    /**
     * Interface de comunicação a ser usada
     * LPR, IPP, Local(QZ)
     * @var string
     */
    public $interface = '';
}
