<?php

namespace Webetiq\DateTime;

class DateTime
{
    /**
     * Converte hora em equivalente decimal
     * @param string $time
     * @return float
     */
    public static function convertTimeToDec($time)
    {
        if (empty($time)) {
            return 0;
        }
        $timeArr = explode(':', $time);
        $minuteTime = ($timeArr[0]*60) + ($timeArr[1]);
        if (count($timeArr) > 2) {
            $minuteTime += ($timeArr[2]/60);
        }
        return $minuteTime;
    }
    
    /**
     * Converte o horario decimal em hora
     * @param float $decimal
     * @return string
     */
    public static function convertDecToTime($decimal)
    {
        $hours = floor($decimal/60);
        $minutes = floor($decimal%60);
        $seconds = $decimal - (int)$decimal;
        $seconds = round($seconds * 60);
        return str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT);
    }
    
    /**
     * Converte um horario decimal em seu equivalente de turno
     * @param float $decimal
     * @return float
     */
    public static function convertDecToShiftMode($decimal)
    {
        if ($decimal >= 360 && $decimal <= 1440) {
            $shiftDecTime = $decimal - 360;
        } elseif ($decimal <= 359.99) {
            $shiftDecTime = $decimal + 1440 - 360;
        }
        return round($shiftDecTime/60, 4);
    }
    
    /**
     * Converte de horario decima de turno para horario decimal
     * @param type $shiftDecTime
     * @return float
     */
    public static function convertShiftModeToDec($shiftDecTime)
    {
        $shiftDec = $shiftDecTime * 60;
        if ($shiftDecTime < 18) {
            return $shiftDec+360;
        } else {
            return $shiftDec+360-1440;
        }
    }
    
    /**
     * Retorna o numero do turno com base no horario decimal do turno
     * @param float $shiftDecTime
     * @return int
     */
    public static function getShiftValue($shiftDecTime)
    {
        if ($shiftDecTime >= 0 && $shiftDecTime < 8) {
            return 1;
        } elseif ($shiftDecTime >= 8 && $shiftDecTime < 16) {
            return 2;
        }
        return 3;
    }
}
