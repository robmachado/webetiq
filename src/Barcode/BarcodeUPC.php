<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BarcodeUPC
 *
 * @author administrador
 */
class BarcodeUPC {

    static public function getDigit($code){
        if (strlen($code) < 12) {
            $code = '0' . $code;
        }
        return BarcodeEAN::getDigit($code, 'ean13');
    }

    static public function compute($code){
        if (strlen($code) < 12) {
            $code = '0' . $code;
        }
        return substr(BarcodeEAN::compute($code, 'ean13'), 1);
    }
}

