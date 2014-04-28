<?php

$idarea = $_POST['idarea'];
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
    $area = array('area' => $idarea);
    $client->call("estadoArea",$area);

    include("../views/disable_area.php");
} catch (Exception $e) {
    javaalert('Error al deshabiltar el area');
    iraURL('../pages/inbox.php');
}
?>