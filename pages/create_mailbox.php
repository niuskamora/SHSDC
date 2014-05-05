<?php

session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

    $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
	$_SESSION["cli"]=$client;
	if (!isset($_SESSION["Usuario"])) {
        iraURL("../index.php");
    } elseif (!usuarioCreado()) {
        iraURL("../pages/create_user.php");
    }
       
    $i = 0;
    $Sede = array('sede' => utf8_decode($_SESSION["Sede"]['nombresed']));

    $Ses = $client->call("ConsultarSedesBuzon",$Sede);
	
      
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
 	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
        
    } else {
        iraURL('../pages/inbox.php');
    }
   
    $reg = 0;
    if ($Ses!="") {
		$Sedes=$Ses['return'];
        $reg = count($Sedes);
    }
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
include("../views/create_mailbox.php");
?>