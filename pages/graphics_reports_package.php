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

$resultadoConsultarPaquetes = $_SESSION["paquetes"];
if(isset($resultadoConsultarPaquetes->return)){
	$contadorPaquetes = count($resultadoConsultarPaquetes->return);
}else{
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
                    $resultadoConsultarPaquetes = $client->consultarEstadisticasPaquetes($Con);
					if(isset($resultadoConsultarPaquetes->return)){
                    	$paquetes[$i] = count($resultadoConsultarPaquetes->return);
					}else{
						$paquetes[$i] = 0;
					}
                }
            } else {
                $nombreSede = $resultadoSedes->return->nombresed;
                $Con = array('fechaInicio' => $fechaIni,
                    'fechaFinal' => $fechaFin,
                    'consulta' => $reporte,
                    'idsede' => $resultadoSedes->return->idsed);
                $resultadoConsultarPaquetes = $client->consultarEstadisticasPaquetes($Con);
                if(isset($resultadoConsultarPaquetes->return)){
                	$paquetes = count($resultadoConsultarPaquetes->return);
				}else{
					$paquetes = 0;
				}
            }
        } else {
            $contadorSedes = 0;
        }
        include("../graphics/reports_package_horizontally.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_package.php');
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
        include("../graphics/reports_package_vertical.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_package.php');
    }
}
?>