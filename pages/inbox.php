<?php 
session_start();
//try {

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

    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $client->decode_utf8 = false;
    $i = 0;
   
	$BandejaUsu = $client->call("consultarBandejas");
	//echo ("<pre>");
//	print_r($BandejaUsu['return']);
//	echo ("<pre>");
//	exit;
	
   // $Usuario = array('user' => $_SESSION["Usuario"]->return->idusu, 'ban' => $BandejaUsu[$i]['nombreiba']);

   $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
	$SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	
    if ($SedeR!="") {
        $SedeRol=$SedeR['return'];
	   
	}else{
	 iraURL('../pages/index.php');	
	}

	 
    $reg = 0;
    if($BandejaUsu != ""){
		$resultadoBandejaUsu = $BandejaUsu['return'];
		if(isset($resultadoBandejaUsu[0])){
			$reg = count($resultadoBandejaUsu);
		}
		else{
			$reg = 1;
		}
	}
//} catch (Exception $e) {
//    javaalert('Lo sentimos no hay conexion');
//    iraURL('../index.php');
//}
include("../views/inbox.php");
?>