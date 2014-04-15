<?php
session_start();
include("../recursos/funciones.php");

require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

if (isset($_SESSION["Usuario"]) || isset($_SESSION["User"])) {
    eliminarSesion();
}

if (isset($_POST["Biniciar"])) {
    try {
		/*$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $Usuario = array('user' => $_POST["usuario"]);*/
		$UsuarioC = array('user' => $_POST["usuario"], 'password' => $_POST["password"]);
		//$auto=$client->auntenticarLDAP($UsuarioC);
		
		
		//$usuario = new nusoap_client($wsdl_sdc, 'wsdl');
		//$userparam['user'] = $_POST["usuario"];
		//$userparam['password']= $_POST["password"];
		//$userResp = $usuario->call("auntenticarLDAP",$userparam);
        //$valorUser = $userResp['return'];
		
		//if($valorUser=="ACEPT"){
			
		//$UsuarioLogIn = $client->consultarUsuarioXUser($Usuario);
		
		
		$userparam['user'] = $_POST["usuario"];
		$usuario = new nusoap_client($wsdl_sdc, 'wsdl');
		$userResp = $usuario->call("consultarUsuarioXUser",$userparam);
        $valorUser = $userResp['return'];
		
		//if (isset($UsuarioLogIn->return)) {
		if (isset($valorUser)) {
			javaalert($valorUser['nombreusu']);
			
            $_SESSION["Usuario"] = $UsuarioLogIn;
            $idUsu = array('idusu' => $UsuarioLogIn->return->idusu);
            $registroUsu = array('registroUsuario' => $idUsu);
            $Sedes = $client->consultarSedeDeUsuario($registroUsu);
            if (isset($Sedes->return) && count($Sedes->return) == 1) {
                $_SESSION["Sede"] = $Sedes;
                iraURL("../pages/inbox.php");
            } else if (isset($Sedes->return)) {
                $_SESSION["Sedes"] = $Sedes;
                iraURL("../pages/headquarters.php");
            }
        } else {
            $_SESSION["User"] = $_POST["usuario"];
            iraURL("../pages/create_user.php");
        }
			
	//}else{
	//		javaalert('No pertenece a la organizacion');
     //         iraURL('index.php');
			
	//}
		
       
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
    }
}
include("../views/index.php");
?>