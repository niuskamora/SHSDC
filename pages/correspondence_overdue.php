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
	$usu = array('idusu' => $_SESSION["Usuario"]->return->idusu);
    $sede = array('idsed' => $_SESSION["Sede"]->return->idsed);
    $parametros = array('registroUsuario' => $usu,
        'registroSede' => $sede);
	$consumo = $client->call("paquetesVencidosXDestino",$parametros);
	if ($consumo!="") {
	$PaquetesDestino = $consumo['return'];   
    } 
	$consumo = $client->call("paquetesVencidosXOrigen",$parametros);
	if ($consumo!="") {
	$PaquetesOrigen = $consumo['return'];   
    } 
    //$PaquetesDestino = $client->paquetesVencidosXDestino($parametros);
    //$PaquetesOrigen = $client->paquetesVencidosXOrigen($parametros);
    include("../views/correspondence_overdue.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');

}
?>