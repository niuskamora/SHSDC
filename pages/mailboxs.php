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
	$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
	$UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
	$SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	$SedeRol=$SedeR['return'];
	$usu = $_SESSION["Usuario"]->return->idusu;
	$sede = $_SESSION["Sede"]->return->idsed;
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