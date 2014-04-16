<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

/* if (!isset($_SESSION["Usuario"])) {
  iraURL("../index.php");
  } elseif (!usuarioCreado()) {
  iraURL("../pages/create_user.php");
  } */

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["cli"]=$client;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
    if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$_SESSION["fechaEnvio"] = "";
$resultadoConsultarPaquetes = $_SESSION["paquetes"];

$nomUsuario = $_SESSION["Usuario"]['userusu'];
$ideSede = $_SESSION["Sede"]['idsed'];
$usuarioBitacora = $_SESSION["Usuario"]['idusu'];

if (isset($resultadoConsultarPaquetes)) {
    if (isset($resultadoConsultarPaquetes[0])) {
        $paquetes = count($resultadoConsultarPaquetes);
    } else {
        $paquetes = 1;
    }
} else {
    $paquetes = 0;
}

if ($paquetes > 0) {
    if ($paquetes > 1) {
        for ($i = 0; $i < $paquetes; $i++) {
            $fechaEnvio = "";
            if (isset($resultadoConsultarPaquetes[$i]['fechapaq'])) {
                $fechaEnvio = FechaHora($resultadoConsultarPaquetes[$i]['fechapaq']);
            } else {
                $fechaEnvio = "";
            }
            $_SESSION["fechaEnvio"][$i] = $fechaEnvio;
        }
    } else {
        if (isset($resultadoConsultarPaquetes['fechapaq'])) {
            $fechaEnvio = FechaHora($resultadoConsultarPaquetes['fechapaq']);
        } else {
            $fechaEnvio = "";
        }
        $_SESSION["fechaEnvio"] = $fechaEnvio;
    }
}
if (isset($resultadoConsultarPaquetes)) {
    llenarLog(6, "Comprobante de Paquetes", $usuarioBitacora, $ideSede);
    echo"<script>window.open('../pdf/proof_reporting_package.php');</script>";
    //iraURL('../pdf/proof_reporting_package.php');
}
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>