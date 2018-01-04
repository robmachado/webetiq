<?php

$url = "https://www.google.com";

// Inicializa a sessão com o cURL
$oCurl = curl_init();

// Seta a URL a ser consultada
curl_setopt($oCurl, CURLOPT_URL, $url);

// Ajusta o cURL para retornar os dados obtidos ao invés de jogar na saída
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);

// Ajusta a informação fornecida como se fosse um browser
// NOTA: existem casos onde o servidor não responde ao cURL ou outros aplicativos
// ou seja somente permite que Browsers acessem isto vai engana-los
curl_setopt($oCurl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");

// Ajusta o cURL para ignorar a verificação do certificado do servidor
// NOTA: isso não é o mais adequado, o correto é incluir o certificado 
// do servidor no CA 
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);

// Instrui o cURL a seguir qualquer redirecionamento
curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);

// Define um limte de redirecionamentos ao no maximo 10
curl_setopt($oCurl, CURLOPT_MAXREDIRS, 10);

// tempo limite na conexão
curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 120);

// tempo limite na resposta
curl_setopt($oCurl, CURLOPT_TIMEOUT, 120); 

// Obtêm o retorno da chamada
$response = curl_exec($oCurl);

// Obtêm dados para permitir um DEBUG de falha
$err = curl_errno($oCurl);
$errmsg = curl_error($oCurl);
$header = curl_getinfo($oCurl);

// Fecha a conexão
curl_close($oCurl);

echo $response;