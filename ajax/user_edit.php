<?php

session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
    $aux = $_POST['ed'];
    $datosB = array('idusu' => $_SESSION["usuedit"], 'rol' => $aux, 'sede' => $_SESSION["sedeb"]);
    if ($aux == "") {
        javaalert('Debe seleccionar un rol');
        iraURL('../pages/edit_type_user.php');
    } else {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $res = $client->editarRol($datosB);
        if ($res->return == 1) {
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