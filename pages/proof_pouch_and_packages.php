<?php

session_start();
include("../recursos/funciones.php");
include("../recursos/codigoBarrasPdf.php");
require_once('../lib/nusoap.php');

if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}

$_SESSION["paquetesXValija"] = "";
$_SESSION["fechaEnvio"] = "";
$_SESSION["fechaRecibido"] = "";
$_SESSION["origenValija"] = "";

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

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$ideSede = $_SESSION["Sede"]->return->idsed;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$idValija = $_GET["id"];

if ($idValija == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $parametros = array('registroValija' => $idValija,
            'sede' => $ideSede);
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $resultadoPaquetesPorValija = $client->ConsultarPaquetesXValija($parametros);

        if (!isset($resultadoPaquetesPorValija->return)) {
            $paquetesXValija = 0;
        } else {
            $paquetesXValija = count($resultadoPaquetesPorValija->return);
        }

        if ($paquetesXValija > 1) {
            $idOrigen = array('idSede' => $resultadoPaquetesPorValija->return[0]->idval->origenval);
            $resultadoOrigen = $client->consultarSedeXId($idOrigen);
            if (isset($resultadoPaquetesPorValija->return[0]->idval->fechaval)) {
                $fechaEnvio = FechaHora($resultadoPaquetesPorValija->return[0]->idval->fechaval);
            } else {
                $fechaEnvio = "";
            }
            if (isset($resultadoPaquetesPorValija->return[0]->idval->fecharval)) {
                $fechaRecibido = FechaHora($resultadoPaquetesPorValija->return[0]->idval->fecharval);
            } else {
                $fechaRecibido = "";
            }
        } elseif ($paquetesXValija == 1) {
            $idOrigen = array('idSede' => $resultadoPaquetesPorValija->return->idval->origenval);
            $resultadoOrigen = $client->consultarSedeXId($idOrigen);
            if (isset($resultadoPaquetesPorValija->return->idval->fechaval)) {
                $fechaEnvio = FechaHora($resultadoPaquetesPorValija->return->idval->fechaval);
            } else {
                $fechaEnvio = "";
            }
            if (isset($resultadoPaquetesPorValija->return->idval->fecharval)) {
                $fechaRecibido = FechaHora($resultadoPaquetesPorValija->return->idval->fecharval);
            } else {
                $fechaRecibido = "";
            }
        }

        $_SESSION["fechaEnvio"] = $fechaEnvio;
        $_SESSION["fechaRecibido"] = $fechaRecibido;
        $_SESSION["paquetesXValija"] = $resultadoPaquetesPorValija;
        $_SESSION["origenValija"] = $resultadoOrigen;

        if (isset($resultadoPaquetesPorValija->return)) {
            llenarLog(6, "Comprobante de Detalle de Valija", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_pouch_and_packages.php');</script>";
            //iraURL('../pdf/proof_pouch_and_packages.php');
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_valise.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>