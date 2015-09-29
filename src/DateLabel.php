<?php

namespace Webetiq;

/**
 * Description of DateLabel
 *
 * @author administrador
 */
class DateLabel
{
    public function dt2Pt($data = '')
    {
        if ($data == '') {
            return date('d/m/Y');
        }
        $aD = explode('-', $data);
        return $aD[2].'/'.$aD[1].'/'.$aD[0];
    }
    
    public function pt2Dt($data = '')
    {
        if ($data == '') {
            return date('Y-m-d');
        }
        $aD = explode('/', $data);
        return $aD[2].'-'.$aD[1].'-'.$aD[0];
    }
    
    public function dt2Ts($data = '')
    {
        if ($data == '') {
            $data = date('Y-m-d');
        }
        $aD = explode('-', $data);
        return mktime(0, 0, 0, $aD[1], $aD[2], $aD[0]);
    }
    
    public function pt2Ts($data = '')
    {
        return $this->dt2Ts($this->pt2Dt($data));
    }
    
    public function ts2Dt($tstamp = 0)
    {
        return date('Y-m-d', $tstamp);
    }
    
    public function ts2Pt($tstamp = 0)
    {
        return date('d/m/Y', $tstamp);
    }
}
