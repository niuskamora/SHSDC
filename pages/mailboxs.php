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
	
    if ($SedeR!="") {
        $SedeRol=$SedeR['return'];
	   
		
	}else{
	 iraURL('../pages/inbox.php');	
	}

	$usu = $_SESSION["Usuario"]['idusu'];
	$sede = $_SESSION["Sede"]['idsed'];
    $datos = array('registroUsuario' => $usu);
    $resultadoList = $client->call("consultarBuzonUsuario",$datos);

	if($resultadoList  != ""){
		
			$resultadoLista  = $resultadoList['return'];
			if(isset($resultadoLista [0])){
				$reg = count($resultadoLista);
			}
			else{
				$reg = 1;
			}
		}else{
			 javaalert('No hay buzones registrados, consulte con el Administrador');
			  iraURL('../pages/inbox.php');			
			  $reg = 0;
			}
	
	
    include("../views/mailboxs.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>