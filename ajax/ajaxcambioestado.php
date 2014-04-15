<?php

$idarea = $_POST['idarea'];
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
try {
    $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $area = array('area' => $idarea);
    $client->estadoArea($area);

    include("../views/disable_area.php");
} catch (Exception $e) {
    javaalert('Error al deshabiltar el area');
    iraURL('../pages/inbox.php');
}
?>