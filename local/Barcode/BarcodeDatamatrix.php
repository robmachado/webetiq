<?php
namespace Webetiq\Barcode;

/**
 * Description of BarcodeDatamatrix
 *
 * @author administrador
 */
class BarcodeDatamatrix
{
    private static $lengthRows = array(
        10, 12, 14, 16, 18, 20, 22, 24, 26,  // 24 squares et 6 rectangular
        32, 36, 40, 44, 48, 52, 64, 72, 80,  88, 96, 104, 120, 132, 144,
        8, 8, 12, 12, 16, 16);
    private static $lengthCols = array(
        10, 12, 14, 16, 18, 20, 22, 24, 26,  // Number of columns for the entire datamatrix
        32, 36, 40, 44, 48, 52, 64, 72, 80, 88, 96, 104, 120, 132, 144,
        18, 32, 26, 36, 36, 48);
    private static $dataCWCount = array(
        3, 5, 8, 12,  18,  22,  30,  36,  // Number of data codewords for the datamatrix
        44, 62, 86, 114, 144, 174, 204, 280, 368, 456, 576, 696, 816, 1050,
        1304, 1558, 5, 10, 16, 22, 32, 49);
    private static $solomonCWCount = array(
        5, 7, 10, 12, 14, 18, 20, 24, 28, // Number of Reed-Solomon codewords for the datamatrix
        36, 42, 48, 56, 68, 84, 112, 144, 192, 224, 272, 336, 408, 496, 620,
        7, 11, 14, 18, 24, 28);
    private static $dataRegionRows = array(
        8, 10, 12, 14, 16, 18, 20, 22, // Number of rows per region
        24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22,
        6,  6, 10, 10, 14, 14);
    private static $dataRegionCols = array(
        8, 10, 12, 14, 16, 18, 20, 22, // Number of columns per region
        24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22,
        16, 14, 24, 16, 16, 22);
    private static $regionRows = array(
        1, 1, 1, 1, 1, 1, 1, 1, // Number of regions per row
        1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6,
        1, 1, 1, 1, 1, 1);
    private static $regionCols = array(
        1, 1, 1, 1, 1, 1, 1, 1, // Number of regions per column
        1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6,
        1, 2, 1, 2, 2, 2);
    private static $interleavedBlocks = array(
        1, 1, 1, 1, 1, 1, 1, 1, // Number of blocks
        1, 1, 1, 1, 1, 1, 2, 2, 4, 4, 4, 4, 6, 6, 8, 8,
        1, 1, 1, 1, 1, 1);
    private static $logTab = array(
        -255, 255, 1, 240, 2, 225, 241, 53, 3,  // Table of log for the Galois field
        38, 226, 133, 242, 43, 54, 210, 4, 195, 39, 114, 227, 106, 134, 28,
        243, 140, 44, 23, 55, 118, 211, 234, 5, 219, 196, 96, 40, 222, 115,
        103, 228, 78, 107, 125, 135, 8, 29, 162, 244, 186, 141, 180, 45, 99,
        24, 49, 56, 13, 119, 153, 212, 199, 235, 91, 6, 76, 220, 217, 197,
        11, 97, 184, 41, 36, 223, 253, 116, 138, 104, 193, 229, 86, 79, 171,
        108, 165, 126, 145, 136, 34, 9, 74, 30, 32, 163, 84, 245, 173, 187,
        204, 142, 81, 181, 190, 46, 88, 100, 159, 25, 231, 50, 207, 57, 147,
        14, 67, 120, 128, 154, 248, 213, 167, 200, 63, 236, 110, 92, 176, 7,
        161, 77, 124, 221, 102, 218, 95, 198, 90, 12, 152, 98, 48, 185, 179,
        42, 209, 37, 132, 224, 52, 254, 239, 117, 233, 139, 22, 105, 27, 194,
        113, 230, 206, 87, 158, 80, 189, 172, 203, 109, 175, 166, 62, 127,
        247, 146, 66, 137, 192, 35, 252, 10, 183, 75, 216, 31, 83, 33, 73,
        164, 144, 85, 170, 246, 65, 174, 61, 188, 202, 205, 157, 143, 169, 82,
        72, 182, 215, 191, 251, 47, 178, 89, 151, 101, 94, 160, 123, 26, 112,
        232, 21, 51, 238, 208, 131, 58, 69, 148, 18, 15, 16, 68, 17, 121, 149,
        129, 19, 155, 59, 249, 70, 214, 250, 168, 71, 201, 156, 64, 60, 237,
        130, 111, 20, 93, 122, 177, 150);
    private static $aLogTab = array(
        1, 2, 4, 8, 16, 32, 64, 128, 45, 90, // Table of aLog for the Galois field
        180, 69, 138, 57, 114, 228, 229, 231, 227, 235, 251, 219, 155, 27, 54,
        108, 216, 157, 23, 46, 92, 184, 93, 186, 89, 178, 73, 146, 9, 18, 36,
        72, 144, 13, 26, 52, 104, 208, 141, 55, 110, 220, 149, 7, 14, 28, 56,
        112, 224, 237, 247, 195, 171, 123, 246, 193, 175, 115, 230, 225, 239,
        243, 203, 187, 91, 182, 65, 130, 41, 82, 164, 101, 202, 185, 95, 190,
        81, 162, 105, 210, 137, 63, 126, 252, 213, 135, 35, 70, 140, 53, 106,
        212, 133, 39, 78, 156, 21, 42, 84, 168, 125, 250, 217, 159, 19, 38, 76,
        152, 29, 58, 116, 232, 253, 215, 131, 43, 86, 172, 117, 234, 249, 223,
        147, 11, 22, 44, 88, 176, 77, 154, 25, 50, 100, 200, 189, 87, 174, 113,
        226, 233, 255, 211, 139, 59, 118, 236, 245, 199, 163, 107, 214, 129,
        47, 94, 188, 85, 170, 121, 242, 201, 191, 83, 166, 97, 194, 169, 127,
        254, 209, 143, 51, 102, 204, 181, 71, 142, 49, 98, 196, 165, 103, 206,
        177, 79, 158, 17, 34, 68, 136, 61, 122, 244, 197, 167, 99, 198, 161,
        111, 222, 145, 15, 30, 60, 120, 240, 205, 183, 67, 134, 33, 66, 132,
        37, 74, 148, 5, 10, 20, 40, 80, 160, 109, 218, 153, 31, 62, 124, 248,
        221, 151, 3, 6, 12, 24, 48, 96, 192, 173, 119, 238, 241, 207, 179, 75,
        150, 1);

    private static function champGaloisMult($a, $b)
    {  // MULTIPLICATION IN GALOIS FIELD GF(2^8)
        if(!$a || !$b) return 0;
        return self::$aLogTab[(self::$logTab[$a] + self::$logTab[$b]) % 255];
    }
    
    private static function champGaloisDoub($a, $b)
    {  // THE OPERATION a * 2^b IN GALOIS FIELD GF(2^8)
        if (!$a) return 0;
        if (!$b) return $a;
        return self::$aLogTab[(self::$logTab[$a] + $b) % 255];
    }
    
    private static function champGaloisSum($a, $b)
    { // SUM IN GALOIS FIELD GF(2^8)
        return $a ^ $b;
    }

    private static function selectIndex($dataCodeWordsCount, $rectangular)
    { // CHOOSE THE GOOD INDEX FOR TABLES
        if (($dataCodeWordsCount<1 || $dataCodeWordsCount>1558) && !$rectangular) return -1;
        if (($dataCodeWordsCount<1 || $dataCodeWordsCount>49) && $rectangular)  return -1;

        $n = $rectangular ? 24 : 0;

        while (self::$dataCWCount[$n] < $dataCodeWordsCount) $n++;
        return $n;
    }
    
    private static function encodeDataCodeWordsASCII($text)
    {
        $dataCodeWords = array();
        $n = 0;
        $len = strlen($text);
        for ($i=0; $i<$len; $i++) {
            $c = ord($text[$i]);
            if ($c > 127) {
                $dataCodeWords[$n] = 235;
                $c -= 127;
                $n++;
            } else if (($c>=48 && $c<=57) && ($i+1<$len) && (preg_match('`[0-9]`', $text[$i+1]))) {
                $c = (($c - 48) * 10) + intval($text[$i+1]);
                $c += 130;
                $i++;
            } else $c++;
            $dataCodeWords[$n] = $c;
            $n++;
        }
        return $dataCodeWords;
    }

    private static function addPadCW(&$tab, $from, $to)
    {
        if ($from >= $to) return ;
        $tab[$from] = 129;
        for ($i=$from+1; $i<$to; $i++){
            $r = ((149 * ($i+1)) % 253) + 1;
            $tab[$i] = (129 + $r) % 254;
        }
    }

    private static function calculSolFactorTable($solomonCWCount)
    { // CALCULATE THE REED SOLOMON FACTORS
        $g = array_fill(0, $solomonCWCount+1, 1);
        for($i = 1; $i <= $solomonCWCount; $i++) {
            for($j = $i - 1; $j >= 0; $j--) {
                $g[$j] = self::champGaloisDoub($g[$j], $i);
                if($j > 0) $g[$j] = self::champGaloisSum($g[$j], $g[$j-1]);
            }
        }
        return $g;
    }

    private static function addReedSolomonCW($nSolomonCW, $coeffTab, $nDataCW, &$dataTab, $blocks)
    { // Add the Reed Solomon codewords
        $errorBlocks = $nSolomonCW / $blocks;
        $correctionCW = array();

        for($k = 0; $k < $blocks; $k++) {
            for ($i=0; $i < $errorBlocks; $i++) $correctionCW[$i] = 0;

            for ($i=$k; $i<$nDataCW; $i+=$blocks){
                $temp = self::champGaloisSum($dataTab[$i], $correctionCW[$errorBlocks-1]);
                for ($j=$errorBlocks-1; $j>=0; $j--){
                    if ( !$temp ) {
                        $correctionCW[$j] = 0;
                    } else {
                        $correctionCW[$j] = self::champGaloisMult($temp, $coeffTab[$j]);
                    }
                    if ($j>0) $correctionCW[$j] = self::champGaloisSum($correctionCW[$j-1], $correctionCW[$j]);
                }
            }
            // Renversement des blocs calcules
            $j = $nDataCW + $k;
            for ($i=$errorBlocks-1; $i>=0; $i--){
                $dataTab[$j] = $correctionCW[$i];
                $j=$j+$blocks;
            }
        }
        return $dataTab;
    }
    private static function getBits($entier){ // Transform integer to tab of bits
        $bits = array();
        for ($i=0; $i<8; $i++){
            $bits[$i] = $entier & (128 >> $i) ? 1 : 0;
        }
        return $bits;
    }
    private static function next($etape, $totalRows, $totalCols, $codeWordsBits, &$datamatrix, &$assigned){ // Place codewords into the matrix
        $chr = 0; // Place of the 8st bit from the first character to [4][0]
        $row = 4;
        $col = 0;

        do {
            // Check for a special case of corner
            if(($row == $totalRows) && ($col == 0)){
                self::patternShapeSpecial1($datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols);
                $chr++;
            } else if(($etape<3) && ($row == $totalRows-2) && ($col == 0) && ($totalCols%4 != 0)){
                self::patternShapeSpecial2($datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols);
                $chr++;
            } else if(($row == $totalRows-2) && ($col == 0) && ($totalCols%8 == 4)){
                self::patternShapeSpecial3($datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols);
                $chr++;
            }
            else if(($row == $totalRows+4) && ($col == 2) && ($totalCols%8 == 0)){
                self::patternShapeSpecial4($datamatrix, $assigned, $codeWordsBits[$chr], $totalRows, $totalCols);
                $chr++;
            }

            // Go up and right in the datamatrix
            do {
                if(($row < $totalRows) && ($col >= 0) && (!isset($assigned[$row][$col]) || $assigned[$row][$col]!=1)) {
                    self::patternShapeStandard($datamatrix, $assigned, $codeWordsBits[$chr], $row, $col, $totalRows, $totalCols);
                    $chr++;
                }
                $row -= 2;
                $col += 2;
            } while (($row >= 0) && ($col < $totalCols));
            $row += 1;
            $col += 3;

            // Go down and left in the datamatrix
            do {
                if(($row >= 0) && ($col < $totalCols) && (!isset($assigned[$row][$col]) || $assigned[$row][$col]!=1)){
                    self::patternShapeStandard($datamatrix, $assigned, $codeWordsBits[$chr], $row, $col, $totalRows, $totalCols);
                    $chr++;
                }
                $row += 2;
                $col -= 2;
            } while (($row < $totalRows) && ($col >=0));
            $row += 3;
            $col += 1;
        } while (($row < $totalRows) || ($col < $totalCols));
    }
    private static function patternShapeStandard(&$datamatrix, &$assigned, $bits, $row, $col, $totalRows, $totalCols){ // Place bits in the matrix (standard or special case)
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[0], $row-2, $col-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[1], $row-2, $col-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[2], $row-1, $col-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[3], $row-1, $col-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[4], $row-1, $col, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[5], $row, $col-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[6], $row, $col-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[7], $row, $col, $totalRows, $totalCols);
    }
    private static function patternShapeSpecial1(&$datamatrix, &$assigned, $bits, $totalRows, $totalCols ){
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[0], $totalRows-1,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[1], $totalRows-1,  1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[2], $totalRows-1,  2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[3], 0, $totalCols-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[4], 0, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[5], 1, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[6], 2, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[7], 3, $totalCols-1, $totalRows, $totalCols);
    }
    private static function patternShapeSpecial2(&$datamatrix, &$assigned, $bits, $totalRows, $totalCols ){
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[0], $totalRows-3,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[1], $totalRows-2,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[2], $totalRows-1,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[3], 0, $totalCols-4, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[4], 0, $totalCols-3, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[5], 0, $totalCols-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[6], 0, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[7], 1, $totalCols-1, $totalRows, $totalCols);
    }
    private static function patternShapeSpecial3(&$datamatrix, &$assigned, $bits, $totalRows, $totalCols ){
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[0], $totalRows-3,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[1], $totalRows-2,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[2], $totalRows-1,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[3], 0, $totalCols-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[4], 0, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[5], 1, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[6], 2, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[7], 3, $totalCols-1, $totalRows, $totalCols);
    }
    private static function patternShapeSpecial4(&$datamatrix, &$assigned, $bits, $totalRows, $totalCols ){
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[0], $totalRows-1,  0, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[1], $totalRows-1, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[2], 0, $totalCols-3, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[3], 0, $totalCols-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[4], 0, $totalCols-1, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[5], 1, $totalCols-3, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[6], 1, $totalCols-2, $totalRows, $totalCols);
        self::placeBitInDatamatrix($datamatrix, $assigned, $bits[7], 1, $totalCols-1, $totalRows, $totalCols);
    }
    private static function placeBitInDatamatrix(&$datamatrix, &$assigned, $bit, $row, $col, $totalRows, $totalCols){ // Put a bit into the matrix
        if ($row < 0) {
            $row += $totalRows;
            $col += 4 - (($totalRows+4)%8);
        }
        if ($col < 0) {
            $col += $totalCols;
            $row += 4 - (($totalCols+4)%8);
        }
        if (!isset($assigned[$row][$col]) || $assigned[$row][$col] != 1) {
            $datamatrix[$row][$col] = $bit;
            $assigned[$row][$col] = 1;
        }
    }
    
    private static function addFinderPattern($datamatrix, $rowsRegion, $colsRegion, $rowsRegionCW, $colsRegionCW)
    {
        // Add the finder pattern
        $totalRowsCW = ($rowsRegionCW+2) * $rowsRegion;
        $totalColsCW = ($colsRegionCW+2) * $colsRegion;
        $datamatrixTemp = array();
        $datamatrixTemp[0] = array_fill(0, $totalColsCW+2, 0);
        for ($i=0; $i<$totalRowsCW; $i++) {
            $datamatrixTemp[$i+1] = array();
            $datamatrixTemp[$i+1][0] = 0;
            $datamatrixTemp[$i+1][$totalColsCW+1] = 0;
            for ($j=0; $j<$totalColsCW; $j++) {
                if ($i%($rowsRegionCW+2) == 0) {
                    if ($j%2 == 0) {
                        $datamatrixTemp[$i+1][$j+1] = 1;
                    } else {
                        $datamatrixTemp[$i+1][$j+1] = 0;
                    }
                } else if ($i%($rowsRegionCW+2) == $rowsRegionCW+1) {
                    $datamatrixTemp[$i+1][$j+1] = 1;
                } else if ($j%($colsRegionCW+2) == $colsRegionCW+1) {
                    if ($i%2 == 0) {
                        $datamatrixTemp[$i+1][$j+1] = 0;
                    } else {
                        $datamatrixTemp[$i+1][$j+1] = 1;
                    }
                } else if ($j%($colsRegionCW+2) == 0) {
                    $datamatrixTemp[$i+1][$j+1] = 1;
                } else {
                    $datamatrixTemp[$i+1][$j+1] = 0;
                    $datamatrixTemp[$i+1][$j+1] = $datamatrix[$i-1-(2*(floor($i/($rowsRegionCW+2))))][$j-1-(2*(floor($j/($colsRegionCW+2))))]; // todo : parseInt => ?
                }
            }
        }
        $datamatrixTemp[$totalRowsCW+1] = array();
        for ($j=0; $j<$totalColsCW+2; $j++){
            $datamatrixTemp[$totalRowsCW+1][$j] = 0;
        }
        return $datamatrixTemp;
    }

    public static function getDigit($text, $rectangular)
    {
        // Code the text in the ASCII mode
        $dataCodeWords = self::encodeDataCodeWordsASCII($text);
        $dataCWCount = count($dataCodeWords);
        $index = self::selectIndex($dataCWCount, $rectangular); // Select the index for the data tables
        $totalDataCWCount = self::$dataCWCount[$index]; // Number of data CW
        $solomonCWCount = self::$solomonCWCount[$index]; // Number of Reed Solomon CW
        $totalCWCount = $totalDataCWCount + $solomonCWCount; // Number of CW
        $rowsTotal = self::$lengthRows[$index]; // Size of symbol
        $colsTotal = self::$lengthCols[$index];
        $rowsRegion = self::$regionRows[$index]; // Number of region
        $colsRegion = self::$regionCols[$index];
        $rowsRegionCW = self::$dataRegionRows[$index];
        $colsRegionCW = self::$dataRegionCols[$index];
        // Size of matrice data
        $rowsLengthMatrice = $rowsTotal-2*$rowsRegion;
        $colsLengthMatrice = $colsTotal-2*$colsRegion;
        // Number of Reed Solomon blocks
        $blocks = self::$interleavedBlocks[$index];
        $errorBlocks = $solomonCWCount / $blocks;
        // Add codewords pads
        self::addPadCW($dataCodeWords, $dataCWCount, $totalDataCWCount);
        // Calculate correction coefficients
        $g = self::calculSolFactorTable($errorBlocks);
        // Add Reed Solomon codewords
        self::addReedSolomonCW($solomonCWCount, $g, $totalDataCWCount, $dataCodeWords, $blocks);
        $codeWordsBits = array(); // Calculte bits from codewords
        for ($i=0; $i<$totalCWCount; $i++) {
            $codeWordsBits[$i] = self::getBits($dataCodeWords[$i]);
        }
        $datamatrix = array_fill(0, $colsLengthMatrice, array());
        $assigned = array_fill(0, $colsLengthMatrice, array());
        // Add the bottom-right corner if needed
        if ((($rowsLengthMatrice * $colsLengthMatrice) % 8) == 4) {
            $datamatrix[$rowsLengthMatrice-2][$colsLengthMatrice-2] = 1;
            $datamatrix[$rowsLengthMatrice-1][$colsLengthMatrice-1] = 1;
            $datamatrix[$rowsLengthMatrice-1][$colsLengthMatrice-2] = 0;
            $datamatrix[$rowsLengthMatrice-2][$colsLengthMatrice-1] = 0;
            $assigned[$rowsLengthMatrice-2][$colsLengthMatrice-2] = 1;
            $assigned[$rowsLengthMatrice-1][$colsLengthMatrice-1] = 1;
            $assigned[$rowsLengthMatrice-1][$colsLengthMatrice-2] = 1;
            $assigned[$rowsLengthMatrice-2][$colsLengthMatrice-1] = 1;
        }
        // Put the codewords into the matrix
        self::next(0, $rowsLengthMatrice, $colsLengthMatrice, $codeWordsBits, $datamatrix, $assigned);
        // Add the finder pattern
        $datamatrix = self::addFinderPattern($datamatrix, $rowsRegion, $colsRegion, $rowsRegionCW, $colsRegionCW);
        return $datamatrix;
    }
}
