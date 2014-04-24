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
        if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
            iraURL('../pages/inbox.php');
        }
    }
} else {
    iraURL('../pages/inbox.php');
}

$ideSede = $_SESSION["Sede"]['idsed'];
$usuario = $_SESSION["Usuario"]['idusu'];

$_SESSION["valijas"] = "";
$_SESSION["nombreSede"] = "";

try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $Con = array('fechaInicio' => $_SESSION["Fechaini"],
        'fechaFinal' => $_SESSION["Fechafin"],
        'consulta' => $_SESSION["Reporte"],
        'idsede' => $_SESSION["Osede"]);
    $consumoValijas = $client->call("consultarEstadisticasValijas", $Con);

    if ($consumoValijas != "") {
        $resultadoConsultarValijas = $consumoValijas['return'];
        if (isset($resultadoConsultarValijas[0])) {
            $valijas = count($resultadoConsultarValijas);
        } else {
            $valijas = 1;
        }
    } else {
        $valijas = 0;
    }

    $_SESSION["valijas"] = $resultadoConsultarValijas;

    if ($valijas > 0) {
        $reporte = $_SESSION["Reporte"];
        if ($reporte == '1') {
            $nombreReporte = "Valijas Enviadas";
        } elseif ($reporte == '2') {
            $nombreReporte = "Valijas Recibidas";
        } elseif ($reporte == '3') {
            $nombreReporte = "Valijas con Errores";
        } elseif ($reporte == '4') {
            $nombreReporte = "Valijas Anuladas";
        }
        if ($valijas > 1) {
            for ($i = 0; $i < $valijas; $i++) {
                $idSed = $resultadoConsultarValijas[$i]['origenval'];
                $idSede = array('idSede' => $idSed);
                $consumoSede = $client->call("consultarSedeXId", $idSede);
                if ($consumoSede != "") {
                    $resultadoConsultarSede = $consumoSede['return'];
                    if (isset($resultadoConsultarSede)) {
                        $nombreSede[$i] = $resultadoConsultarSede['nombresed'];
                    } else {
                        $nombreSede[$i] = "";
                    }
                } else {
                    $nombreSede[$i] = "";
                }
                $_SESSION["nombreSede"][$i] = $nombreSede[$i];
            }
        } else {
            $idSed = $resultadoConsultarValijas['origenval'];
            $idSede = array('idSede' => $idSed);
            $consumoSede = $client->call("consultarSedeXId", $idSede);
            if ($consumoSede != "") {
                $resultadoConsultarSede = $consumoSede['return'];
                if (isset($resultadoConsultarSede)) {
                    $nombreSede = $resultadoConsultarSede['nombresed'];
                } else {
                    $nombreSede = "";
                }
            } else {
                $nombreSede = "";
            }
            $_SESSION["nombreSede"] = $nombreSede;
        }
    }
    include("../views/info_reports_valise.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/reports_valise.php');
}
?>