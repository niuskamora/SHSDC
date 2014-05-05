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
    $Ses = $client->call("ConsultarSedes");
    $reg = 0;
    if ($Ses=="") {
        javaalert("lo sentimos no existen sedes registradas, Consulte con el administrador");
        iraURL('../pages/inbox.php');
    }else{
		$Sedes=$Ses["return"];
			if(isset($Sedes[0])){
				$reg = count($Sedes);
			}
			else{
				$reg = 1;
			}
		
	}
     $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
     $SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	 
    if ($SedeR!="") {
		$SedeRol=$SedeR['return'];
        if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2"){
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }
	include("../views/assign_headquarters.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/index.php');
}

?>