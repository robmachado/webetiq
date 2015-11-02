<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

//$im = new Imagick('image.png');
//$im->writeImage('image.bmp');
//Or if you want to output image to http response:

//$im = new Imagick('image.png');
//$im->setImageFormat('bmp');
//echo $im;

use Webetiq\Graphics\Grf;

$filename = '../images/logo.bmp';
$imagename = 'teste.grf';

//echo dechex(-28);
//echo '<br>';
//echo dechex(27);

//exit;
$th = Grf::Bmp2Grf($filename, $imagename);

//$th = Grf::imagecreatefrombmp($filename);
