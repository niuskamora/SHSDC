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
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
 $consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
        if ($SedeRol["idrol"]["idrol"] != "2" && $SedeRol["idrol"]["idrol"] != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }
    $sede = array('idsed' => $_SESSION["Sede"]->return->idsed);
    $parametros = array('sede' => $sede);
    //$PaquetesExternos = $client->consultarPaquetesExternosXEnviar($parametros);
	$consumo = $client->call("consultarPaquetesExternosXEnviar",$parametros);
	if ($consumo!="") {
	$PaquetesExternos =$consumo['return'];   
	}
    include("../views/external_costs.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>