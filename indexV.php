
<?php

session_start();
include("recursos/funciones.php");
require_once("config/wsdl.php");
require_once("config/definitions.php");
require_once('lib/nusoap.php');

if (isset($_SESSION["Usuario"]) || isset($_SESSION["User"])) {
    eliminarSesion();
}

if (isset($_POST["Biniciar"])) {
    try {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $Usuario = array('user' => $_POST["usuario"]);
		$UsuarioC = array('user' => $_POST["usuario"], 'password' => $_POST["password"]);
		$auto=$client->auntenticarLDAP($UsuarioC);
		
		//if($auto->return=="ACEPT"){
			
			 $UsuarioLogIn = $client->consultarUsuarioXUser($Usuario);

        if (isset($UsuarioLogIn->return)) {

            $_SESSION["Usuario"] = $UsuarioLogIn;
            $idUsu = array('idusu' => $UsuarioLogIn->return->idusu);
            $registroUsu = array('registroUsuario' => $idUsu);
            $Sedes = $client->consultarSedeDeUsuario($registroUsu);
            if (isset($Sedes->return) && count($Sedes->return) == 1) {
                $_SESSION["Sede"] = $Sedes;
                iraURL("./pages/inbox.php");
            } else if (isset($Sedes->return)) {
                $_SESSION["Sedes"] = $Sedes;
                iraURL("pages/headquarters.php");
            }
        } else {
            $_SESSION["User"] = $_POST["usuario"];
            iraURL("pages/create_user.php");
        }
			
		//}else{
		//	javaalert('No pertenece a la organizacion');
         //     iraURL('index.php');
			
		//}
		
       
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
    }
}
include("/views/index.php");
?>