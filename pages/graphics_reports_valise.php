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

$resultadoConsultarValijas = $_SESSION["valijas"];
if(isset($resultadoConsultarValijas->return)){
	$contadorValijas = count($resultadoConsultarValijas->return);
}else{
	$contadorValijas = 0;
}
$sede = $_SESSION["Osede"];

$reporte = $_SESSION["Reporte"];
$fechaIni = $_SESSION["Fechaini"];
$fechaFin = $_SESSION["Fechafin"];

if ($reporte == '1') {
    $nombreReporte = "Valijas Enviadas";
} elseif ($reporte == '2') {
    $nombreReporte = "Valijas Recibidas";
} elseif ($reporte == '3') {
    $nombreReporte = "Valijas con Errores";
} elseif ($reporte == '4') {
    $nombreReporte = "Valijas Anuladas";
}
$contadorSedes = 0;
$opcionSede = "";
if ($sede == '0') {
    try {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $resultadoSedes = $client->listarSedes();
        if (isset($resultadoSedes->return)) {
            $contadorSedes = count($resultadoSedes->return);
            if ($contadorSedes > 1) {
                for ($i = 0; $i < $contadorSedes; $i++) {
                    $nombreSede[$i] = $resultadoSedes->return[$i]->nombresed;
                    $Con = array('fechaInicio' => $fechaIni,
                        'fechaFinal' => $fechaFin,
                        'consulta' => $reporte,
                        'idsede' => $resultadoSedes->return[$i]->idsed);
                    $resultadoConsultarValijas = $client->consultarEstadisticasValijas($Con);
					if(isset($resultadoConsultarValijas->return)){
                    	$valijas[$i] = count($resultadoConsultarValijas->return);
					}
					else{
						$valijas[$i] = 0;
					}
                }
            } else {
                $nombreSede = $resultadoSedes->return->nombresed;
                $Con = array('fechaInicio' => $fechaIni,
                    'fechaFinal' => $fechaFin,
                    'consulta' => $reporte,
                    'idsede' => $resultadoSedes->return->idsed);
                $resultadoConsultarValijas = $client->consultarEstadisticasValijas($Con);
                if(isset($resultadoConsultarValijas->return)){
                	$valijas = count($resultadoConsultarValijas->return);
				}
				else{
					$valijas = 0;
				}
            }
        } else {
            $contadorSedes = 0;
        }
        include("../graphics/reports_valise_horizontally.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_valise.php');
    }
} else {
    try {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $idSede = array('idSede' => $sede);
        $resultadoConsultarSede = $client->consultarSedeXId($idSede);
        if (isset($resultadoConsultarSede->return)) {
            $opcionSede = $resultadoConsultarSede->return->nombresed;
        } else {
            $cpcionSede = "";
        }
        include("../graphics/reports_valise_vertical.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_valise.php');
    }
}
?>