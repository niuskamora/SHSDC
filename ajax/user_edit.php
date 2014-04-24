<?php

session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
    $aux = $_POST['ed'];
    $datosB = array('idusu' =>utf8_encode( $_SESSION["usuedit"]), 'rol' => $aux, 'sede' => utf8_decode($_SESSION["sedeb"]));
    if ($aux == "") {
        javaalert('Debe seleccionar un rol');
        iraURL('../pages/edit_type_user.php');
    } else {
	$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
        $res = $client->call("editarRol",$datosB);
        if ($res["return"] == 1) {
            javaalert('Rol asignado con exito');
            iraURL('../pages/administration.php');
        } else {
            javaalert('Error al realizar la operacion');
            iraURL('../pages/administration.php');
        }
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../index.php');
}
?>