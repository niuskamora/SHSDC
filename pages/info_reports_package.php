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

if ($_SESSION["Usuario"]->return->tipousu != "1" && $_SESSION["Usuario"]->return->tipousu != "2") {
    iraURL('../pages/inbox.php');
}

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);
if (isset($SedeRol->return)) {
    if ($SedeRol->return->idrol->idrol == 0) {
        iraURL("../pages/inbox.php");
    }
} else {
    iraURL('../pages/inbox.php');
}

$ideSede = $_SESSION["Sede"]->return->idsed;
$usuario = $_SESSION["Usuario"]->return->idusu;

$_SESSION["paquetes"] = "";

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $Con = array('fechaInicio' => $_SESSION["Fechaini"],
        'fechaFinal' => $_SESSION["Fechafin"],
        'consulta' => $_SESSION["Reporte"],
        'idsede' => $_SESSION["Osede"]);
    $resultadoConsultarPaquetes = $client->consultarEstadisticasPaquetes($Con);

    if (isset($resultadoConsultarPaquetes->return)) {
        $paquetes = count($resultadoConsultarPaquetes->return);
    } else {
        $paquetes = 0;
    }

    $_SESSION["paquetes"] = $resultadoConsultarPaquetes;

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
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/reports_package.php');
}
?>