<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;

$numrom = filter_input(INPUT_POST, 'numrom', FILTER_SANITIZE_STRING);
$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$db = new DBase($config);

if (!isset($numrom)) {
    $body = "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-md-3\"> </div>
            <div class=\"col-md-4\">
                <center>
                <h2>Deleta Romaneio</h2>
                </center>
            </div>
        </div>    
        <div class=\"row\">
            <div class=\"col-md-3\"> </div>
            <div class=\"col-md-4\">
                <form role=\"form\" method=\"POST\" action=\"deleterom.php\">
                    <div class=\"input-group\">
                        <label for=\"ini\">Romaneio</label>
                        <input type=\"text\" class=\"form-control input-lg\" id=\"numrom\" name=\"numrom\" value=\"\" autofocus placeholder=\"Entre numero do romaneio\">
                    </div>    
                    <div class=\"input-group\">
                        <button class=\"btn btn-danger\" type=\"submit\"><span class=\"glyphicon glyphicon-trash\"></span> Deleta </button>
                    </div>
                </form>
            </div>
        </div>
    </div>";
    $html = file_get_contents('assets/main.html');
    $html = str_replace("{{extras}}", '', $html);
    $html = str_replace("{{title}}", 'Deleta Romaneios', $html);
    $html = str_replace("{{content}}", $body, $html);
    $html = str_replace("{{script}}", '', $html);
    echo $html;
} elseif ($numrom > 1) {
    $sqlComm = "SELECT * FROM romaneios WHERE id = $numrom;";
    $resp = $db->query($sqlComm);
    if (empty($resp)) {
        echo "Não encontrado romaneio n. $numrom.";
        die;
    }
    $sqlComm = "UPDATE extruders SET romaneado=0 WHERE romaneado=$numrom;";
    $resp = $db->execute($sqlComm);
    $sqlComm = "DELETE * FROM romaneios WHERE id = $numrom;";
    $resp = $db->execute($sqlComm);
    echo "Romaneio n. $numrom. removido!";
    die;
}
