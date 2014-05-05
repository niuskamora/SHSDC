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


$UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
	$SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	
    if ($SedeR!="") {
        $SedeRol=$SedeR['return'];
	    if($SedeRol['idrol']['idrol'] != "1"){
			 iraURL('../pages/inbox.php');
		}
		
	}else{
	 iraURL('../pages/inbox.php');	
	}
		
		
$usu = $_SESSION["Usuario"]['idusu'];
$sede = $_SESSION["Sede"]['idsed'];

try {
        
    $datos = array('idusu' => $usu, 'idsed' => $sede);
    $resultadoList = $client->call("consultarPaquetesporArea",$datos);

    if ($resultadoList=="") {
        $bitacora = 0;
    } else {
		$resultadoLista=$resultadoList['return'];
		
		if(isset($resultadoLista[0])){
					  $bitacora  = count($resultadoLista);
					
				}
				else{
					  $bitacora  = 1;
					
				}
       
    }
    include("../views/package_area.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/administration.php');
}
?>
