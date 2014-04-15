<?php

session_start();
try {
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

    if (!isset($_SESSION["Usuario"])) {
        iraURL("../index.php");
    } elseif (!usuarioCreado()) {
        iraURL("../pages/create_user.php");
    }
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $i = 0;
    $reg = 0;
    $Sede = array('sede' => $_SESSION["Sede"]->return->nombresed);

    $Sedes = $client->ConsultarSedeParaValija($Sede);
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);
    if ($SedeRol->return->idrol->idrol == "4" || $SedeRol->return->idrol->idrol == "5") {
        if (isset($Sedes->return)) {
            $reg = count($Sedes->return);
        }
        $verificacion = 1;
    } else {
        iraURL('../pages/inbox.php');
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
include("../views/create_valise.php");
?>