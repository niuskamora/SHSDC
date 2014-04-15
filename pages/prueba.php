<?php
session_start();
include("../recursos/funciones.php");

require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$userparam['user'] = "jose.fuentes";
		$usuario = new nusoap_client($wsdl_sdc, 'wsdl');
		$userResp = $usuario->call("consultarUsuarioXUser",$userparam);
        $valorUser = $userResp['return'];
		//echo '<pre>';print_r($valorUser);
		$Resp = $usuario->call("listarDocumentos");
        $valorR = $Resp['return'];
		//echo '<pre>';print_r($valorR);
		
	for ($i = 0; $i < count($valorR); $i++) {
	//echo '<pre>';print_r($valorR[$i]["iddoc"]);
	}
		$Resp = $usuario->call("listarBitacora");
        $valorR = $Resp['return'];
		
		for ($i = 0; $i < count($valorR); $i++) {
			echo '<pre>';print_r($valorR[$i]["idsed"]["idorg"]["descripcionorg"]);
			}
		
?>