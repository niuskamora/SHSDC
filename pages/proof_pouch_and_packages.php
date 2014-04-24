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

$_SESSION["paquetesXValija"] = "";
$_SESSION["fechaEnvio"] = "";
$_SESSION["fechaRecibido"] = "";
$_SESSION["origenValija"] = "";

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
$usuarioBitacora = $_SESSION["Usuario"]["idusu"];
$idValija = $_GET["id"];

if ($idValija == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $parametros = array('registroValija' => $idValija,
            'sede' => $ideSede);
        $consumoPaqXValija = $client->call("ConsultarPaquetesXValija", $parametros);

        if ($consumoPaqXValija != "") {
            $resultadoPaquetesPorValija = $consumoPaqXValija['return'];
            if (isset($resultadoPaquetesPorValija[0])) {
                $contadorPaquetes = count($resultadoPaquetesPorValija);
            } else {
                $contadorPaquetes = 1;
            }
        } else {
            $contadorPaquetes = 0;
        }
        $paquetesXValija = $contadorPaquetes;

        if ($paquetesXValija > 1) {
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
            if (isset($resultadoPaquetesPorValija[0]['idval']['fechaval'])) {
                $fechaEnvio = FechaHora($resultadoPaquetesPorValija[0]['idval']['fechaval']);
            } else {
                $fechaEnvio = "";
            }
            if (isset($resultadoPaquetesPorValija[0]['idval']['fecharval'])) {
                $fechaRecibido = FechaHora($resultadoPaquetesPorValija['idval']['fecharval']);
            } else {
                $fechaRecibido = "";
            }
        } elseif ($paquetesXValija == 1) {
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
            if (isset($resultadoPaquetesPorValija['idval']['fechaval'])) {
                $fechaEnvio = FechaHora($resultadoPaquetesPorValija['idval']['fechaval']);
            } else {
                $fechaEnvio = "";
            }
            if (isset($resultadoPaquetesPorValija['idval']['fecharval'])) {
                $fechaRecibido = FechaHora($resultadoPaquetesPorValija['idval']['fecharval']);
            } else {
                $fechaRecibido = "";
            }
        }

        $_SESSION["fechaEnvio"] = $fechaEnvio;
        $_SESSION["fechaRecibido"] = $fechaRecibido;
        $_SESSION["paquetesXValija"] = $resultadoPaquetesPorValija;
        $_SESSION["origenValija"] = $origen;

        if (isset($resultadoPaquetesPorValija)) {
            llenarLog(6, "Comprobante de Detalle de Valija", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_pouch_and_packages.php');</script>";
            //iraURL('../pdf/proof_pouch_and_packages.php');
        }
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../pages/reports_valise.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>