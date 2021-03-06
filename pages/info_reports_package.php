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
    if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$usuario = $_SESSION["Usuario"]['idusu'];
$ideSede = $_SESSION["Sede"]['idsed'];

$_SESSION["paquetes"] = "";

try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $Con = array('fechaInicio' => $_SESSION["Fechaini"],
        'fechaFinal' => $_SESSION["Fechafin"],
        'consulta' => $_SESSION["Reporte"],
        'idsede' => $_SESSION["Osede"]);
    $consumoPaquetes = $client->call("consultarEstadisticasPaquetes", $Con);

    if ($consumoPaquetes != "") {
        $resultadoConsultarPaquetes = $consumoPaquetes['return'];
        if (isset($resultadoConsultarPaquetes[0])) {
            $paquetes = count($resultadoConsultarPaquetes);
        } else {
            $paquetes = 1;
        }
		$_SESSION["paquetes"] = $resultadoConsultarPaquetes;
    } else {
        $paquetes = 0;
    }

    if ($paquetes > 0) {
        $reporte = $_SESSION["Reporte"];
        if ($reporte == '1') {
            $nombreReporte = "Paquetes Enviados";
        } elseif ($reporte == '2') {
            $nombreReporte = "Paquetes Recibidos";
        } elseif ($reporte == '3') {
            $nombreReporte = "Paquetes por Entregar";
        }
    }
    include("../views/info_reports_package.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/reports_package.php');
}
?>