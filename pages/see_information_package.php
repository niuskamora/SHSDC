<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["cli"] = $client;

if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
} else {
    iraURL('../pages/inbox.php');
}

$idPaquete = $_GET["id"];
$usuario = $_SESSION["Usuario"]['idusu'];

if ($idPaquete == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $idpaq = array('idPaquete' => $idPaquete);
        $consumoPaquete = $client->call("consultarPaqueteXId", $idpaq);
        if ($consumoPaquete != "") {
            $resultadoPaquete = $consumoPaquete['return'];
            if (isset($resultadoPaquete[0])) {
                $paquete = count($resultadoPaquete);
            } else {
                $paquete = 1;
            }
        } else {
            $paquete = 0;
        }

        $consumoAdjunto = $client->call("consultarAdjuntoXPaquete", $idpaq);
        if ($consumoAdjunto != "") {
            $resultadoAdjunto = $consumoAdjunto['return'];
            if (isset($resultadoAdjunto)) {
                $adjunto = 1;
            } else {
                $adjunto = 0;
            }
        } else {
            $adjunto = 0;
        }
        include("../views/see_information_package.php");
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../pages/inbox.php');
    }
}
?>