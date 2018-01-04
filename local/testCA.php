<?php

$g = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
$r = fopen("https://nfe.sefaz.am.gov.br/", "rb", false, $g);
$cont = stream_context_get_params($r);
print_r(openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]));
die;


$g = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
$r = stream_socket_client("http://nfe.sefaz.am.gov.br:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $g);
$cont = stream_context_get_params($r);
print_r(openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]));
die;
