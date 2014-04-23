<?php

session_start();

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
try {
       
     $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
     $SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	 $SedeRol=$SedeR['return'];
    if ($SedeR!="") {
        if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

    $Ses = $client->call("ConsultarSedes");
	
    if ($Ses=="") {
        javaalert("lo sentimos no se pueden deshabilitar Areas, no existen sedes registradas, Consulte con el administrador");
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
    include("../views/disable_area.php");
} catch (Exception $e) {
    javaalert('Error al deshabiltar el area');
    iraURL('../pages/inbox.php');
}
?>