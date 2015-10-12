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


