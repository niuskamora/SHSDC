<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["cli"]=$client;

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
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$ideSede = $_SESSION["Sede"]['idsed'];
$usuario = $_SESSION["Usuario"]['idusu'];

try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $Con = array('idusu' => $usuario,
        'idsede' => $ideSede);
    $consumoValijas = $client->call("consultarStatusValija", $Con);

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

    if ($valijas > 0) {
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
        }
    }
    include("../views/lost_bag.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>