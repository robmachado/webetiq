<?php
namespace Webetiq\Connectors;

use Webetiq\Connectors\ConnetorInterface;

class File implements ConnetorInterface
{
    protected $directory;
    protected $printerName;

    public function __construct($directory = '', $printerName = '')
    {
        if ($directory == '') {
            $this->directory = sys_get_temp_dir().DIRECTORY_SEPARATOR;
        }
        $this->printerName = $printerName;
    }
    
    public function send($data)
    {
        $filename = $this->directory.$this->printerName.'_'.date('YmdHis').'.txt';
        file_put_contents($filename, $data);
        return $filename;
    }
}
