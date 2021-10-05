<?php
namespace Webetiq\Barcode;

class Barcode
{

    public static function gd($res, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null)
    {
        return self::draw(__FUNCTION__, $res, $color, $x, $y, $angle, $type, $datas, $width, $height);
    }

    public static function fpdf($res, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null)
    {
        return self::draw(__FUNCTION__, $res, $color, $x, $y, $angle, $type, $datas, $width, $height);
    }

    private static function draw($call, $res, $color, $x, $y, $angle, $type, $datas, $width, $height)
    {
        $digit = '';
        $hri   = '';
        $code  = '';
        $crc   = true;
        $rect  = false;
        $b2d   = false;
        if (is_array($datas)) {
            foreach(array('code' => '', 'crc' => true, 'rect' => false) as $v => $def){
                $$v = isset($datas[$v]) ? $datas[$v] : $def;
            }
            $code = $code;
        } else {
            $code = $datas;
        }
        if ($code == '') return false;
        $code = (string) $code;

        $type = strtolower($type);

        switch($type){
            case 'std25':
            case 'int25':
                $digit = BarcodeI25::getDigit($code, $crc, $type);
                $hri = BarcodeI25::compute($code, $crc, $type);
                break;
            case 'ean8':
            case 'ean13':
                $digit = BarcodeEAN::getDigit($code, $type);
                $hri = BarcodeEAN::compute($code, $type);
                break;
            case 'upc':
                $digit = BarcodeUPC::getDigit($code);
                $hri = BarcodeUPC::compute($code);
                break;
            case 'code11':
                $digit = Barcode11::getDigit($code);
                $hri = $code;
                break;
            case 'code39':
                $digit = Barcode39::getDigit($code);
                $hri = $code;
                break;
            case 'code93':
                $digit = Barcode93::getDigit($code, $crc);
                $hri = $code;
                break;
            case 'code128':
                $digit = Barcode128::getDigit($code);
                $hri = $code;
                break;
            case 'codabar':
                $digit = BarcodeCodabar::getDigit($code);
                $hri = $code;
                break;
            case 'msi':
                $digit = BarcodeMSI::getDigit($code, $crc);
                $hri = BarcodeMSI::compute($code, $crc);
                break;
            case 'datamatrix':
                $digit = BarcodeDatamatrix::getDigit($code, $rect);
                $hri = $code;
                $b2d = true;
                break;
        }

        if ($digit == '') return false;

        if ( $b2d ){
            $width = is_null($width) ? 5 : $width;
            $height = $width;
        } else {
            $width = is_null($width) ? 1 : $width;
            $height = is_null($height) ? 50 : $height;
            $digit = self::bitStringTo2DArray($digit);
        }

        if ( $call == 'gd' ){
            $result = self::digitToGDRenderer($res, $color, $x, $y, $angle, $width, $height, $digit);
        } else if ( $call == 'fpdf' ){
            $result = self::digitToFPDFRenderer($res, $color, $x, $y, $angle, $width, $height, $digit);
        }

        $result['hri'] = $hri;
        return $result;
    }

    // convert a bit string to an array of array of bit char
    private static function bitStringTo2DArray( $digit ){
        $d = array();
        $len = strlen($digit);
        for($i=0; $i<$len; $i++) $d[$i] = $digit[$i];
        return(array($d));
    }

    private static function digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit){
        $lines = count($digit);
        $columns = count($digit[0]);
        $angle = deg2rad(-$angle);
        $cos = cos($angle);
        $sin = sin($angle);

        self::_rotate($columns * $mw / 2, $lines * $mh / 2, $cos, $sin , $x, $y);
        $xi -=$x;
        $yi -=$y;
        for($y=0; $y<$lines; $y++){
            $x = -1;
            while($x <$columns) {
                $x++;
                if ($digit[$y][$x] == '1') {
                    $z = $x;
                    while(($z + 1 <$columns) && ($digit[$y][$z + 1] == '1')) {
                        $z++;
                    }
                    $x1 = $x * $mw;
                    $y1 = $y * $mh;
                    $x2 = ($z + 1) * $mw;
                    $y2 = ($y + 1) * $mh;
                    self::_rotate($x1, $y1, $cos, $sin, $xA, $yA);
                    self::_rotate($x2, $y1, $cos, $sin, $xB, $yB);
                    self::_rotate($x2, $y2, $cos, $sin, $xC, $yC);
                    self::_rotate($x1, $y2, $cos, $sin, $xD, $yD);
                    $fn(array(
                        $xA + $xi, $yA + $yi,
                        $xB + $xi, $yB + $yi,
                        $xC + $xi, $yC + $yi,
                        $xD + $xi, $yD + $yi
                    ));
                    $x = $z + 1;
                }
            }
        }
        return self::result($xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin);
    }

    // GD barcode renderer
    private static function digitToGDRenderer($gd, $color, $xi, $yi, $angle, $mw, $mh, $digit){
        $fn = function($points) use ($gd, $color) {
            imagefilledpolygon($gd, $points, 4, $color);
        };
        return self::digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit);
    }
    // FPDF barcode renderer
    private static function digitToFPDFRenderer($pdf, $color, $xi, $yi, $angle, $mw, $mh, $digit){
        if (!is_array($color)){
            if (preg_match('`([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})`i', $color, $m)){
                $color = array(hexdec($m[1]),hexdec($m[2]),hexdec($m[3]));
            } else {
                $color = array(0,0,0);
            }
        }
        $color = array_values($color);
        $pdf->SetDrawColor($color[0],$color[1],$color[2]);
        $pdf->SetFillColor($color[0],$color[1],$color[2]);

        $fn = function($points) use ($pdf) {
            $op = 'f';
            $h = $pdf->h;
            $k = $pdf->k;
            $points_string = '';
            for($i=0; $i < 8; $i+=2){
                $points_string .= sprintf('%.2F %.2F', $points[$i]*$k, ($h-$points[$i+1])*$k);
                $points_string .= $i ? ' l ' : ' m ';
            }
            $pdf->_out($points_string . $op);
        };
        return self::digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit);
    }

    static private function result($xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin){
        self::_rotate(0, 0, $cos, $sin , $x1, $y1);
        self::_rotate($columns * $mw, 0, $cos, $sin , $x2, $y2);
        self::_rotate($columns * $mw, $lines * $mh, $cos, $sin , $x3, $y3);
        self::_rotate(0, $lines * $mh, $cos, $sin , $x4, $y4);

        return array(
            'width' => $columns * $mw,
            'height'=> $lines * $mh,
            'p1' => array(
                'x' => $xi + $x1,
                'y' => $yi + $y1
            ),
            'p2' => array(
                'x' => $xi + $x2,
                'y' => $yi + $y2
            ),
            'p3' => array(
                'x' => $xi + $x3,
                'y' => $yi + $y3
            ),
            'p4' => array(
                'x' => $xi + $x4,
                'y' => $yi + $y4
            )
        );
    }

    static private function _rotate($x1, $y1, $cos, $sin , &$x, &$y){
        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }

    public static function rotate($posX1, $posY1, $angle , &$posX, &$posY)
    {
        $angle = deg2rad(-$angle);
        $cos = cos($angle);
        $sin = sin($angle);
        $posX = $posX1 * $cos - $posY1 * $sin;
        $posY = $posX1 * $sin + $posY1 * $cos;
    }
}
