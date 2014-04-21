<?php

session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
    if (!isset($_SESSION["Usuario"])) {
        iraURL("../pages/index.php");
    } elseif (!usuarioCreado()) {
        iraURL("../pages/create_user.php");
    }

    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
  $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return']; 
	}
    $usuario = array('user' => $_SESSION["Usuario"]["userusu"]);
   // $Usuario = $client->consultarUsuarioXUser($usuario);
    $consumo = $client->call("consultarUsuarioXUser",$usuario);
	if ($consumo!="") {
	$Usuario = $consumo['return']; 
	}
	include("../views/view_user.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>