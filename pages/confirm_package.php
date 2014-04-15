<?php

session_start();

include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}
try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);
    if (isset($SedeRol->return)) {
        if ($SedeRol->return->idrol->idrol != "1" && $SedeRol->return->idrol->idrol != "2" && $SedeRol->return->idrol->idrol != "3" && $SedeRol->return->idrol->idrol != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }
    $usuSede = array('iduse' => $SedeRol->return->iduse,
        'idrol' => $SedeRol->return->idrol,
        'idsed' => $SedeRol->return->idsed);
    $parametros = array('idUsuarioSede' => $usuSede);
    $PaquetesConfirmados = $client->consultarPaquetesConfirmadosXRol($parametros);
    include("../views/confirm_package.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>