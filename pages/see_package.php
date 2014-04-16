<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

/* if (!isset($_SESSION["Usuario"])) {
  iraURL("../index.php");
  } elseif (!usuarioCreado()) {
  iraURL("../pages/create_user.php");
  } */

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["cli"] = $client;
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
        $paquete = array('idPaquete' => $idPaquete);
        $consumoSeguimiento = $client->call("consultarSeguimientoXPaquete", $paquete);
        if ($consumoSeguimiento != "") {
            $resultadoPaquete = $consumoSeguimiento['return'];
            if (isset($resultadoPaquete[0])) {
                $segumientoPaquete = count($resultadoPaquete);
            } else {
                $segumientoPaquete = 1;
            }
        } else {
            $segumientoPaquete = 0;
        }
        include("../views/see_package.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/inbox.php');
    }
}
?>