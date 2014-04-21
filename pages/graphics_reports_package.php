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

$resultadoConsultarPaquetes = $_SESSION["paquetes"];
if (isset($resultadoConsultarPaquetes)) {
    if (isset($resultadoConsultarPaquetes[0])) {
        $contadorPaquetes = count($resultadoConsultarPaquetes);
    } else {
        $contadorPaquetes = 1;
    }
} else {
    $contadorPaquetes = 0;
}

$sede = $_SESSION["Osede"];
$reporte = $_SESSION["Reporte"];
$fechaIni = $_SESSION["Fechaini"];
$fechaFin = $_SESSION["Fechafin"];

if ($reporte == '1') {
    $nombreReporte = "Paquetes Enviados";
} elseif ($reporte == '2') {
    $nombreReporte = "Paquetes Recibidos";
} elseif ($reporte == '3') {
    $nombreReporte = "Paquetes por Entregar";
}

$contadorSedes = 0;
$opcionSede = "";
if ($sede == '0') {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $consumoSedes = $client->call("listarSedes");
        if ($consumoSedes != "") {
            $resultadoSedes = $consumoSedes['return'];
            if (isset($resultadoSedes[0])) {
                $contadorSedes = count($resultadoSedes);
            } else {
                $contadorSedes = 1;
            }
        } else {
            $contadorSedes = 0;
        }
        if ($contadorSedes > 1) {
            for ($i = 0; $i < $contadorSedes; $i++) {
                $nombreSede[$i] = $resultadoSedes[$i]['nombresed'];
                $client = new nusoap_client($wsdl_sdc, 'wsdl');
                $Con = array('fechaInicio' => $fechaIni,
                    'fechaFinal' => $fechaFin,
                    'consulta' => $reporte,
                    'idsede' => $resultadoSedes[$i]['idsed']);
                $consumoPaquetes = $client->call("consultarEstadisticasPaquetes", $Con);
                if ($consumoPaquetes != "") {
                    $resultadoConsultarPaquetes = $consumoPaquetes['return'];
                    if (isset($resultadoConsultarPaquetes[0])) {
                        $paquetes[$i] = count($resultadoConsultarPaquetes);
                    } else {
                        $paquetes[$i] = 1;
                    }
                } else {
                    $paquetes[$i] = 0;
                }
            }
        } else {
            $nombreSede = $resultadoSedes['nombresed'];
            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $Con = array('fechaInicio' => $fechaIni,
                'fechaFinal' => $fechaFin,
                'consulta' => $reporte,
                'idsede' => $resultadoSedes['idsed']);
            $consumoPaquetes = $client->call("consultarEstadisticasPaquetes", $Con);
            if ($consumoPaquetes != "") {
                $resultadoConsultarPaquetes = $consumoPaquetes['return'];
                if (isset($resultadoConsultarPaquetes[0])) {
                    $paquetes = count($resultadoConsultarPaquetes);
                } else {
                    $paquetes = 1;
                }
            } else {
                $paquetes = 0;
            }
        }
        include("../graphics/reports_package_horizontally.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_package.php');
    }
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $idSede = array('idSede' => $sede);
        $consumoSede = $client->call("consultarSedeXId", $idSede);
        if ($consumoSede != "") {
            $resultadoConsultarSede = $consumoSede['return'];
            if (isset($resultadoConsultarSede)) {
                $opcionSede = $resultadoConsultarSede['nombresed'];
            } else {
                $opcionSede = "";
            }
        } else {
            $opcionSede = "";
        }
        include("../graphics/reports_package_vertical.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_package.php');
    }
}
?>