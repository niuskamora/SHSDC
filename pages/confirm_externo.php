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
        if ( $SedeRol["idrol"]["idrol"] != "2" && $SedeRol["idrol"]["idrol"] != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

    $sede = array('idsed' => $_SESSION["Sede"]["idsed"]);
    $parametros = array('sede' => $sede);
	$consumo = $client->call("consultarPaquetesXConfirmarExternos",$parametros);
	if ($consumo!="") {
	$PaquetesConfirmados = $consumo['return'];  
	}
   // $PaquetesConfirmados = $client->consultarPaquetesXConfirmarExternos($parametros);
    include("../views/confirm_externo.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
?>