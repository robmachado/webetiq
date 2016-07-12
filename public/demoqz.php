<?php

?>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>QZ Tray Sample Page</title>
</head>
<!-- Required scripts -->
<script type="text/javascript" src="js/dependencies/rsvp-3.1.0.min.js"></script>
<script type="text/javascript" src="js/dependencies/sha-256.min.js"></script>
<script type="text/javascript" src="js/qz-tray.js"></script>
<!-- Page styling -->
<script type="text/javascript" src="js/additional/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/additional/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<body id="qz-page" role="document">
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="https://qz.io/"><span class="fa fa-print"></span>&nbsp;qz.</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- cheap way to avoid reimplementing the php menu -->
                <li><a href="#">Demo Mode</a></li>
                <li><a href="https://qz.io/api/" target="_docs">API</a></li>
            </ul>
        </div>
    </div>
</nav>
<div id="qz-alert" style="position: fixed; width: 60%; margin: 0 4% 0 36%; z-index: 900;"></div>
<div id="qz-pin" style="position: fixed; width: 30%; margin: 0 66% 0 4%; z-index: 900;"></div>
<div class="container" role="main">
    <div class="row">
        <h1 id="title" class="page-header">QZ Tray v<span id="qz-version">0</span></h1>
    </div>
    <div class="row spread">
        <div class="col-md-4">
            <div id="qz-connection" class="panel panel-default">
                <div class="panel-heading">
                    <button class="close tip" data-toggle="tooltip" title="Launch QZ" id="launch" href="#" onclick="launchQZ();" style="display: none;">
                        <i class="fa fa-external-link"></i>
                    </button>
                    <h3 class="panel-title">
                        Connection: <span id="qz-status" class="text-muted" style="font-weight: bold;">Unknown</span>
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="btn-toolbar">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success" onclick="startConnection();">Connect</button>
                            <button type="button" class="btn btn-warning" onclick="endConnection();">Disconnect</button>
                        </div>
                        <button type="button" class="btn btn-info" onclick="listNetworkInfo();">List Network Info</button>
                    </div>
                </div>
            </div>
            <hr />
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Printer</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="printerSearch">Search:</label>
                        <input type="text" id="printerSearch" value="zebra" class="form-control" />
                    </div>
                    <div class="form-group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm" onclick="findPrinter($('#printerSearch').val(), true);">Find Printer</button>
                            <button type="button" class="btn btn-default btn-sm" onclick="findDefaultPrinter(true);">Find Default Printer</button>
                            <button type="button" class="btn btn-default btn-sm" onclick="findPrinters();">Find All Printers</button>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Current printer:</label>
                        <div id="configPrinter">NONE</div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm" onclick="setPrinter($('#printerSearch').val());">Set To Search</button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#askFileModal">Set To File</button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#askHostModal">Set To Host</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" role="tablist">
                <li id="rawTab" role="presentation" class="active"><a href="#rawContent" role="tab" data-toggle="tab">Raw Printing</a></li>
                <li id="pxlTab" role="presentation"><a href="#pxlContent" role="tab" data-toggle="tab">Pixel Printing</a></li>
                <li id="serialTab" role="presentation"><a href="#serialContent" role="tab" data-toggle="tab">Serial</a></li>
                <li id="usbTab" role="presentation"><a href="#usbContent" role="tab" data-toggle="tab">USB</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="rawContent" class="tab-pane active col-md-8">
                <h3>Raw Printing</h3>
                <div class="row">
                    <div class="col-md-12">
                        <a href="https://qz.io/wiki/What-is-Raw-Printing" target="new">What is Raw Printing?</a>
                        <span style="float: right;">
                            <a href="javascript:findPrinter('Zebra', true);">Zebra</a> |
                            <a href="javascript:findPrinter('ZDesigner', true);">ZDesigner</a> |
                            <a href="javascript:findPrinter('Epson', true);">Epson</a> |
                            <a href="javascript:findPrinter('Citizen', true);">Citizen</a> |
                            <a href="javascript:findPrinter('Star', true);">Star</a>
                        </span>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <label>Print Sample To Type</label>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printEPL();">EPL</button>
                                <button type="button" class="btn btn-default" onclick="printZPL();">ZPL</button>
                                <button type="button" class="btn btn-default" onclick="printESCP();">ESCP</button>
                                <button type="button" class="btn btn-default" onclick="printEPCL();">EPCL (Zebra Card Printer)</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Print Data</label>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printBase64();">Base64</button>
                                <button type="button" class="btn btn-default" onclick="printXML();">XML</button>
                                <button type="button" class="btn btn-default" onclick="printHex();">Hex</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <label>Print From File</label>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printFile('zpl_sample.txt');">zpl_sample.txt</button>
                                <button type="button" class="btn btn-default" onclick="printFile('fgl_sample.txt');">fgl_sample.txt</button>
                                <button type="button" class="btn btn-default" onclick="printFile('epl_sample.txt');">epl_sample.txt</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="rawEncoding">Encoding</label>
                                            <input type="text" id="rawEncoding" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="rawEndOfDoc">End Of Doc</label>
                                            <input type="text" id="rawEndOfDoc" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="rawPerSpool">Per Spool</label>
                                            <input type="number" id="rawPerSpool" class="form-control pull-right" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="rawAltPrinting">Alternate Printing</label>
                                            <input type="checkbox" id="rawAltPrinting" class="pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="rawCopies">Copies</label>
                                            <input type="number" id="rawCopies" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label class="tip" for="rawJobName" data-toggle="tooltip" title="Job title as it appears in print queue">
                                                Job Name
                                            </label>
                                            <input type="text" id="rawJobName" class="form-control pull-right" />
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetRawOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pxlContent" class="tab-pane col-md-8">
                <h3>Pixel Printing</h3>

                <div class="row">
                    <div class="col-md-12">
                        <a href="https://qz.io/wiki/what-is-postScript-printing" target="new">What is Pixel Printing?</a>

                        <span style="float: right;">
                            <a href="javascript:findPrinter('XPS', true);">Microsoft XPS</a> |
                            <a href="javascript:findPrinter('PDF', true);">PDF</a>
                        </span>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="printHTML();">Print HTML</button>
                            <button type="button" class="btn btn-default" onclick="printPDF();">Print PDF</button>
                            <button type="button" class="btn btn-default" onclick="printImage();">Print Image</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group form-inline">
                                            <label for="pxlColorType">Color Type</label>
                                            <select id="pxlColorType" class="form-control pull-right">
                                                <option value="color">Color</option>
                                                <option value="grayscale">Grayscale</option>
                                                <option value="blackwhite">Black & White</option>
                                            </select>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlCopies">Copies</label>
                                            <input type="number" id="pxlCopies" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlDensity" class="tip" data-toggle="tooltip"
                                                   title="DPI, DPCM, or DPMM depending on units specified">Density
                                            </label>
                                            <input type="number" id="pxlDensity" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlDuplex"> Duplex</label>
                                            <input type="checkbox" id="pxlDuplex" class="pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlInterpolation">Interpolation</label>
                                            <select id="pxlInterpolation" class="form-control pull-right">
                                                <option value="">Default</option>
                                                <option value="bicubic">Bicubic</option>
                                                <option value="bilinear">Bilinear</option>
                                                <option value="nearest-neighbor">Nearest Neighbor</option>
                                            </select>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label class="tip" for="pxlJobName" data-toggle="tooltip" title="Job title as it appears in print queue">
                                                Job Name
                                            </label>
                                            <input type="text" id="pxlJobName" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlOrientation">Orientation</label>
                                            <select id="pxlOrientation" class="form-control pull-right">
                                                <option value="">Default</option>
                                                <option value="portrait">Portrait</option>
                                                <option value="landscape">Landscape</option>
                                                <option value="reverse-landscape">Landscape - Reverse</option>
                                            </select>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlPaperThickness">Paper<br />Thickness</label>
                                            <input disabled type="number" step="any" id="pxlPaperThickness" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlPrinterTray">Printer Tray</label>
                                            <input disabled type="text" id="pxlPrinterTray" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlRasterize">Rasterize</label>
                                            <input type="checkbox" id="pxlRasterize" class="pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlRotation">Rotation</label>
                                            <input type="number" step="any" id="pxlRotation" class="form-control pull-right" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Units</label>
                                            <div>
                                                <label>
                                                    <input type="radio" name="pxlUnits" id="pxlUnitsIN" value="in" />
                                                    IN
                                                </label>
                                                <label>
                                                    <input type="radio" name="pxlUnits" id="pxlUnitsMM" value="mm" />
                                                    MM
                                                </label>
                                                <label>
                                                    <input type="radio" name="pxlUnits" id="pxlUnitsCM" value="cm" />
                                                    CM
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="pxlScale">Scale Content:</label>
                                            <input type="checkbox" id="pxlScale" class="pull-right" />
                                        </div>

                                        <div class="form-group">
                                            <label for="pxlMargins" class="tip" data-toggle="tooltip" title="In relation to units specified">Margins</label>
                                            (
                                            <label for="pxlMarginsActive" class="inline">Individual:</label>
                                            <input type="checkbox" id="pxlMarginsActive" onclick="checkMarginsActive();">
                                            )
                                            <input type="number" step="any" id="pxlMargins" class="form-control" />
                                        </div>
                                        <div class="inline" id="pxlMarginsGroup">
                                            <div class="form-group form-inline">
                                                <label for="pxlMarginsTop">&nbsp; Top:</label>
                                                <input type="number" step="any" id="pxlMarginsTop" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pxlMarginsRight">&nbsp; Right:</label>
                                                <input type="number" step="any" id="pxlMarginsRight" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pxlMarginsBottom">&nbsp; Bottom:</label>
                                                <input type="number" step="any" id="pxlMarginsBottom" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pxlMarginsLeft">&nbsp; Left:</label>
                                                <input type="number" step="any" id="pxlMarginsLeft" class="form-control pull-right" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="inline">Size</label>
                                            (
                                            <label for="pxlSizeActive" class="inline">Enable:</label>
                                            <input type="checkbox" id="pxlSizeActive" onclick="checkSizeActive();" />
                                            )
                                        </div>
                                        <div class="inline" id="pxlSizeGroup">
                                            <div class="form-group form-inline">
                                                <label for="pxlSizeWidth" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                    &nbsp; Width:
                                                </label>
                                                <input type="number" step="any" id="pxlSizeWidth" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pxlSizeHeight" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                    &nbsp; Height:
                                                </label>
                                                <input type="number" step="any" id="pxlSizeHeight" class="form-control pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetPixelOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="serialContent" class="tab-pane col-md-8">
                <h3>Serial</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-toolbar">
                            <button type="button" class="btn btn-info" onclick="listSerialPorts();">List Ports</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" onclick="openSerialPort();">Open Port</button>
                                <button type="button" class="btn btn-warning" onclick="closeSerialPort();">Close Port</button>
                            </div>
                            <button type="button" class="btn btn-default" onclick="sendSerialData();">Send Command</button>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="serialPort">Port</label>
                                            <input type="text" id="serialPort" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialCmd">Command</label>
                                            <input type="text" id="serialCmd" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialBegin">Response Start</label>
                                            <input type="text" id="serialBegin" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialEnd">Response End</label>
                                            <input type="text" id="serialEnd" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <!-- Overrides response Start/End fields -->
                                            <label for="serialWidth">Response Length</label>
                                            <input type="number" id="serialWidth" class="form-control pull-right" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="serialBaud">Baud Rate</label>
                                            <input type="number" id="serialBaud" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialData">Data Bits</label>
                                            <input type="number" id="serialData" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialStop">Stop Bits</label>
                                            <input type="number" id="serialStop" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialParity">Parity</label>
                                            <input type="text" id="serialParity" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="serialFlow">Flow Control</label>
                                            <input type="text" id="serialFlow" class="form-control pull-right" />
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetSerialOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="usbContent" class="tab-pane col-md-8">
                <h3>USB</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="listUsbDevices();">List Devices</button>
                                    <button type="button" class="btn btn-info" onclick="listUsbDeviceInterfaces();">List Device Interfaces</button>
                                    <button type="button" class="btn btn-info" onclick="listUsbInterfaceEndpoints();">List Interface Endpoints</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" onclick="claimUsbDevice()">Claim Device</button>
                                    <button type="button" class="btn btn-warning" onclick="releaseUsbDevice()">Release Device</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="sendUsbData()">Send Raw Data</button>
                                    <button type="button" class="btn btn-default" onclick="readUsbData()">Read Raw Data</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="openUsbStream()">Open Stream</button>
                                    <button type="button" class="btn btn-default" onclick="closeUsbStream()">Close Stream</button>
                                    <button type="button" class="btn btn-default" id="scaleToggle" onclick="toggleScale()">Read as Weight</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="usbVendor">Vendor ID</label>
                                            <input type="text" id="usbVendor" class="form-control pull-right" onblur="formatHexInput('usbVendor')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbProduct">Product ID</label>
                                            <input type="text" id="usbProduct" class="form-control pull-right" onblur="formatHexInput('usbProduct')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbInterface">Device Interface</label>
                                            <input type="text" id="usbInterface" class="form-control pull-right" onblur="formatHexInput('usbInterface')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbEndpoint">Interface Endpoint</label>
                                            <input type="text" id="usbEndpoint" class="form-control pull-right" onblur="formatHexInput('usbEndpoint')" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="usbData">Send Data</label>
                                            <input type="text" id="usbData" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbResponse">Read size</label>
                                            <input type="text" id="usbResponse" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbStream" class="tip" data-toggle="tooltip" title="in milliseconds">Stream Interval</label>
                                            <input type="text" id="usbStream" class="form-control pull-right" />
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetUsbOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="askFileModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askFile">File:</label>
                        <input type="text" id="askFile" class="form-control" value="C:\tmp\example-file.txt" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintFile();">Set</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="askHostModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askHost">Host:</label>
                        <input type="text" id="askHost" class="form-control" value="192.168.1.254" />
                    </div>
                    <div class="form-group">
                        <label for="askPort">Port:</label>
                        <input type="text" id="askPort" class="form-control" value="9100" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintHost();">Set</button>
                </div>
            </div>
        </div>
    </div>

</div>
</body>


<script>
    /// Authentication setup ///
    qz.security.setCertificatePromise(function(resolve, reject) {
        //Preferred method - from server
        $.ajax("assets/signing/plastfoam.mercurio.cert.pem").then(resolve, reject);

        //Alternate method 1 - anonymous
        resolve();

        //Alternate method 2 - direct
        /*
        resolve("-----BEGIN CERTIFICATE-----\n" +
                "MIIFAzCCAuugAwIBAgICEAIwDQYJKoZIhvcNAQEFBQAwgZgxCzAJBgNVBAYTAlVT\n" +
                "MQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0cmllcywgTExDMRswGQYD\n" +
                "VQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMMEHF6aW5kdXN0cmllcy5j\n" +
                "b20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1c3RyaWVzLmNvbTAeFw0x\n" +
                "NTAzMTkwMjM4NDVaFw0yNTAzMTkwMjM4NDVaMHMxCzAJBgNVBAYTAkFBMRMwEQYD\n" +
                "VQQIDApTb21lIFN0YXRlMQ0wCwYDVQQKDAREZW1vMQ0wCwYDVQQLDAREZW1vMRIw\n" +
                "EAYDVQQDDAlsb2NhbGhvc3QxHTAbBgkqhkiG9w0BCQEWDnJvb3RAbG9jYWxob3N0\n" +
                "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtFzbBDRTDHHmlSVQLqjY\n" +
                "aoGax7ql3XgRGdhZlNEJPZDs5482ty34J4sI2ZK2yC8YkZ/x+WCSveUgDQIVJ8oK\n" +
                "D4jtAPxqHnfSr9RAbvB1GQoiYLxhfxEp/+zfB9dBKDTRZR2nJm/mMsavY2DnSzLp\n" +
                "t7PJOjt3BdtISRtGMRsWmRHRfy882msBxsYug22odnT1OdaJQ54bWJT5iJnceBV2\n" +
                "1oOqWSg5hU1MupZRxxHbzI61EpTLlxXJQ7YNSwwiDzjaxGrufxc4eZnzGQ1A8h1u\n" +
                "jTaG84S1MWvG7BfcPLW+sya+PkrQWMOCIgXrQnAsUgqQrgxQ8Ocq3G4X9UvBy5VR\n" +
                "CwIDAQABo3sweTAJBgNVHRMEAjAAMCwGCWCGSAGG+EIBDQQfFh1PcGVuU1NMIEdl\n" +
                "bmVyYXRlZCBDZXJ0aWZpY2F0ZTAdBgNVHQ4EFgQUpG420UhvfwAFMr+8vf3pJunQ\n" +
                "gH4wHwYDVR0jBBgwFoAUkKZQt4TUuepf8gWEE3hF6Kl1VFwwDQYJKoZIhvcNAQEF\n" +
                "BQADggIBAFXr6G1g7yYVHg6uGfh1nK2jhpKBAOA+OtZQLNHYlBgoAuRRNWdE9/v4\n" +
                "J/3Jeid2DAyihm2j92qsQJXkyxBgdTLG+ncILlRElXvG7IrOh3tq/TttdzLcMjaR\n" +
                "8w/AkVDLNL0z35shNXih2F9JlbNRGqbVhC7qZl+V1BITfx6mGc4ayke7C9Hm57X0\n" +
                "ak/NerAC/QXNs/bF17b+zsUt2ja5NVS8dDSC4JAkM1dD64Y26leYbPybB+FgOxFu\n" +
                "wou9gFxzwbdGLCGboi0lNLjEysHJBi90KjPUETbzMmoilHNJXw7egIo8yS5eq8RH\n" +
                "i2lS0GsQjYFMvplNVMATDXUPm9MKpCbZ7IlJ5eekhWqvErddcHbzCuUBkDZ7wX/j\n" +
                "unk/3DyXdTsSGuZk3/fLEsc4/YTujpAjVXiA1LCooQJ7SmNOpUa66TPz9O7Ufkng\n" +
                "+CoTSACmnlHdP7U9WLr5TYnmL9eoHwtb0hwENe1oFC5zClJoSX/7DRexSJfB7YBf\n" +
                "vn6JA2xy4C6PqximyCPisErNp85GUcZfo33Np1aywFv9H+a83rSUcV6kpE/jAZio\n" +
                "5qLpgIOisArj1HTM6goDWzKhLiR/AeG3IJvgbpr9Gr7uZmfFyQzUjvkJ9cybZRd+\n" +
                "G8azmpBBotmKsbtbAU/I/LVk8saeXznshOVVpDRYtVnjZeAneso7\n" +
                "-----END CERTIFICATE-----\n" +
                "--START INTERMEDIATE CERT--\n" +
                "-----BEGIN CERTIFICATE-----\n" +
                "MIIFEjCCA/qgAwIBAgICEAAwDQYJKoZIhvcNAQELBQAwgawxCzAJBgNVBAYTAlVT\n" +
                "MQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYDVQQKDBJRWiBJ\n" +
                "bmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMsIExMQzEZMBcG\n" +
                "A1UEAwwQcXppbmR1c3RyaWVzLmNvbTEnMCUGCSqGSIb3DQEJARYYc3VwcG9ydEBx\n" +
                "emluZHVzdHJpZXMuY29tMB4XDTE1MDMwMjAwNTAxOFoXDTM1MDMwMjAwNTAxOFow\n" +
                "gZgxCzAJBgNVBAYTAlVTMQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0\n" +
                "cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMM\n" +
                "EHF6aW5kdXN0cmllcy5jb20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1\n" +
                "c3RyaWVzLmNvbTCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBANTDgNLU\n" +
                "iohl/rQoZ2bTMHVEk1mA020LYhgfWjO0+GsLlbg5SvWVFWkv4ZgffuVRXLHrwz1H\n" +
                "YpMyo+Zh8ksJF9ssJWCwQGO5ciM6dmoryyB0VZHGY1blewdMuxieXP7Kr6XD3GRM\n" +
                "GAhEwTxjUzI3ksuRunX4IcnRXKYkg5pjs4nLEhXtIZWDLiXPUsyUAEq1U1qdL1AH\n" +
                "EtdK/L3zLATnhPB6ZiM+HzNG4aAPynSA38fpeeZ4R0tINMpFThwNgGUsxYKsP9kh\n" +
                "0gxGl8YHL6ZzC7BC8FXIB/0Wteng0+XLAVto56Pyxt7BdxtNVuVNNXgkCi9tMqVX\n" +
                "xOk3oIvODDt0UoQUZ/umUuoMuOLekYUpZVk4utCqXXlB4mVfS5/zWB6nVxFX8Io1\n" +
                "9FOiDLTwZVtBmzmeikzb6o1QLp9F2TAvlf8+DIGDOo0DpPQUtOUyLPCh5hBaDGFE\n" +
                "ZhE56qPCBiQIc4T2klWX/80C5NZnd/tJNxjyUyk7bjdDzhzT10CGRAsqxAnsjvMD\n" +
                "2KcMf3oXN4PNgyfpbfq2ipxJ1u777Gpbzyf0xoKwH9FYigmqfRH2N2pEdiYawKrX\n" +
                "6pyXzGM4cvQ5X1Yxf2x/+xdTLdVaLnZgwrdqwFYmDejGAldXlYDl3jbBHVM1v+uY\n" +
                "5ItGTjk+3vLrxmvGy5XFVG+8fF/xaVfo5TW5AgMBAAGjUDBOMB0GA1UdDgQWBBSQ\n" +
                "plC3hNS56l/yBYQTeEXoqXVUXDAfBgNVHSMEGDAWgBQDRcZNwPqOqQvagw9BpW0S\n" +
                "BkOpXjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAJIO8SiNr9jpLQ\n" +
                "eUsFUmbueoxyI5L+P5eV92ceVOJ2tAlBA13vzF1NWlpSlrMmQcVUE/K4D01qtr0k\n" +
                "gDs6LUHvj2XXLpyEogitbBgipkQpwCTJVfC9bWYBwEotC7Y8mVjjEV7uXAT71GKT\n" +
                "x8XlB9maf+BTZGgyoulA5pTYJ++7s/xX9gzSWCa+eXGcjguBtYYXaAjjAqFGRAvu\n" +
                "pz1yrDWcA6H94HeErJKUXBakS0Jm/V33JDuVXY+aZ8EQi2kV82aZbNdXll/R6iGw\n" +
                "2ur4rDErnHsiphBgZB71C5FD4cdfSONTsYxmPmyUb5T+KLUouxZ9B0Wh28ucc1Lp\n" +
                "rbO7BnjW\n" +
                "-----END CERTIFICATE-----\n");
        */
    });

    qz.security.setSignaturePromise(function(toSign) {
        return function(resolve, reject) {
            //Preferred method - from server
            $.ajax("assets/signing/sign-message.php?request=" + toSign).then(resolve, reject);

            //Alternate method - unsigned
            //resolve();
        };
    });


    /// Connection ///
    function launchQZ() {
        if (!qz.websocket.isActive()) {
            window.location.assign("qz:launch");
            //Retry 5 times, pausing 1 second between each attempt
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
            displayMessage('An active connection with QZ already exists.', 'alert-warning');
        }
    }

    function endConnection() {
        if (qz.websocket.isActive()) {
            qz.websocket.disconnect().then(function() {
                updateState('Inactive', 'default');
            }).catch(handleConnectionError);
        } else {
            displayMessage('No active connection with QZ exists.', 'alert-warning');
        }
    }

    function listNetworkInfo() {
        qz.websocket.getNetworkInfo().then(function(data) {
            if (data.macAddress == null) { data.macAddress = 'UNKNOWN'; }
            if (data.ipAddress == null) { data.ipAddress = "UNKNOWN"; }

            var macFormatted = '';
            for(var i = 0; i < data.macAddress.length; i++) {
                macFormatted += data.macAddress[i];
                if (i % 2 == 1 && i < data.macAddress.length - 1) {
                    macFormatted += ":";
                }
            }

            displayMessage("<strong>IP:</strong> " + data.ipAddress + "<br/><strong>Physical Address:</strong> " + macFormatted);
        }).catch(displayError);
    }


    /// Detection ///
    function findPrinter(query, set) {
        $("#printerSearch").val(query);
        qz.printers.find(query).then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findDefaultPrinter(set) {
        qz.printers.getDefault().then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findPrinters() {
        qz.printers.find().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; " + data[i] + "<br/>";
            }

            displayMessage("<strong>Available printers:</strong><br/>" + list);
        }).catch(displayError);
    }


    /// Raw Printers ///
    function printEPL() {
        var config = getUpdatedConfig();

        var printData = [
            '\nN\n',
            'q609\n',
            'Q203,26\n',
            'B5,26,0,1A,3,7,152,B,"1234"\n',
            'A310,26,0,3,1,1,N,"SKU 00000 MFG 0000"\n',
            'A310,56,0,3,1,1,N,"QZ PRINT APPLET"\n',
            'A310,86,0,3,1,1,N,"TEST PRINT SUCCESSFUL"\n',
            'A310,116,0,3,1,1,N,"FROM SAMPLE.HTML"\n',
            'A310,146,0,3,1,1,N,"QZ.IO"\n',
            { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: { language: 'EPL', x: 150, y: 300 } },
            '\nP1,1\n'
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printZPL() {
        var config = getUpdatedConfig();

        var printData = [
            '^XA\n',
            '^FO50,50^ADN,36,20^FDPRINTED USING QZ PRINT PLUGIN ' + qzVersion + '\n',
            { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: { language: 'ZPLII' } },
            '^FS\n',
            '^XZ\n'
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printESCP() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: { language: 'ESCP', dotDensity: 'single' } },
            { type: 'raw', data: '\nPrinted using qz-print plugin.\n\n\n\n\n\n' }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printEPCL() {
        var config = getUpdatedConfig();

        var printData = [];
        $.merge(printData, convertEPCL('+RIB 4'));     // Monochrome ribbon
        $.merge(printData, convertEPCL('F'));          // Clear monochrome print buffer
        $.merge(printData, convertEPCL('+C 8'));       // Adjust monochrome intensity
        $.merge(printData, convertEPCL('&R'));         // Reset magnetic encoder
        $.merge(printData, convertEPCL('&CDEW 0 0'));  // Set R/W encoder to ISO default
        $.merge(printData, convertEPCL('&CDER 0 0'));  // Set R/W encoder to ISO default
        $.merge(printData, convertEPCL('&SVM 0'));     // Disable magnetic encoding verifications
        $.merge(printData, convertEPCL('T 80 600 0 1 0 45 1 QZ INDUSTRIES'));   // Write text buffer
        $.merge(printData, convertEPCL('&B 1 123456^INDUSTRIES/QZ^789012'));    // Write mag strip buffer
        $.merge(printData, convertEPCL('&E*'));        // Encode magnetic data
        $.merge(printData, convertEPCL('I 10'));       // Print card (10 returns to print ready pos.)
        $.merge(printData, convertEPCL('MO'));         // Move card to output hopper

        qz.print(config, printData).catch(displayError);
    }

    /**
     * EPCL helper function that appends a single line of EPCL data, taking into account
     * special EPCL NUL characters, data length, escape character and carriage return
     */
    function convertEPCL(data) {
        if (data == null || data.length == 0) {
            console.warn('Empty EPCL data, skipping');
        }

        // Data length for this command, in 2 character Hex (base 16) format
        var len = (data.length + 2).toString(16);
        if (len.length < 2) { len = '0' + len; }

        return [
            { type: 'raw', format: 'hex', data: 'x00x00x00' },  // Append 3 NULs
            { type: 'raw', format: 'hex', data: 'x' + len },    // Append our command length, in base16
            { type: 'raw', format: 'plain', data: data },       // Append our command
            { type: 'raw', format: 'plain', data: '\r' }        // Append carriage return
        ];
    }

    function printBase64() {
        var config = getUpdatedConfig();

        // Send base64 encoded characters/raw commands to qz using data type 'base64'.
        // This will automatically convert provided base64 encoded text into text/ascii/bytes, etc.
        // This example is for EPL and contains an embedded image.
        // Please adapt to your printer language.

        //noinspection SpellCheckingInspection
        var printData = [
            {
                type: 'raw',
                format: 'base64',
                data: 'Ck4KcTYwOQpRMjAzLDI2CkI1LDI2LDAsMUEsMyw3LDE1MixCLCIxMjM0IgpBMzEwLDI2LDAsMywx' +
                'LDEsTiwiU0tVIDAwMDAwIE1GRyAwMDAwIgpBMzEwLDU2LDAsMywxLDEsTiwiUVogUFJJTlQgQVBQ' +
                'TEVUIgpBMzEwLDg2LDAsMywxLDEsTiwiVEVTVCBQUklOVCBTVUNDRVNTRlVMIgpBMzEwLDExNiww' +
                'LDMsMSwxLE4sIkZST00gU0FNUExFLkhUTUwiCkEzMTAsMTQ2LDAsMywxLDEsTiwiUVpJTkRVU1RS' +
                'SUVTLkNPTSIKR1cxNTAsMzAwLDMyLDEyOCz/////////6SSSX///////////////////////////' +
                '//////////6UlUqX////////////////////////////////////8kqkpKP/////////////////' +
                '//////////////////6JUpJSVf//////////////////////////////////9KpKVVU+////////' +
                '//////////////////////////8KSSlJJf5/////////////////////////////////9KUqpVU/' +
                '/7////////////////////////////////9KqUkokf//P///////////////////////////////' +
                '+VKUqpZP//+P///////////////////////////////ElKUlSf///9f/////////////////////' +
                '////////+ipSkqin////y/////////////////////////////+lVUpUlX/////r////////////' +
                '/////////////////qlJKUql/////+n////////////////////////////BFKVKUl//////8v//' +
                '/////////////////////////zVSlKUp///////0f//////////////////////////wiSlSUpf/' +
                '//////q///////////////////////////KqlJUpV///////+R//////////////////////////' +
                '4UlKSpSX///////9T/////////6L///////////////BKlKpSqP///////1X////////0qg/23/V' +
                'VVVVVVf//8CSlJKklf///////kv///////+pS0/JP8AAAAAAB///wFSlSSpV///////+pf//////' +
                '/pUoq+qfwAAAAAAH//+AClSqpUT///////9S///////8pJUlkr+AAAAAAA///4AFJSSSUv//////' +
                '/yl///////KVUpTUv8AAAAAAH///gBKSqlVU////////lX//////6UkqoiU/wAAAAAA///+ABKpJ' +
                'Uko////////JH//////UpIiqlJ/AAAAAAD///wACkSUpJX///////6q//////6pVVSqiv4AAAAAA' +
                'f///AAJVVIqpP///////pI//////pSVtSSq/wAAAAAD///8AAJSlVJVf///////Sp/////8Sq//U' +
                'qL/ttttoAP///wAAUpVSpJ///////+pT/////qkn//UlH/////AB////AABKUSpSX///////5Sn/' +
                '///+lJ//+pS/////4AP///8AABKUkpVP///////ylP////1Kv//+qr/////AA////4AAKVVJUl//' +
                '/////+lKf////KS///8kv////8AH////gAAKSSpJR///////9Kq////9Kv///5Kf////gAf///+A' +
                'AAUlUqov///////1JT////lS////qn////8AD////4AABKpKSqf///////Skj///+kr////JH///' +
                '/wAf////wAACkqUlK///////8pKv///ypf///9V////+AD/////AAAFKUVSj///////wqlP///JT' +
                '////yR////wAP////8AAAFKqkpv///////JSlf//9Sv////U/////AB/////4AAAVIpKRf//////' +
                '+ElV///pS////8of///4AP/////gAAASZVKr///////4qkj///Sn////0v////AA//////AAABUS' +
                'VJH///////glJn//8pP////KH///8AH/////+AAACtUlVf//////+ClRP//qV////9K////gA///' +
                '///4AAACEpJK///////8BSqf/+lX////yr///8AD//////wAAAVUqVH///////gUlU//5Rf////R' +
                'P///gAf//////gAAApKqTP//////8AVSV//pU////6qf//+AD//////+AAAAqkki//////8AEpVL' +
                '/+qP////1L///wAP//////4AAACSVVB/////+AFUpKX/9KP////Sv//+AB///////AAAAEqSgH//' +
                '//+ACkpSUv/lV////6k///4AP//////+AAAAUlSgf////gAJKRUpf/ST////1J///AA///////4A' +
                'AAAVJVB////gAtVFUpV/8lX///+Vf//4AH///////gAAABKSSD///wASSVVJSR/1Vf///8kf//gA' +
                '///////+AAAABVUof//4AElUpKqqv/SL////1L//8AD///////4AAAABJJQ//8AFVJKVKSSP+qj/' +
                '///Kv//gAf///////gAAAAKSpT/+ACkqSlKUkqf5Rf///6S//+AD///////+AAAAAKqpP/ABJKVS' +
                'klKqU/xUf///qp//wAP///////4AAAAAkko+gASVKUlVKlKX/VK///9Sf/+AB////////gAAAACp' +
                'UrgAKqVKVJKSlKf+Sl///0kf/4AP///////+AAAAABSVIAFJUlKqSUpKV/0pX//8qr//AA//////' +
                '//8AAAAACklACSopKSVUqVKX/qpH//okv/4AH////////gAAAAAVVKBUpUqUkkpKSk//SSv/xVK/' +
                '/AAAAAAD////AAAAAAJKWSUpVKVVUqVSp/+qqH9SlR/8AAAAAAH///4AAAAABSUklJSSlJJKUkpf' +
                '/8klQFSo//gAAAAAA////wAAAAABVKqlUkqlSqkqqU//6pUqkkof8AAAAAAB/r//AAAAAAElEpSK' +
                'qSlSSpJKL//pUqpVKr/wAAAAAAP8v/8AAAAAAJLKUqkkpSqkqSVf//yUkpKSv+AAAAAAAfqf/wAA' +
                'AAAAVClKVVUoklUqqp///UpKVVS/wAAAAAAD+S//AAAAAAAlpSkkkpVKkpKSX///JVKTpR+AAAAA' +
                'AAH9X/8AAAAAABRUpVJUqqSpSUlf///SSk/Sv4AAAAAAA/y//wAAAAAAFSVUlSUkUkpUqr////VS' +
                'v9S/AAAAAAAB/3//AAAAAAAFUkpSlJMqqUpJP////13/pT////////////8AAAAAAAEpJSlSqUkk' +
                'pVS////////Un////////////wAAAAAABJVSlSpUqpUpJX///////8q/////////////gAAAAAAC' +
                'pSqkkpKSUpSSP///////5L////////////+AAAAAAACSkVVKSklKpVV///////+SX///////////' +
                '/4AAAAAAAFSqJKlSqqiVSX///////9U/////////////gAAAAAAASpVSlSkklVJU////////yr//' +
                '//////////+AAAAAAAAkpJSklKpKSUp////////kn////////////4AAAAAAABJSqlKqkqUqVf//' +
                '/////5K/////////////gAAAAAAACpUlKpJKUqlI////////1L////////////+AAAAAAAAFSVKS' +
                'SqkpFKX////////SX////////////4AAAAAAAAiklKlSSpTKKv///////9U/////////////wAAA' +
                'AAAABSpSlSqlSiVJ////////pV/////////////AAAAAAAAVUpSkklSlUqX////////Uv///////' +
                '/////8AAAAAAAAkqUpVJJSqpVf///////8pf////////////4AAAAAAAFJKUpKqUpJUT////////' +
                '4r/////////////wAAAAAAAKqVKVKUqSSVX///////+Uv/////////////gAAAAAAASUlKSkpKql' +
                'S////////+qf/////////////AAAAAAAEkpKUlUpJJCn////////iH///////////wAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH/4B+A8AH/AAAAA' +
                'AAAAAAAAAAAAAA//AAfwD4H4HwAAf/4H4DwB//gAAAAAAAAAAAAAAAAAD/+AB/APgfgfAAB//wfw' +
                'PAf/+AAAAAAAAAAAAAgAAAAP/8AH8AfB+D4AAH//B/g8D//4AAAAAAAAAAAADwAAAA//4A/4B8H4' +
                'PgAAfB+H+DwP4HgAAAAAAAAAAAAPwAAAD4fgD/gHw/w+AAB8D4f8PB+AGAAAAAAAAAAAAA/wAAAP' +
                'g+Af/AfD/D4AAHwPh/48HwAAAAAAAAAAAAAAB/4AAA+D4B98A+P8PAAAfA+Hvjw+AAAAAAAAAAAA' +
                'AAAB/4AAD4PgH3wD4/x8AAB8H4e/PD4AAAAAAAAAAAAAAAB/8AAPh8A+PgPn/nwAAH//B5+8Pg/4' +
                'AH/j/x/4/8f+AA/8AA//wD4+A+eefAAAf/4Hj7w+D/gAf+P/H/j/x/4AA/wAD/+APj4B5554AAB/' +
                '/AeP/D4P+AB/4/8f+P/H/gAD/AAP/wB8HwH3nvgAAH/wB4f8Pw/4AH/j/x/4/8f+AA/8AA//AH//' +
                'Af+f+AAAfAAHg/wfAPgAAAAAAAAAAAAAf/AAD5+A//+B/w/4AAB8AAeD/B+A+AAAAAAAAAAAAAH/' +
                'gAAPj8D//4D/D/AAAHwAB4H8H+D4AAAAAAAAAAAAB/4AAA+H4P//gP8P8AAAfAAHgPwP//gAAAAA' +
                'AAAAAAAP8AAAD4fh+A/A/w/wAAB8AAeA/Af/+AAAAAAAAAAAAA/AAAAPg/HwB8B+B+AAAHwAB4B8' +
                'Af/4AAAAAAAAAAAADwAAAA+B+fAHwH4H4AAAfAAHgHwAf4AAAAAAAAAAAAAIAAAAD4H/8Afgfgfg' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                'AAAAAAAAAAAAAAAAAAAAAAAAClAxLDEK'
            }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printXML() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'raw', format: 'xml', data: 'assets/zpl_sample.xml', options: { xmlTag: 'v7:Image' } }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printHex() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'raw', format: 'hex', data: '4e0d0a713630390d0a513230332c32360d0a42352c32362c' },
            { type: 'raw', format: 'hex', data: '302c31412c332c372c3135322c422c2231323334220d0a41' },
            { type: 'raw', format: 'hex', data: '3331302c32362c302c332c312c312c4e2c22534b55203030' },
            { type: 'raw', format: 'hex', data: '303030204d46472030303030220d0a413331302c35362c30' },
            { type: 'raw', format: 'hex', data: '2c332c312c312c4e2c22515a205072696e7420506c756769' },
            { type: 'raw', format: 'hex', data: '6e220d0a413331302c38362c302c332c312c312c4e2c2254' },
            { type: 'raw', format: 'hex', data: '657374207072696e74207375636365737366756c220d0a41' },
            { type: 'raw', format: 'hex', data: '3331302c3131362c302c332c312c312c4e2c2266726f6d20' },
            { type: 'raw', format: 'hex', data: '73616d706c652e68746d6c220d0a413331302c3134362c30' },
            { type: 'raw', format: 'hex', data: '2c332c312c312c4e2c227072696e7448657828292066756e' },
            { type: 'raw', format: 'hex', data: '6374696f6e2e220d0a50312c310d0a' }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printFile(file) {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'raw', format: 'file', data: 'assets/' + file }
        ];

        qz.print(config, printData).catch(displayError);
    }


    /// Pixel Printers ///
    function printHTML() {
        var config = getUpdatedConfig();

        var colA = '<h2>*&nbsp; QZ Print Plugin HTML Printing &nbsp;*</h2>' +
                '<span style="color: #F00;">Version:</span> ' + qzVersion + '<br/>' +
                '<span style="color: #F00;">Visit:</span> https://qz.io/';
        var colB = '<img src="' + getPath() + '/assets/img/image_sample.png">';

        var printData = [
            {
                type: 'html',
                format: 'plain',
                data: '<html>' +
                '   <table style="font-family: monospace; border: 1px;">' +
                '       <tr style="height: 6cm;">' +
                '           <td valign="top">' + colA + '</td>' +
                '           <td valign="top">' + colB + '</td>' +
                '       </tr>' +
                '   </table>' +
                '</html>'
            }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printPDF() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'pdf', data: 'assets/pdf_sample.pdf' }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printImage() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'image', data: 'assets/img/image_sample.png' }
        ];

        qz.print(config, printData).catch(displayError);
    }


    /// Serial ///
    function listSerialPorts() {
        qz.serial.findPorts().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; " + data[i] + "<br/>";
            }

            displayMessage("<strong>Available serial ports:</strong><br/>" + list);
        }).catch(displayError);
    }

    function openSerialPort() {
        var widthVal = $("#serialWidth").val();
        if (!widthVal) { widthVal = null; }

        var bounds = {
            begin: $("#serialBegin").val(),
            end: $("#serialEnd").val(),
            width: widthVal
        };

        qz.serial.openPort($("#serialPort").val(), bounds).then(function() {
            displayMessage("Serial port opened");
        }).catch(displayError);
    }

    function sendSerialData() {
        var properties = {
            baudRate: $("#serialBaud").val(),
            dataBits: $("#serialData").val(),
            stopBits: $("#serialStop").val(),
            parity: $("#serialParity").val(),
            flowControl: $("#serialFlow").val()
        };

        qz.serial.sendData($("#serialPort").val(), $("#serialCmd").val(), properties).catch(displayError);
    }

    function closeSerialPort() {
        qz.serial.closePort($("#serialPort").val()).then(function() {
            displayMessage("Serial port closed");
        }).catch(displayError);
    }


    /// USB ///
    function listUsbDevices() {
        qz.usb.listDevices(true).then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                var device = data[i];
                if (device.hub) { list += "USB Hub"; }

                list += "<p>" +
                        "   VendorID: <code>0x" + device.vendorId + "</code>" +
                        usbButton(["usbVendor", "usbProduct"], [device.vendorId, device.productId]) + "<br/>" +
                        "   ProductID: <code>0x" + device.productId + "</code><br/>";

                if (device.manufacturer) { list += "   Manufacturer: <code>" + device.manufacturer + "</code><br/>"; }
                if (device.product) { list += "   Product: <code>" + device.product + "</code><br/>"; }

                list += "</p><hr/>";
            }

            pinMessage("<strong>Available usb devices:</strong><br/>" + list);
        }).catch(displayError);
    }

    function listUsbDeviceInterfaces() {
        qz.usb.listInterfaces($("#usbVendor").val(), $("#usbProduct").val()).then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; <code>0x" + data[i] + "</code>" + usbButton(["usbInterface"], [data[i]]) + "<br/>";
            }

            displayMessage("<strong>Available device interfaces:</strong><br/>" + list);
        }).catch(displayError);
    }

    function listUsbInterfaceEndpoints() {
        qz.usb.listEndpoints($("#usbVendor").val(), $("#usbProduct").val(), $("#usbInterface").val()).then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; <code>0x" + data[i] + "</code>" + usbButton(["usbEndpoint"], [data[i]]) + "<br/>";
            }

            displayMessage("<strong>Available interface endpoints:</strong><br/>" + list);
        }).catch(displayError);
    }

    function claimUsbDevice() {
        qz.usb.claimDevice($("#usbVendor").val(), $("#usbProduct").val(), $("#usbInterface").val()).then(function() {
            displayMessage("USB Device claimed");
        }).catch(displayError);
    }

    function sendUsbData() {
        qz.usb.sendData($("#usbVendor").val(), $("#usbProduct").val(), $("#usbEndpoint").val(), $("usbData").val()).catch(displayError);
    }

    function readUsbData() {
        qz.usb.readData($("#usbVendor").val(), $("#usbProduct").val(), $("#usbEndpoint").val(), $("#usbResponse").val()).then(function(data) {
            displayMessage("<strong>Raw response:</strong> " + data + "<br/>");
        }).catch(displayError);
    }

    function openUsbStream() {
        qz.usb.openStream($("#usbVendor").val(), $("#usbProduct").val(), $("#usbEndpoint").val(), $("#usbResponse").val(), $("#usbStream").val()).then(function() {
            pinMessage("Waiting on device", '' + $("#usbVendor").val() + $("#usbProduct").val());
        }).catch(displayError);
    }

    function closeUsbStream() {
        qz.usb.closeStream($("#usbVendor").val(), $("#usbProduct").val(), $("#usbEndpoint").val()).then(function() {
            $('#' + $("#usbVendor").val() + $("#usbProduct").val()).attr('id', '').html("Stream closed");
        }).catch(displayError);
    }

    function toggleScale() {
        window.readingWeight = !readingWeight;

        if (readingWeight) {
            $("#scaleToggle").html("Read as Raw");
        } else {
            $("#scaleToggle").html("Read as Weight");
        }
    }

    function releaseUsbDevice() {
        qz.usb.releaseDevice($("#usbVendor").val(), $("#usbProduct").val()).then(function() {
            displayMessage("USB Device released");
        }).catch(displayError);
    }


    /// Resets ///
    function resetRawOptions() {
        $("#rawPerSpool").val(1);
        $("#rawEncoding").val(null);
        $("#rawEndOfDoc").val(null);
        $("#rawAltPrinting").prop('checked', false);
        $("#rawCopies").val(1);
    }

    function resetPixelOptions() {
        $("#pxlColorType").val("color");
        $("#pxlCopies").val(1);
        $("#pxlDensity").val('');
        $("#pxlDuplex").prop('checked', false);
        $("#pxlInterpolation").val("");
        $("#pxlJobName").val("");
        $("#pxlOrientation").val("");
        $("#pxlPaperThickness").val(null);
        $("#pxlPrinterTray").val(null);
        $("#pxlRasterize").prop('checked', true);
        $("#pxlRotation").val(0);
        $("#pxlScale").prop('checked', true);
        $("#pxlUnitsIN").prop('checked', true);

        $("#pxlMargins").val(0).css('display', '');
        $("#pxlMarginsTop").val(0);
        $("#pxlMarginsRight").val(0);
        $("#pxlMarginsBottom").val(0);
        $("#pxlMarginsLeft").val(0);
        $("#pxlMarginsActive").prop('checked', false);
        $("#pxlMarginsGroup").css('display', 'none');

        $("#pxlSizeWidth").val('');
        $("#pxlSizeHeight").val('');
        $("#pxlSizeActive").prop('checked', false);
        $("#pxlSizeGroup").css('display', 'none');
    }

    function checkSizeActive() {
        if ($("#pxlSizeActive").prop('checked')) {
            $("#pxlSizeGroup").css('display', '');
        } else {
            $("#pxlSizeGroup").css('display', 'none');
        }
    }

    function checkMarginsActive() {
        if ($("#pxlMarginsActive").prop('checked')) {
            $("#pxlMarginsGroup").css('display', '');
            $("#pxlMargins").css('display', 'none');
        } else {
            $("#pxlMarginsGroup").css('display', 'none');
            $("#pxlMargins").css('display', '');
        }
    }

    function resetSerialOptions() {
        $("#serialPort").val('');
        $("#serialCmd").val('');
        $("#serialBegin").val("0x0002"); //String.fromCharCode(2)
        $("#serialEnd").val("0x000D"); //String.fromCharCode(13)

        $("#serialBaud").val(9600);
        $("#serialData").val(8);
        $("#serialStop").val(1);
        $("#serialParity").val('NONE');
        $("#serialFlow").val('NONE');

        // M/T PS60 - 9600, 7, 1, EVEN, NONE
    }

    function resetUsbOptions() {
        $("#usbVendor").val('');
        $("#usbProduct").val('');

        $("#usbInterface").val('');
        $("#usbEndpoint").val('');
        $("#usbData").val('');
        $("#usbResponse").val(8);
        $("#usbStream").val(10);

        // M/T PS60 - V:0x0EB8 P:0xF000, I:0x0 E:0x81 (precision of 2)
        // Dymo S100 - V:0x0922 P:0x8009, I:0x0 E:0x82 (precision of 1)
    }


    /// Page load ///
    $(document).ready(function() {
        window.readingWeight = false;

        resetRawOptions();
        resetPixelOptions();
        resetSerialOptions();
        resetUsbOptions();

        startConnection();

        $("#printerSearch").on('keyup', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                findPrinter($('#printerSearch').val(), true);
                return false;
            }
        });

        $("[data-toggle='tooltip']").tooltip();
    });

    qz.websocket.setClosedCallbacks(function(evt) {
        updateState('Inactive', 'default');
        console.log(evt);

        if (evt.reason) {
            displayMessage("<strong>Connection closed:</strong> " + evt.reason, 'alert-warning');
        }
    });

    qz.websocket.setErrorCallbacks(handleConnectionError);

    qz.serial.setSerialCallbacks(function(port, output) {
        console.log('Serial', port, 'received output', output);
        displayMessage("Received output from serial port [" + port + "]: <em>" + output + "</em>");
    });

    qz.usb.setUsbCallbacks(function(keys, data) {
        if (keys[0].substring(0, 2) != '0x') { keys[0] = '0x' + keys[0]; }
        if (keys[1].substring(0, 2) != '0x') { keys[1] = '0x' + keys[1]; }
        var pin = $('#' + (keys[0]) + (keys[1]));

        if (data.error == undefined) {
            if (window.readingWeight) {
                pin.html("<strong>Weight:</strong> " + readScaleData(data, 2));
            } else {
                pin.html("<strong>Raw data:</strong> " + data);
            }
        } else {
            console.log(data.error);
            pin.html("<strong>Error:</strong> " + data.error);
        }
    });


    var qzVersion = 0;
    function findVersion() {
        qz.api.getVersion().then(function(data) {
            $("#qz-version").html(data);
            qzVersion = data;
        }).catch(displayError);
    }

    $("#askFileModal").on("shown.bs.modal", function() {
        $("#askFile").focus().select();
    });
    $("#askHostModal").on("shown.bs.modal", function() {
        $("#askHost").focus().select();
    });


    /// Helpers ///
    function handleConnectionError(err) {
        updateState('Error', 'danger');

        if (err.target != undefined) {
            if (err.target.readyState >= 2) { //if CLOSING or CLOSED
                displayError("Connection to QZ Tray was closed");
            } else {
                displayError("A connection error occurred, check log for details");
                console.error(err);
            }
        } else {
            displayError(err);
        }
    }

    function displayError(err) {
        console.error(err);
        displayMessage(err, 'alert-danger');
    }

    function displayMessage(msg, css) {
        if (css == undefined) { css = 'alert-info'; }

        var timeout = setTimeout(function() { $('#' + timeout).alert('close'); }, 5000);

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
                .css('max-height', '20em').css('overflow', 'auto')
                .attr('id', timeout).attr('role', 'alert');
        alert.html("<button type='button' class='close' data-dismiss='alert'>&times;</button>" + msg);

        $("#qz-alert").append(alert);
    }

    function pinMessage(msg, id, css) {
        if (css == undefined) { css = 'alert-info'; }

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
                .css('max-height', '20em').css('overflow', 'auto').attr('role', 'alert')
                .html("<button type='button' class='close' data-dismiss='alert'>&times;</button>");

        var text = $("<div/>").html(msg);
        if (id != undefined) { text.attr('id', id); }

        alert.append(text);

        $("#qz-pin").append(alert);
    }

    function updateState(text, css) {
        $("#qz-status").html(text);
        $("#qz-connection").removeClass().addClass('panel panel-' + css);

        if (text === "Inactive" || text === "Error") {
            $("#launch").show();
        } else {
            $("#launch").hide();
        }
    }

    function getPath() {
        var path = window.location.href;
        return path.substring(0, path.lastIndexOf("/"));
    }

    function usbButton(ids, data) {
        var click = "";
        for(var i = 0; i < ids.length; i++) {
            click += "$('#" + ids[i] + "').val('0x" + data[i] + "');$('#" + ids[i] + "').fadeOut(300).fadeIn(500);";
        }
        return '<button class="btn btn-default btn-xs" onclick="' + click + '" data-dismiss="alert">Use This</button>';
    }

    function formatHexInput(inputId) {
        var $input = $('#' + inputId);
        var val = $input.val();

        if (val.length > 0 && val.substring(0, 2) != '0x') {
            val = '0x' + val;
        }

        $input.val(val.toLowerCase());
    }


    /** Attempts to parse scale reading from USB raw output */
    function readScaleData(data) {
        // Get status
        var status = parseInt(data[1], 16);
        switch(status) {
            case 1: // fault
            case 5: // underweight
            case 6: // overweight
            case 7: // calibrate
            case 8: // re-zero
                status = 'Error';
                break;
            case 3: // busy
                status = 'Busy';
                break;
            case 2: // stable at zero
            case 4: // stable non-zero
            default:
                status = 'Stable';
        }

        // Get precision
        var precision = parseInt(data[3], 16);
        precision = precision ^ -256; //unsigned to signed

        // xor on 0 causes issues
        if (precision == -256) { precision = 0; }

        // Get weight
        data.splice(0, 4);
        data.reverse();
        var weight = parseInt(data.join(''), 16);

        weight *= Math.pow(10, precision);
        weight = weight.toFixed(Math.abs(precision));

        // Get units
        var units = parseInt(data[2], 16);
        switch(units) {
            case 3:
                units = 'kg';
                break;
            case 11:
                units = 'oz';
                break;
            case 12:
            default:
                units = 'lbs';
        }

        return weight + units + ' - ' + status;
    }


    /// QZ Config ///
    var cfg = null;
    function getUpdatedConfig() {
        if (cfg == null) {
            cfg = qz.configs.create(null);
        }

        updateConfig();
        return cfg
    }

    function updateConfig() {
        var pxlSize = null;
        if ($("#pxlSizeActive").prop('checked')) {
            pxlSize = {
                width: $("#pxlSizeWidth").val(),
                height: $("#pxlSizeHeight").val()
            };
        }

        var pxlMargins = $("#pxlMargins").val();
        if ($("#pxlMarginsActive").prop('checked')) {
            pxlMargins = {
                top: $("#pxlMarginsTop").val(),
                right: $("#pxlMarginsRight").val(),
                bottom: $("#pxlMarginsBottom").val(),
                left: $("#pxlMarginsLeft").val()
            };
        }

        var copies = 1;
        var jobName = null;
        if ($("#rawTab").hasClass("active")) {
            copies = $("#rawCopies").val();
            jobName = $("#rawJobName").val();
        } else {
            copies = $("#pxlCopies").val();
            jobName = $("#pxlJobName").val();
        }

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

    function setPrintFile() {
        setPrinter({ file: $("#askFile").val() });
        $("#askFileModal").modal('hide');
    }

    function setPrintHost() {
        setPrinter({ host: $("#askHost").val(), port: $("#askPort").val() });
        $("#askHostModal").modal('hide');
    }

    function setPrinter(printer) {
        var cf = getUpdatedConfig();
        cf.setPrinter(printer);

        if (typeof printer === 'object' && printer.name == undefined) {
            var shown;
            if (printer.file != undefined) {
                shown = "<em>FILE:</em> " + printer.file;
            }
            if (printer.host != undefined) {
                shown = "<em>HOST:</em> " + printer.host + ":" + printer.port;
            }

            $("#configPrinter").html(shown);
        } else {
            if (printer.name != undefined) {
                printer = printer.name;
            }

            if (printer == undefined) {
                printer = 'NONE';
            }
            $("#configPrinter").html(printer);
        }
    }
</script>

</html>


