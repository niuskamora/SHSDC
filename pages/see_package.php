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

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

$idPaquete = $_GET["id"];
$usuario = $_SESSION["Usuario"]->return->idusu;

if ($idPaquete == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $paquete = array('idPaquete' => $idPaquete);
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $resultadoPaquete = $client->consultarSeguimientoXPaquete($paquete);

        if (!isset($resultadoPaquete->return)) {
            $segumientoPaquete = 0;
        } else {
            $segumientoPaquete = count($resultadoPaquete->return);
        }
        include("../views/see_package.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/inbox.php');
    }
}
?>