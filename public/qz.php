<?php
?>
<html>
<head>
    <script type="text/javascript" src="/js/dependencies/rsvp-3.1.0.min.js"></script>
    <script type="text/javascript" src="/js/dependencies/sha-256.min.js"></script>
    <script type="text/javascript" src="/js/qz-tray.js"></script>
    <script type="text/javascript" src="/js/additional/jquery-1.11.3.min.js"></script>
</head>
<script>

qz.security.setCertificatePromise(function(resolve, reject) {
    $.ajax("assets/signing/plastfoam-certificate.txt").then(resolve, reject);
});

qz.security.setSignaturePromise(function(toSign) {
    return function(resolve, reject) {
        $.ajax("assets/signing/sign-message.php?request=" + toSign).then(resolve, reject);
    };
});

qz.websocket.connect().then(function(){
    qz.printers.getDefault().then(function(printer){
        var config = qz.configs.create(printer);
        
        var data = [
            '\nI8,A\n',
            'q819\n',
            'O\n',
            'JF\n',
            'WN\n',
            'ZT\n',
            'Q600,25\n',
            'N\n',
            'A789,547,2,5,2,2,N,"{lote}"\n',
            'A350,549,2,3,3,3,N,"{peca}"\n',
            'A790,172,2,2,2,2,N,"{pbruto} kg"\n',
            'A444,182,2,2,2,2,N,"{pliq} kg"\n',
            'A789,343,2,5,1,1,N,"{cod}"\n',
            'B180,59,1,1C,4,8,155,N,"{id}"\n',
            'A790,62,2,4,1,1,N,"{datahora}"\n',
            'A789,583,2,3,1,1,N,"LOTE/OP"\n',
            'A350,583,2,3,1,1,N,"PEÇA"\n',
            'A789,377,2,3,1,1,N,"CÓDIGO"\n',
            'A790,210,2,3,1,1,R,"PESO BRUTO"\n',
            'A444,209,2,3,1,1,R,"PESO LIQUIDO"\n',
            'P1\n'
        ];
        qz.print(config, data).catch(function(e) {
            console.error(e);
        });
    });
});
</script>
