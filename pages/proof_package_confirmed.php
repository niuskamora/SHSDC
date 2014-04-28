<?php

session_start();
include("../recursos/funciones.php");
include("../recursos/codigoBarrasPdf.php");
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

$paquetes = $_SESSION["paquetes"];
$paquetesConfirmados = $_SESSION["paquetesConfirmados"];
$usuarioBitacora = $_SESSION["Usuario"]["idusu"];
$sede = $_SESSION["Sede"]["idsed"];
$codigos = $_SESSION["codigos"];

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
    if ($SedeRol['idrol']['idrol'] != "1" && $SedeRol['idrol']['idrol'] != "3") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$_SESSION["paquetesTotales"] = "";
$_SESSION["rol"] = "";

try {
    $i = 0;
    $contadorPaq = 0;
    $paquetesTotales = "";

    if (isset($paquetesConfirmados[0])) {
        $contPaq = count($paquetesConfirmados);
    } else {
        $contPaq = 1;
    }

    for ($j = 0; $j < $contPaq; $j++) {
        if (isset($paquetes[$j])) {
            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $idPaquete = array('idPaquete' => $paquetes[$j]);
            $consumoPaquete = $client->call("consultarPaqueteXId", $idPaquete);
            if ($consumoPaquete != "") {
                $resultadoPaquete = $consumoPaquete['return'];
				$paquetesTotales[$i] = $resultadoPaquete;
            	$_SESSION["paquetesTotales"][$i] = $paquetesTotales[$i];
            	$i++;
            	$contadorPaq++;
            }
        }
        if ($contadorPaq == count($paquetes)) {
            break;
        }
    }
    if ($paquetesTotales != "") {
        $contadorPaquetes = count($paquetesTotales);
        $_SESSION["rol"] = $SedeRol['idrol']['nombrerol'];
        llenarLog(6, "Comprobante de Paquetes Confirmados", $usuarioBitacora, $sede);
        echo"<script>window.open('../pdf/proof_package_confirmed.php');</script>";
        //iraURL('../pdf/proof_package_confirmed.php');
    } else {
        $contadorPaquetes = 0;
    }
    iraURL('../pages/print_packages_confirmed.php');
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/print_packages_confirmed.php');
}
?>