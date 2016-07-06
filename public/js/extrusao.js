qz.security.setCertificatePromise(function(resolve, reject) {
    $.ajax("assets/signing/plastfoam.mercurio.cert.pem").then(resolve, reject);
        resolve();
});

qz.security.setSignaturePromise(function(toSign) {
    return function(resolve, reject) {
        $.ajax("assets/signing/sign-message.php?request=" + toSign).then(resolve, reject);
    };
});

function launchQZ() {
    if (!qz.websocket.isActive()) {
        window.location.assign("qz:launch");
        startConnection({ retries: 5, delay: 1 });
    }
}

function startConnection(config) {
    if (!qz.websocket.isActive()) {
        updateState('Waiting', 'default');
        qz.websocket.connect(config).then(function() {
            updateState('Active', 'success');
            findVersion();
        }).catch(handleConnectionError);
    } else {
        displayMessage('Uma conexão QZ já está ativa.', 'alert-warning');
    }
}

function endConnection() {
    if (qz.websocket.isActive()) {
        qz.websocket.disconnect().then(function() {
           updateState('Inactive', 'default');
        }).catch(handleConnectionError);
    } else {
        displayMessage('Não existe conexão QZ ativa.', 'alert-warning');
    }
}

function findPrinter(query, set) {
    $("#printerSearch").val(query);
    qz.printers.find(query).then(function(data) {
        displayMessage("<strong>Found:</strong> " + data);
        if (set) { setPrinter(data); }
    }).catch(displayError);
}

function findDefaultPrinter(set) {
    qz.printers.getDefault().then(function(data) {
        if (set) { setPrinter(data); }
    }).catch(displayError);
}

function printEPL(printData) {
    var config = getUpdatedConfig();
    qz.print(config, printData).catch(displayError);
}

function printZPL(printData) {
    var config = getUpdatedConfig();
    qz.print(config, printData).catch(displayError);
}

function printBase64(printData) {
    var config = getUpdatedConfig();
    qz.print(config, printData).catch(displayError);
}

    /// Page load ///
 $(document).ready(function() {
    window.readingWeight = false;
    startConnection();
});

qz.websocket.setClosedCallbacks(function(evt) {
    updateState('Inactive', 'default');
    console.log(evt);
    if (evt.reason) {
        displayMessage("<strong>Connection closed:</strong> " + evt.reason, 'alert-warning');
    }
});

qz.websocket.setErrorCallbacks(handleConnectionError);

function getUpdatedConfig() {
    if (cfg == null) {
        cfg = qz.configs.create(null);
    }
    updateConfig();
    return cfg
}

function updateConfig() {
    var pxlSize = null;
    var copies = 1;
    var jobName = null;
    cfg.reconfigure({
        altPrinting: $("#rawAltPrinting").prop('checked'),
        encoding: $("#rawEncoding").val(),
        endOfDoc: $("#rawEndOfDoc").val(),
        perSpool: $("#rawPerSpool").val(),
        colorType: $("#pxlColorType").val(),
        copies: copies,
        density: $("#pxlDensity").val(),
        duplex: $("#pxlDuplex").prop('checked'),
        interpolation: $("#pxlInterpolation").val(),
        jobName: jobName,
        margins: pxlMargins,
        orientation: $("#pxlOrientation").val(),
        paperThickness: $("#pxlPaperThickness").val(),
        printerTray: $("#pxlPrinterTray").val(),
        rasterize: $("#pxlRasterize").prop('checked'),
        rotation: $("#pxlRotation").val(),
        scaleContent: $("#pxlScale").prop('checked'),
        size: pxlSize,
        units: $("input[name='pxlUnits']:checked").val()
    });
}

