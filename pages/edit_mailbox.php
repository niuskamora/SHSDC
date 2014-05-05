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
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
    $SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	 
	 
    if ($SedeR!="") {
		$SedeRol=$SedeR['return'];
       
    } else {
        iraURL('../pages/inbox.php');
    }
	
	
    $Buzon = array('idbuz' => $_GET["id"]);
    $Usua = $client->call("consultarBuzon",$Buzon);
	$Usuario=$Usua['return'];

    if (isset($_POST["guardar"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["direccion"]) && $_POST["direccion"] != "") {
            $telefono = "";
            if (isset($_POST["telefono"])) {
                $telefono = $_POST["telefono"];
            }
            $registroUsu = array(
                'idbuz' => $Usuario['idbuz'],
                'nombrebuz' => utf8_decode($_POST["nombre"]),
                'direccionbuz' => utf8_decode($_POST["direccion"]),
                'telefonobuz' => $telefono);
            $registroU = array('registroBuzon' => $registroUsu);
            $guardo = $client->call("editarBuzon",$registroU);
            if ($guardo== "") {
                javaalert("No se han Guardado los datos del buzón, Consulte con el Admininistrador");
            } else {
                javaalert("Se han Guardado los datos del buzon");
                llenarLog(9, "Edicion de Buzon", $_SESSION["Usuario"]['idusu'], $_SESSION["Sede"]['idsed']);
            }
            iraURL('../pages/mailboxs.php');
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/edit_mailbox.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
?>