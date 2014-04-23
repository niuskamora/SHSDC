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
    if ($SedeRol['idrol']['idrol'] != "4" && $SedeRol['idrol']['idrol'] != "5") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$ideSede = $_SESSION["Sede"]['idsed'];
$usuario = $_SESSION["Usuario"]['idusu'];

$idValija = $_GET["id"];
if ($idValija == "") {
    iraURL('../pages/lost_bag.php');
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $Con = array('idval' => $idValija);
        $consumoIncidente = $client->call("listarIncidentesXValija", $Con);

        if ($consumoIncidente != "") {
            $resultadoIncidente = $consumoIncidente['return'];
            if (isset($resultadoIncidente[0])) {
                $incidente = count($resultadoIncidente);
            } else {
                $incidente = 1;
            }
        } else {
            $incidente = 0;
        }
        include("../views/see_incident.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/inbox.php');
    }
}
?>