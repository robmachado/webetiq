/*
$(document).ready(function() {
    $( "#ajax" ).click(function() {
        console.log('entrou');
        $( "#form" ).validate();
        if( $( "#form" ).valid() ) {
            var formData = $( "#form" ).serialize();
            console.log(formData);
        } else {
            console.log('não validou');
        }    
        
        
    });
});
*/
$(document).ready(function() {
    // process the form
    $('form').submit(function(event) {
        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = $( 'form' ).serialize();
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'process.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data); 

                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });
});


function calcula(param) {
    var id = param.id;
    var pb = document.getElementById("pesoBruto").value;
    var pl = document.getElementById("pesoLiq").value;
    var tara = document.getElementById("tara").value;
    if (id == "pesoBruto" && tara != "") {
        //calcula PesoLiq
        document.getElementById("pesoLiq").value = (parseFloat(pb) - parseFloat(tara));
    } else if (id == "tara" && pb > 0) {
        //calcula PesoLiq
        document.getElementById("pesoLiq").value = (parseFloat(pb) - parseFloat(tara));
    } else if (id == "pesoLiq" && tara != "") {
        //calcula PesoBruto
        document.getElementById("pesoBruto").value = (parseFloat(pl) + parseFloat(tara));
    }
}

function valDate(param) {
    var emiss = document.getElementById("emissao").value;
    alert(emiss);
    //var d = new Date(year, month, day);
    //d.setMonth(d.getMonth() + 8);
}

