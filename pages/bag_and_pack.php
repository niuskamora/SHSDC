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

$nomUsuario = $_SESSION["Usuario"]["userusu"];
$ideSede = $_SESSION["Sede"]["idsed"];

$idValija = $_GET["id"];
if ($idValija == "") {
    iraURL('../pages/reports_valise.php');
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $parametros = array('registroValija' => $idValija,
            'sede' => $ideSede);
        $consumoPaqXValija = $client->call("ConsultarPaquetesXValija", $parametros);

        if ($consumoPaqXValija != "") {
            $resultadoPaquetesPorValija = $consumoPaqXValija['return'];
            if (isset($resultadoPaquetesPorValija[0])) {
                $contadorPaquetes = count($resultadoPaquetesPorValija->return);
            } else {
                $contadorPaquetes = 1;
            }
        } else {
            $contadorPaquetes = 0;
        }

        $paquetesXValija = $contadorPaquetes;

        $fechaEnvio = "";
        $fechaRecibido = "";
        $guia = "";
        $tipo = "";
        $destino = "";
        //Datos de la Valija
        if ($paquetesXValija == 1) {
            if (isset($resultadoPaquetesPorValija['idval']['fechaval'])) {
                $fechaEnvio = FechaHora($resultadoPaquetesPorValija['idval']['fechaval']);
            }
            if (isset($resultadoPaquetesPorValija['idval']['fecharval'])) {
                $fechaRecibido = FechaHora($resultadoPaquetesPorValija['idval']['fecharval']);
            }
            if (isset($resultadoPaquetesPorValija['idval']['codproveedorval'])) {
                $guia = $resultadoPaquetesPorValija['idval']['codproveedorval'];
            }
            if (isset($resultadoPaquetesPorValija['idval']['tipoval'])) {
                $tipo = utf8_encode($resultadoPaquetesPorValija['idval']['tipoval']);
            }
            if (isset($resultadoPaquetesPorValija['idval']['destinoval']['nombresed'])) {
                $destino = utf8_encode($resultadoPaquetesPorValija['idval']['destinoval']['nombresed']);
            }
            $idVal = $resultadoPaquetesPorValija['idval']['idval'];

            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $idOrigen = array('idSede' => $resultadoPaquetesPorValija['idval']['origenval']);
            $consumoSede = $client->call("consultarSedeXId", $idOrigen);
            if ($consumoSede != "") {
                $resultadoConsultarSede = $consumoSede['return'];
                if (isset($resultadoConsultarSede)) {
                    $origen = utf8_encode($resultadoConsultarSede['nombresed']);
                } else {
                    $origen = "";
                }
            } else {
                $origen = "";
            }
        } elseif ($paquetesXValija > 1) {
            if (isset($resultadoPaquetesPorValija[0]['idval']['fechaval'])) {
                $fechaEnvio = FechaHora($resultadoPaquetesPorValija[0]['idval']['fechaval']);
            }
            if (isset($resultadoPaquetesPorValija[0]['idval']['fecharval'])) {
                $fechaRecibido = FechaHora($resultadoPaquetesPorValija[0]['idval']['fecharval']);
            }
            if (isset($resultadoPaquetesPorValija[0]['idval']['codproveedorval'])) {
                $guia = $resultadoPaquetesPorValija[0]['idval']['codproveedorval'];
            }
            if (isset($resultadoPaquetesPorValija[0]['idval']['tipoval'])) {
                $tipo = utf8_encode($resultadoPaquetesPorValija[0]['idval']['tipoval']);
            }
            if (isset($resultadoPaquetesPorValija[0]['idval']['destinoval']['nombresed'])) {
                $destino = utf8_encode($resultadoPaquetesPorValija[0]['idval']['destinoval']['nombresed']);
            }
            $idVal = $resultadoPaquetesPorValija[0]['idval']['idval'];

            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $idOrigen = array('idSede' => $resultadoPaquetesPorValija[0]['idval']['origenval']);
            $consumoSede = $client->call("consultarSedeXId", $idOrigen);
            if ($consumoSede != "") {
                $resultadoConsultarSede = $consumoSede['return'];
                if (isset($resultadoConsultarSede)) {
                    $origen = utf8_encode($resultadoConsultarSede['nombresed']);
                } else {
                    $origen = "";
                }
            } else {
                $origen = "";
            }
        }
        include("../views/bag_and_pack.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_valise.php');
    }
}
?>