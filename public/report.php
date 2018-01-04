<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$title = "Relatorios";
$body = "";

$menu = file_get_contents('assets/menu.html');
$html = file_get_contents('assets/newmain.html');
$html = str_replace("{{extras}}", '', $html);
$html = str_replace("{{menu}}", $menu, $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;