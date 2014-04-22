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
    $reg = 0;
    $Sede = array('sede' => $_SESSION["Sede"]['nombresed']);
	$userResp = $client->call("consultarUsuarioXUser",$userparam);

    $Sedes = $userResp['return'];
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
	$SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	 $SedeRol=$SedeR['return'];
    if ($SedeRol['idrol']['idrol'] == "4" || $SedeRol['idrol']['idrol'] == "5") {
       
	    if($Sedes != ""){
		
			$resultadoSedes = $Sedes['return'];
			if(isset($resultadoSedes[0])){
				$reg = count($resultadoSedes);
			}
			else{
				$reg = 1;
			}
		}else{
			
			$reg = 0;
		}
	   
    } else {
        iraURL('../pages/inbox.php');
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
include("../views/create_valise.php");
?>