<?php
date_default_timezone_set ( 'Europe/Amsterdam' );
error_reporting(E_ALL);
ini_set('display_errors',-1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');
if(array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', $_SERVER)) {
    header('Access-Control-Allow-Headers: '
           . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
} else {
    header('Access-Control-Allow-Headers: *');
}

require_once '../vendor/restler.php';
require_once '../include/musixmatch.php';
use Luracast\Restler\Restler;

$r = new Restler();
$r->addAPIClass('Programming');
$r->handle();
