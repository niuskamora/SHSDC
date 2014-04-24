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

$nomUsuario = $_SESSION["Usuario"]["userusu"];
$idesede = $_SESSION["Sede"]["idsed"];

$_SESSION["paquetesConfirmados"] = "";
$_SESSION["paquetes"] = "";
$_SESSION["codigos"] = "";


try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $usuSede = array('iduse' => $SedeRol['iduse'],
        'idrol' => $SedeRol['idrol'],
        'idsed' => $SedeRol['idsed']);
    $parametros = array('idUsuarioSede' => $usuSede);
    $consumoConfirmados = $client->call("consultarPaquetesConfirmadosXRol", $parametros);

    if ($consumoConfirmados != "") {
        $resultadoPaquetesConfirmados = $consumoConfirmados['return'];
        if (isset($resultadoPaquetesConfirmados[0])) {
            $paquetes = count($resultadoPaquetesConfirmados);
        } else {
            $paquetes = 1;
        }
    } else {
        $paquetes = 0;
    }
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/confirm_package.php');
}

if (isset($_POST["imprimir"])) {

    if (isset($_POST["ide"])) {

        $imprimirPaquetes = $_POST["ide"];
        for ($i = 0; $i < count($imprimirPaquetes); $i++) {
            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $idPaquete = array('idPaquete' => $imprimirPaquetes[$i]);
            $consumoPaquete = $client->call("consultarPaqueteXId", $idPaquete);
            if ($consumoPaquete != "") {
                $resultadoPaquete = $consumoPaquete['return'];
            }
            if (isset($resultadoPaquete)) {
                $idpaq[$i] = $resultadoPaquete['idpaq'];

                if (isset($resultadoPaquete['fechapaq'])) {
                    $fecha = FechaHora($resultadoPaquete['fechapaq']);
                } else {
                    $fecha = "";
                }
                //Año de envio del paquete
                $fechaCod = (substr($fecha, 6, 4));

                $sedPaq = $resultadoPaquete['idsed']['idsed'];
                $idSede = array('idSede' => $sedPaq);
                $consumoSede = $client->call("consultarSedeXId", $idSede);
                if ($consumoSede != "") {
                    $resultadoConsultarSede = $consumoSede['return'];
                }
                if (isset($resultadoConsultarSede)) {
                    $codigoSede = $resultadoConsultarSede['codigosed'];
                }

                //Código total codigosede+añopaquete+idpaquete
                $codigoTotal[$i] = $codigoSede . $fechaCod . $idpaq[$i];
                guardarImagen($codigoTotal[$i]);
                $_SESSION["codigos"][$i] = $codigoTotal[$i];
            }
        }
        $_SESSION["paquetesConfirmados"] = $resultadoPaquetesConfirmados;
        $_SESSION["paquetes"] = $imprimirPaquetes;
        iraURL('../pages/proof_package_confirmed.php');
    } else {
        javaalert("Debe seleccionar al menos un paquete, por favor verifique");
    }
}
include("../views/print_packages_confirmed.php");
?>