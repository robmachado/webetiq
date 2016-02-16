<?php

namespace Webetiq\Connectors;

/**
 * Description of Qz
 *
 * @author administrador
 */
class Qz
{
    public function encode($data)
    {
        return base64_encode($data);
    }
}
