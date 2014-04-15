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

try {
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
    if (!isset($_GET["id"])) {
        iraURL('../pages/inbox.php');
    }
    $idValija = $_GET["id"];
    if ($idValija == "") {
        iraURL('../pages/reports_valise.php');
    }
    $parametros = array('registroValija' => $idValija,
        'sede' => $ideSede);
    $resultadoPaquetesPorValija = $client->ConsultarPaquetesXValija($parametros);

    if (!isset($resultadoPaquetesPorValija->return)) {
        $paquetesXValija = 0;
    } else {
        $paquetesXValija = count($resultadoPaquetesPorValija->return);
        $contadorPaquetes = $paquetesXValija;
    }
    $fechaEnvio = "";
    $fechaRecibido = "";
    $guia = "";
    $tipo = "";
    $destino = "";
    //Datos de la Valija
    if ($paquetesXValija == 1) {
        $idOrigen = array('idSede' => $resultadoPaquetesPorValija->return->idval->origenval);
        if (isset($resultadoPaquetesPorValija->return->idval->fechaval)) {
            $fechaEnvio = FechaHora($resultadoPaquetesPorValija->return->idval->fechaval);
        }
        if (isset($resultadoPaquetesPorValija->return->idval->fecharval)) {
            $fechaRecibido = FechaHora($resultadoPaquetesPorValija->return->idval->fecharval);
        }
        if (isset($resultadoPaquetesPorValija->return->idval->codproveedorval)) {
            $guia = $resultadoPaquetesPorValija->return->idval->codproveedorval;
        }
        if (isset($resultadoPaquetesPorValija->return->idval->tipoval)) {
            $tipo = $resultadoPaquetesPorValija->return->idval->tipoval;
        }
        if (isset($resultadoPaquetesPorValija->return->idval->destinoval->nombresed)) {
            $destino = $resultadoPaquetesPorValija->return->idval->destinoval->nombresed;
        }
        $idVal = $resultadoPaquetesPorValija->return->idval->idval;
		$resultadoOrigen = $client->consultarSedeXId($idOrigen);
        if (isset($resultadoOrigen->return->nombresed)) {
            $origen = $resultadoOrigen->return->nombresed;
        } else {
            $origen = "";
        }
    } elseif ($paquetesXValija > 1) {
        $idOrigen = array('idSede' => $resultadoPaquetesPorValija->return[0]->idval->origenval);
        if (isset($resultadoPaquetesPorValija->return[0]->idval->fechaval)) {
            $fechaEnvio = FechaHora($resultadoPaquetesPorValija->return[0]->idval->fechaval);
        }
        if (isset($resultadoPaquetesPorValija->return[0]->idval->fecharval)) {
            $fechaRecibido = FechaHora($resultadoPaquetesPorValija->return[0]->idval->fecharval);
        }
        if (isset($resultadoPaquetesPorValija->return[0]->idval->codproveedorval)) {
            $guia = $resultadoPaquetesPorValija->return[0]->idval->codproveedorval;
        }
        if (isset($resultadoPaquetesPorValija->return[0]->idval->tipoval)) {
            $tipo = $resultadoPaquetesPorValija->return[0]->idval->tipoval;
        }
        if (isset($resultadoPaquetesPorValija->return[0]->idval->destinoval->nombresed)) {
            $destino = $resultadoPaquetesPorValija->return[0]->idval->destinoval->nombresed;
        }
        $idVal = $resultadoPaquetesPorValija->return[0]->idval->idval;
		$resultadoOrigen = $client->consultarSedeXId($idOrigen);
        if (isset($resultadoOrigen->return->nombresed)) {
            $origen = $resultadoOrigen->return->nombresed;
        } else {
            $origen = "";
        }
    }
    include("../views/bag_and_pack.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/reports_valise.php');
}
?>