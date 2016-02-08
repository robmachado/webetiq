<?php

$dirIterator = new RecursiveDirectoryIterator(dirname(__FILE__));
$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iterator as $file) {
    if (is_file($file)) {
        $dir = dirname($file);
        $num = strpos($dir, 'vendor');
        if (substr($file, -3) == 'php' && $num === false) {
            clearTABS($file);
            clearSpcLf($filename);
            echo $file, "\n";
        }
    }
}


function clearTABS($filename)
{
    $dados = file_get_contents($filename);
    $dados = str_replace("\t", '    ', $dados);
    return file_put_contents($filename, $dados);
}

function clearSpcLf($filename)
{
    $aLinhas = file($filename);
    $iCount = 0;
    foreach ($aLinhas as $linha) {
        $aLinhas[$iCount] = rtrim($linha);
        $iCount++;
    }
    $dados = implode("\n", $aLinhas)."\n";
    file_put_contents($filename, $dados);
}
