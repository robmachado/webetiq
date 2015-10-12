$('#btn1').on('click', function(event) {
    event.preventDefault();
    //window.location.href=\"migrarmdb.php\";
    alert('migrarmdb.php');
});

$('#btn2').on('click', function(event) {
    event.preventDefault();
    var numop = document.getElementById('numop').value;
    if (numop == '') {
        var message = 'Indique um numero de OP primeiro';
        var alerttype = 'alert-danger';
        showalert(message, alerttype);
    } else {
        var uri = 'migrarmdb.php?id='+document.getElementById('numop').value;
        var message = uri;
        var alerttype = 'alert-danger';
        showalert(message, alerttype);
        //window.location.href=\"migrarmdb.php?id=\"+numop;
    }
});

$('#confirm-btn3').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('.debug-url').html('Importar tudo novamente: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
});

function showalert(message, alerttype) {
    $('#alert_placeholder').append('<div id=\"alertdiv\" class=\"alert ' +  alerttype + '\"><a class=\"close\" data-dismiss=\"alert\">×</a><span>'+message+'</span></div>')
        setTimeout(function() {
        $("#alertdiv").remove();
    }, 5000);
}
