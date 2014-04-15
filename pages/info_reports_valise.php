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

if (isset($SedeRol->return)) {
    if ($SedeRol->return->idrol->idrol != "4" && $SedeRol->return->idrol->idrol != "5") {
        if ($_SESSION["Usuario"]->return->tipousu != "1" && $_SESSION["Usuario"]->return->tipousu != "2") {
            iraURL('../pages/inbox.php');
        }
    }
} else {
    iraURL('../pages/inbox.php');
}

$ideSede = $_SESSION["Sede"]->return->idsed;
$usuario = $_SESSION["Usuario"]->return->idusu;

$_SESSION["valijas"] = "";
$_SESSION["nombreSede"] = "";

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $Con = array('fechaInicio' => $_SESSION["Fechaini"],
        'fechaFinal' => $_SESSION["Fechafin"],
        'consulta' => $_SESSION["Reporte"],
        'idsede' => $_SESSION["Osede"]);
    $resultadoConsultarValijas = $client->consultarEstadisticasValijas($Con);

    if (isset($resultadoConsultarValijas->return)) {
        $valijas = count($resultadoConsultarValijas->return);
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
                $idSed = $resultadoConsultarValijas->return[$i]->origenval;
                $idSede = array('idSede' => $idSed);
                $resultadoConsultarSede = $client->consultarSedeXId($idSede);
                if (isset($resultadoConsultarSede->return->nombresed)) {
                    $nombreSede[$i] = $resultadoConsultarSede->return->nombresed;
                } else {
                    $nombreSede[$i] = "";
                }
                $_SESSION["nombreSede"][$i] = $nombreSede[$i];
            }
        } else {
            $idSed = $resultadoConsultarValijas->return->origenval;
            $idSede = array('idSede' => $idSed);
            $resultadoConsultarSede = $client->consultarSedeXId($idSede);
            if (isset($resultadoConsultarSede->return->nombresed)) {
                $nombreSede = $resultadoConsultarSede->return->nombresed;
            } else {
                $nombreSede = "";
            }
            $_SESSION["nombreSede"] = $nombreSede;
        }
    }
    include("../views/info_reports_valise.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/reports_valise.php');
}
?>