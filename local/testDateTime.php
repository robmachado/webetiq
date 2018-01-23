<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DateTime\DateTime as DT;
/*
$time = '06:00';
echo "Horario: $time<br/><br/>";
$dectime = DT::convertTimeToDec($time);
echo "Decimal: $dectime<br/><br/>";
$shifttime = DT::convertDecToShiftMode($dectime);
echo "Dec. turno: $shifttime<br/><br/>";
$dectime1 = DT::convertShiftModeToDec(round($shifttime,3));
echo "Dec. hora: $dectime1<br/><br/>";
$rectime = DT::convertDecToTime($dectime1);
echo "Horario turno: $rectime<br/><br/>";

$timeI = '08:22';
echo "Horario: $timeI<br/><br/>";
$dectimeI = DT::convertTimeToDec($timeI);
echo "Decimal: $dectimeI<br/><br/>";
$shifttimeI = DT::convertDecToShiftMode($dectimeI);
echo "Dec. turno: $shifttime<br/><br/>";
$dectimeI1 = DT::convertShiftModeToDec(round($shifttime,3));
echo "Dec. hora: $dectimeI1<br/><br/>";
$rectimeI = DT::convertDecToTime($dectimeI1);
echo "Horario turno: $rectimeI<br/><br/>";

$timeF = '15:55';
echo "Horario: $timeF<br/><br/>";
$dectimeF = DT::convertTimeToDec($timeF);
echo "Decimal: $dectimeF<br/><br/>";
$shifttimeF = DT::convertDecToShiftMode($dectimeF);
echo "Dec. turno: $shifttimeF<br/><br/>";
$dectimeF1 = DT::convertShiftModeToDec(round($shifttimeF,3));
echo "Dec. hora: $dectime1<br/><br/>";
$rectimeF = DT::convertDecToTime($dectimeF1);
echo "Horario turno: $rectimeF<br/><br/>";

echo "Numero de Minutos entre $timeI e $timeF <BR>";
$dif = $shifttimeF - $shifttimeI;
echo "DIF: $dif <br>";
echo "Convertendo: ";
$minF = DT::convertShiftModeToDec($shifttimeF);
$minI = DT::convertShiftModeToDec($shifttimeI);
echo ($minF-$minI).' min<br>';

$dt1 = new \DateTime($timeF);
$diff = $dt1->diff(new \DateTime($timeI));
$minutes = $diff->h * 60 + $diff->i;
echo "Min: $minutes<br>";
*/
$hrs = [
    ['06:00','07:00'], //1
    ['07:00','08:00'], //2
    ['08:00','09:00'], //3
    ['09:00','10:00'], //4
    ['10:00','11:00'], //5
    ['11:00','12:00'], //6
    ['12:00','13:00'], //7
    ['13:00','14:00'], //8
    ['14:00','15:00'], //9
    ['15:00','16:00'], //10
    ['16:00','17:00'], //11
    ['17:00','18:00'], //12
    ['18:00','19:00'], //13
    ['19:00','20:00'], //14
    ['20:00','21:00'], //15
    ['21:00','22:00'], //16
    ['22:00','23:00'], //17
    ['23:00','24:00'], //18
    ['00:00','01:00'], //19
    ['01:00','02:00'], //20
    ['02:00','03:00'], //21
    ['03:00','04:00'], //22
    ['04:00','05:00'], //23
    ['05:00','06:00'], //24
];

$total = 0;
foreach ($hrs as $h) {
    $decF = DT::convertTimeToDec($h[1]);
    $decI = DT::convertTimeToDec($h[0]);
    $dif = $decF-$decI;
    $total += $dif;
    echo "[" . $h[0] . "] - [" . $h[1] . "] = $dif <br>";
    echo ".................. sub: $total <br>";
}
echo "TOTAL = $total minutos";
