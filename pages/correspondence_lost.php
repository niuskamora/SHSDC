<?php

session_start();

include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}
try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
    } else {
        iraURL('../pages/inbox.php');
    }    
	$parametros = array('idusu' => $_SESSION["Usuario"]->return->idusu,
        'idsede' => $_SESSION["Sede"]->return->idsed);
	$consumo = $client->call("consultarStatusPaquete",$parametros);	
    if ($consumo!="") {
	$PaquetesExtraviados = $consumo['return'];   
    } 
	//$PaquetesExtraviados = $client->consultarStatusPaquete($parametros);
    //echo '<pre>';print_r($PaquetesExtraviados);
	include("../views/correspondence_lost.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>