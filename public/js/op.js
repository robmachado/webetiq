//aciona o processo de migração das ultimas OPs para o MySQL
$('#btn1').on('click', function(event) {
    event.preventDefault();
    window.location.href="migrarmdb.php?f=LAST";
});

//aciona o processo de migração da OP selecionada
$('#btn2').on('click', function(event) {
    event.preventDefault();
    var numop = document.getElementById('numop').value;
    if (numop == '') {
        //var message = 'Indique um numero de OP primeiro';
        //var alerttype = 'alert-danger';
        //showalert(message, alerttype);
        var msg = 'Indique um numero de OP primeiro!!';
        diag(msg);
    } else {
        //inicia a migração da OP selecionada
        var uri = 'migrarmdb.php?f=UNO&id='+document.getElementById('numop').value;
        var message = uri;
        var alerttype = 'alert-danger';
        showalert(message, alerttype);
        window.location.href=uri;
    }
});

//motra uma mensagem para o usuário
function diag(msg) {
       var dialog = new BootstrapDialog({
       type:BootstrapDialog.TYPE_DANGER,
       title:'Aviso Importante',
       message:msg,
       buttons:[{
          label:'Cancelar',
          action: function(dialogItself){
             dialogItself.close();
          }
       }]
   });
   dialog.open();  
}

//aciona a migração completa com o aviso de perigo e perguntando se prossegue
$('#btn3').on('click', function(event) {
   event.preventDefault();
   var dialog = new BootstrapDialog({
       type:BootstrapDialog.TYPE_DANGER,
       title:'Aviso Importante',
       message:'Você está ciente que essa operação irá APAGAR todos os dados da base e importar TODAS as OPs novamente.<br> E que isso irá levar um tempo considerável, impossibilitando o uso desta aplicação por vários minutos. Devo prosseguir?',
       buttons:[{
          label:'Cancelar',
          action: function(dialogItself){
             dialogItself.close();
          }
       },{
          label: 'Prosseguir',
          cssClass: 'btn-danger',
          action: function(){
             window.location.href="migrarmdb.php?f=Full";
          } 
       }]
   });
   dialog.open();  
});

//mostra mansagem de alerta
function showalert(message, alerttype) {
    $('#alert_placeholder').append('<div id=\"alertdiv\" class=\"alert ' +  alerttype + '\"><a class=\"close\" data-dismiss=\"alert\">×</a><span>'+message+'</span></div>')
        setTimeout(function() {
        $("#alertdiv").remove();
    }, 5000);
}
