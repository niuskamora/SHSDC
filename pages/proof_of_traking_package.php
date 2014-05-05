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

$_SESSION["trakingPaquete"] = "";
$_SESSION["fecha"] = "";

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
} else {
    iraURL('../pages/inbox.php');
}

$nomUsuario = $_SESSION["Usuario"]['userusu'];
$ideSede = $_SESSION["Sede"]['idsed'];
$usuarioBitacora = $_SESSION["Usuario"]['idusu'];
$idPaquete = $_GET["id"];

if ($idPaquete == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $paquete = array('idPaquete' => $idPaquete);
        $consumoSeguimiento = $client->call("consultarSeguimientoXPaquete", $paquete);
        if ($consumoSeguimiento != "") {
            $resultadoPaquete = $consumoSeguimiento['return'];
            if (isset($resultadoPaquete[0])) {
                $seguimientoPaquete = count($resultadoPaquete);
            } else {
                $seguimientoPaquete = 1;
            }
			$_SESSION["trakingPaquete"] = $resultadoPaquete;
        } else {
            $seguimientoPaquete = 0;
        }
        if ($seguimientoPaquete > 1) {
            for ($i = 0; $i < $seguimientoPaquete; $i++) {
                if (isset($resultadoPaquete[$i]['fechaseg'])) {
                    $fecha[$i] = FechaHora($resultadoPaquete[$i]['fechaseg']);
                } else {
                    $fecha[$i] = "";
                }
                $_SESSION["fecha"][$i] = $fecha[$i];
            }
        } elseif ($seguimientoPaquete == 1) {
            if (isset($resultadoPaquete['fechaseg'])) {
                $fecha = FechaHora($resultadoPaquete['fechaseg']);
            } else {
                $fecha = "";
            }
            $_SESSION["fecha"] = $fecha;
        }

        if (isset($resultadoPaquete)) {
            llenarLog(6, "Comprobante de Tracking de Paquete", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_of_traking_package.php');</script>";
            //iraURL('../pdf/proof_of_traking_package.php');
        }
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../pages/inbox.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>