$('#btn1').on('click', function(event) {
    event.preventDefault();
    window.location.href="migrarmdb.php?f=LAST";
});

$('#btn2').on('click', function(event) {
    event.preventDefault();
    var numop = document.getElementById('numop').value;
    if (numop == '') {
        //var message = 'Indique um numero de OP primeiro';
        //var alerttype = 'alert-danger';
        //showalert(message, alerttype);
        diag();
    } else {
        var uri = 'migrarmdb.php?f=UNO&id='+document.getElementById('numop').value;
        var message = uri;
        var alerttype = 'alert-danger';
        showalert(message, alerttype);
        window.location.href=uri;
    }
});

function diag() {
       var dialog = new BootstrapDialog({
       type:BootstrapDialog.TYPE_DANGER,
       title:'Aviso Importante',
       message:'Indique um numero de OP primeiro!!',
       buttons:[{
          label:'Cancelar',
          action: function(dialogItself){
             dialogItself.close();
          }
       }]
   });
   dialog.open();  
}

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


function showalert(message, alerttype) {
    $('#alert_placeholder').append('<div id=\"alertdiv\" class=\"alert ' +  alerttype + '\"><a class=\"close\" data-dismiss=\"alert\">×</a><span>'+message+'</span></div>')
        setTimeout(function() {
        $("#alertdiv").remove();
    }, 5000);
}
