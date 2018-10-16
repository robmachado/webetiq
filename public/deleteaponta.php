<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Entries\Entries;

$id = !empty($_GET['id']) ? $_GET['id'] : null;
//$id = 82;
if (!empty($id)) {
    $entries = new Entries();
    echo $entries->delete($id);
}
