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
    $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);
    $usuario = array('user' => $_SESSION["Usuario"]->return->userusu);
    $Usuario = $client->consultarUsuarioXUser($usuario);
    include("../views/view_user.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>