<?php

$xsd = file_get_contents('evtInfoEmpregador.xsd');
$xsd = str_replace("xs:", "", $xsd);

$dom = new \DOMDocument();
$dom->loadXML($xsd);
$nodes = $dom->getElementsByTagName('element');
foreach ($nodes as $node) {
    $name = $node->getAttribute('name');
    $type = $node->getAttribute('type');
    $use = $node->getAttribute('use');
    foreach($node->childNodes as $child) {
        $data[] = array($child->nodeName => $child->nodeValue);
    }
}

echo "<pre>";
print_r($data);
echo "</pre>";


/*
$s = simplexml_load_string($xsd);

$json = json_encode($s, true);
$json = str_replace("@attributes", "attributes", $json);
//echo $json;
$std = json_decode($json);

echo "<pre>";
print_r($std);
echo "</pre>";
 * 
 */