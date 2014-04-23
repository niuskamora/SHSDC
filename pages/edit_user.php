<?php

session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
  $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$_SESSION["cli"]=$client;
	if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
	} elseif (!usuarioCreado()) {
		iraURL("../pages/create_user.php");
	}
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
    } else {
        iraURL('../pages/inbox.php');
    }   
    $usuario = array('user' => $_SESSION["Usuario"]["userusu"]);
    //$Usuario = $client->consultarUsuarioXUser($usuario);
	$consumo = $client->call("consultarUsuarioXUser",$usuario);
	if ($consumo!="") {
	$Usuario = $consumo['return'];   
    }
    if (isset($_POST["guardar"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["apellido"]) && $_POST["apellido"] != "" && isset($_POST["correo"]) && $_POST["correo"] != "") {
            $telefono1 = "";
            $telefono2 = "";
            $direccion1 = "";
            if (isset($_POST["telefono1"])) {
                $telefono1 = $_POST["telefono1"];
            }
            if (isset($_POST["telefono2"])) {
                $telefono2 = $_POST["telefono2"];
            }
            if (isset($_POST["direccion1"])) {
                $direccion1 = $_POST["direccion1"];
            }

            if (preg_match('{^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$}', $_POST["correo"])) {
                $correo = $_POST["correo"];
                $registroUsu =
                        array(
                            'idusu' => $Usuario["idusu"],
                            'nombreusu' => utf8_decode($_POST["nombre"]),
                            'apellidousu' => utf8_decode($_POST["apellido"]),
                            'correousu' => utf8_decode($correo),
                            'direccionusu' => utf8_decode($direccion1),
                            'telefonousu' => utf8_decode($telefono1),
                            'telefono2usu' => utf8_decode($telefono2),
                            'userusu' => utf8_decode($Usuario["userusu"]));
                $registroU = array('registroUsuario' => $registroUsu);
               	$consumo = $client->call("editarUsuario",$registroU);
				if($consumo!=""){
				$guardo=$consumo["return"];
				$userparam['user'] = $_SESSION["Usuario"]["userusu"];
				$userResp = $client->call("consultarUsuarioXUser",$userparam);
				 $_SESSION["Usuario"] = $userResp['return'];
				}
			   // $guardo = $client->editarUsuario($registroU);
                if ($guardo == 0) {
                    javaalert("No se han Guardado los datos del Usuario, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos del Usuario");
                    llenarLog(9, "Edición de Usuario", $_SESSION["Usuario"]["idusu"], $_SESSION["Sede"]["idsed"]);
                }
                iraURL('../pages/inbox.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/edit_user.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>