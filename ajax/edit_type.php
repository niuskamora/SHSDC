<?php

session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
    $aux = $_POST['ed'];
    $datosB = array('idusu' => $_SESSION["usuedit"], 'tipo' => $aux);

    if ($aux == "") {
        javaalert('Debe seleccionar Tipo de usuario');
        iraURL('../pages/edit_type_user.php');
    } else {

		$client = new nusoap_client($wsdl_sdc, 'wsdl');
		$client->decode_utf8 = false;
        $res = $client->call("editarTipoUsuario",$datosB);
        if ($res['return'] == 1) {
		$userparam['user'] = utf8_decode($_SESSION["Usuario"]["userusu"]);
		$consumo = $client->call("consultarUsuarioXUser",$userparam);
		if ($consumo!="") {
			$_SESSION["Usuario"]=$consumo['return'];
			}
            javaalert('Tipo de usuario asignado con exito');
            iraURL('../pages/administration.php');
        } else {
            javaalert('Error al realizar la operacion');
            iraURL('../pages/administration.php');
        }
    }
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('index.php');
}
?>