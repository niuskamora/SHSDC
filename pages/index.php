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
//if (isset($_SESSION["Usuario"]) || isset($_SESSION["User"])) {
//    eliminarSesion();
//}

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
	
		$userResp = $client->call("consultarUsuarioXUser",$userparam);
        $valorUser = $userResp['return'];
	//if (isset($UsuarioLogIn->return)) {
		if ($userResp!="") {
			
            $_SESSION["Usuario"] = $valorUser;
          //  $idUsu = array('idusu' => $UsuarioLogIn->return->idusu);
           // $registroUsu = array('registroUsuario' => $idUsu);
			$idusu['idusu'] =$valorUser["idusu"];
			$registroUsu["registroUsuario"]=$idusu;
           
		   // $Sedes = $client->consultarSedeDeUsuario($registroUsu);
           $consumo = $client->call("consultarSedeDeUsuario",$registroUsu);
		   $Sedes = $consumo['return'];
		   if (!isset($Sedes[0])) {
                $_SESSION["Sede"] = $Sedes;
               iraURL("../pages/inbox.php");
            } else {
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