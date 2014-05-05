<?php

session_start();

include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

try {
   $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$_SESSION["cli"]=$client;
	if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
	} elseif (!usuarioCreado()) {
		iraURL("../pages/create_user.php");
	}
     $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
    } else {
        iraURL('../pages/inbox.php');
    }    
	$parametros = array('idusu' => $_SESSION["Usuario"]["idusu"],
        'idsede' => $_SESSION["Sede"]["idsed"]);
	$consumo = $client->call("consultarStatusPaquete",$parametros);	
    if ($consumo!="") {
	$PaquetesExtraviados = $consumo['return'];   
    } 

	include("../views/correspondence_lost.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
?>