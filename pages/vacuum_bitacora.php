<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

/*if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);
if (isset($SedeRol->return)) {
    if ($SedeRol->return->idusu->tipousu != "1" && $SedeRol->return->idusu->tipousu != "2") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$sede = $_SESSION["Sede"]->return->idsed;*/

try {	
	$usuario = new nusoap_client($wsdl_sdc, 'wsdl');
	$userResp = $usuario->call("listarBitacora");
	
	if($userResp != ""){
		$resultadoListaBitacora = $userResp['return'];
		if(isset($resultadoListaBitacora[0])){
			$bitacora = count($resultadoListaBitacora);
		}
		else{
			$bitacora = 1;
		}
	}
	
    if (isset($_POST["vaciar"])) {
		
		$usuario = new nusoap_client($wsdl_sdc, 'wsdl');
		$userResp = $usuario->call("vaciarBitacora");
		$resultadoVacioBitacora = $userResp['return'];

        if (isset($resultadoVacioBitacora) == 1) {
            javaalert('Bitacora Vaciada');
            //llenarLog(8, "Vacio de Bitácora", $usuarioBitacora, $sede);
            //iraURL('../pages/administration.php');
        } else {
            javaalert('Bitacora No Vaciada');
            //iraURL('../pages/administration.php');
        }
    }
    include("../views/vacuum_bitacora.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    //iraURL('../pages/administration.php');
}
?>