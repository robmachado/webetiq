
//aciona o processo de migração das ultimas OPs para o MySQL
var waitingDialog = waitingDialog || (function ($) {
    'use strict';
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
	'<div class="modal-content">' +
	'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
	'<div class="modal-body">' +
        '<center><img src="img/default.svg"></center>' +
	'</div>' +
	'</div></div></div>');

	return {
            /**
             * Opens our dialog
             * @param message Custom message
             * @param options Custom options:
             *  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
             *  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
             */
            show: function (message, options) {
                // Assigning defaults
		if (typeof options === 'undefined') {
                    options = {};
		}
		if (typeof message === 'undefined') {
                    message = 'Loading';
		}
                var settings = $.extend({
                    dialogSize: 'm',
                    progressType: '',
                    onHide: null // This callback runs after the dialog was hidden
		}, options);
		// Configuring dialog
		$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
		$dialog.find('.progress-bar').attr('class', 'progress-bar');
		if (settings.progressType) {
                    $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
		}
		$dialog.find('h3').text(message);
		// Adding callbacks
		if (typeof settings.onHide === 'function') {
                    $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                        settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
	},
	/**
	 * Closes dialog
	 */
	hide: function () {
            $dialog.modal('hide');
	}
    };
})(jQuery);


$('#btn1').on('click', function(event) {
    event.preventDefault();
    waitingDialog.show('Processando Aguarde !');
    window.location.href="migrar.php";
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
        var uri = 'migrar.php?f=UNO&id='+document.getElementById('numop').value;
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
