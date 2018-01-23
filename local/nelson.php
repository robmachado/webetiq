<?php

/* 
curl -X POST \
  http://homolog.platafoor.com.br/leads \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhiMGUzMDQxOWVjOWYxNWRhN2M3MDg5ZWNjMjdjZTliZDc5NzAyNDJjZTk2OThmNjc1YzIwZWU1ZjVkODQxMzNmNzQ4ODEyN2FiNDgxOWQ0In0.eyJhdWQiOiIxNiIsImp0aSI6IjhiMGUzMDQxOWVjOWYxNWRhN2M3MDg5ZWNjMjdjZTliZDc5NzAyNDJjZTk2OThmNjc1YzIwZWU1ZjVkODQxMzNmNzQ4ODEyN2FiNDgxOWQ0IiwiaWF0IjoxNDk0OTY3NTEwLCJuYmYiOjE0OTQ5Njc1MTAsImV4cCI6MTUyNjUwMzUxMCwic3ViIjoiNiIsInNjb3BlcyI6WyJsZWFkQ3JlYXRlIl19.NabxwjDzpVqUd0vmAj7ZGffn7yWF9ikySQ6fVuYo0O4QN8VAcKbnA65JPgtpNMAz7IFBXJMYU7cx6CUs3oNPlRpA-Yo49uA1XQggE7zXGJLB2oOg9wWTpSo5gPbfunqMpU97cKGO379aoqdh-nDwrY3rnK-QJohgD4Igj3e7vE2CHjHbDb7PE2FEBU_ofpp57IouLK-T74CNcKRKNJvlU0p5oJnJ7JSfskcGqymlevlOs99guEY2CoIktYWXsfEsj6mOO0hQtwTFcLPRV6jRkU91p58R7SlHk0foXbh2T-4lVw7rJ-BP0TgnFhHk1b5HAQBg9sbAUpK_ez59JDboU7bS2qxiL9n6Ru016Py_DkRtx4MadPhjmgxJpi0GqkwRXK2H4uhcZPAQTK_zgHev4EGxvSge9hoIBYLcoUPHSC4zEMUpYH072E3hkrKy9LACpuw8UOMXoNQAVylWiBa5tI3h_5CAerAfayBk03uu6g9861koOC8KMD8Ju2qts_p-npeEVuiSOt41jkQbylxIaazersJ6b2I28BPrvV9-yZ85PfpQ8X2f66AEAc8_6fYgqZi8bhgjCCb8XXUNpfuV2mhDKJJixDI033E1SveATTmYtWCsvQOUYAD0fUJxMyHKE45RqTIDGmza1eDpvT4kbycFUosdQm8twrKs1H_OzVI' \
  -H 'Cache-Control: no-cache' \
  -H 'Postman-Token: 93cb2e22-e475-551b-2fdb-56183db604f1' \
  -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
  -F instance_id=2 \
  -F product_id=36 \
  -F 'name=Lewney Ferreira Teste' \
  -F primary_mobile_phone=5511982890629 \
  -F primary_landline_phone=551136454186 \
  -F primary_registry=23018272838 \
  -F 'interesse=Trocar de plano' \
  -F ja_e_cliente=sim
 */


$url = "http://homolog.platafoor.com.br/leads";

$parameters = [
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhiMGUzMDQxOWVjOWYxNWRhN2M3MDg5ZWNjMjdjZTliZDc5NzAyNDJjZTk2OThmNjc1YzIwZWU1ZjVkODQxMzNmNzQ4ODEyN2FiNDgxOWQ0In0.eyJhdWQiOiIxNiIsImp0aSI6IjhiMGUzMDQxOWVjOWYxNWRhN2M3MDg5ZWNjMjdjZTliZDc5NzAyNDJjZTk2OThmNjc1YzIwZWU1ZjVkODQxMzNmNzQ4ODEyN2FiNDgxOWQ0IiwiaWF0IjoxNDk0OTY3NTEwLCJuYmYiOjE0OTQ5Njc1MTAsImV4cCI6MTUyNjUwMzUxMCwic3ViIjoiNiIsInNjb3BlcyI6WyJsZWFkQ3JlYXRlIl19.NabxwjDzpVqUd0vmAj7ZGffn7yWF9ikySQ6fVuYo0O4QN8VAcKbnA65JPgtpNMAz7IFBXJMYU7cx6CUs3oNPlRpA-Yo49uA1XQggE7zXGJLB2oOg9wWTpSo5gPbfunqMpU97cKGO379aoqdh-nDwrY3rnK-QJohgD4Igj3e7vE2CHjHbDb7PE2FEBU_ofpp57IouLK-T74CNcKRKNJvlU0p5oJnJ7JSfskcGqymlevlOs99guEY2CoIktYWXsfEsj6mOO0hQtwTFcLPRV6jRkU91p58R7SlHk0foXbh2T-4lVw7rJ-BP0TgnFhHk1b5HAQBg9sbAUpK_ez59JDboU7bS2qxiL9n6Ru016Py_DkRtx4MadPhjmgxJpi0GqkwRXK2H4uhcZPAQTK_zgHev4EGxvSge9hoIBYLcoUPHSC4zEMUpYH072E3hkrKy9LACpuw8UOMXoNQAVylWiBa5tI3h_5CAerAfayBk03uu6g9861koOC8KMD8Ju2qts_p-npeEVuiSOt41jkQbylxIaazersJ6b2I28BPrvV9-yZ85PfpQ8X2f66AEAc8_6fYgqZi8bhgjCCb8XXUNpfuV2mhDKJJixDI033E1SveATTmYtWCsvQOUYAD0fUJxMyHKE45RqTIDGmza1eDpvT4kbycFUosdQm8twrKs1H_OzVI',
    'Cache-Control: no-cache',
    'Postman-Token: 93cb2e22-e475-551b-2fdb-56183db604f1',
    'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW'  
];

$fields = [
     'instance_id' => 2,
     'product_id' => 36,
     'name' => 'Lewney Ferreira Teste',
     'primary_mobile_phone' => '5511982890629',
     'primary_landline_phone' => '551136454186',
     'primary_registry' => '23018272838',
     'interesse' => 'Trocar de plano',
     'ja_e_cliente' => 'sim'
];

$bq = rawurldecode(http_build_query($fields));


try {
    $oCurl = curl_init();
    curl_setopt($oCurl, CURLOPT_URL, $url);
    //curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    //curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 10);
    //curl_setopt($oCurl, CURLOPT_TIMEOUT, 10 + 20);
    curl_setopt($oCurl, CURLOPT_HEADER, 1);
    curl_setopt($oCurl, CURLOPT_HTTPHEADER, $parameters);
    //curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($oCurl, CURLOPT_POST, true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS, $bq);
    $response = curl_exec($oCurl);
    $soaperror = curl_error($oCurl);
    $ainfo = curl_getinfo($oCurl);
    if (is_array($ainfo)) {
        $soapinfo = $ainfo;
    }
    $headsize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
    $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
    curl_close($oCurl);
    $responseHead = trim(substr($response, 0, $headsize));
    $responseBody = trim(substr($response, $headsize));    
} catch (\Exception $e) {
    echo "FAULT:" . $e->getMessage();
    die;
}

if ($soaperror != '') {
    echo "ERROR: ". $soaperror . " [$url]";
    die;
}

if ($httpcode != 200) {
    echo "REJECT: [$url]" . $responseHead;
    die;
}

echo $responseBody;            
