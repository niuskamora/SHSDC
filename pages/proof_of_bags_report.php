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

$_SESSION["fechaEnvio"] = "";
$_SESSION["fechaRecibido"] = "";
$resultadoConsultarValijas = $_SESSION["valijas"];
$nombreSede = $_SESSION["nombreSede"];

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

$nomUsuario = $_SESSION["Usuario"]['userusu'];
$ideSede = $_SESSION["Sede"]['idsed'];
$usuarioBitacora = $_SESSION["Usuario"]['idusu'];

if (isset($resultadoConsultarValijas)) {
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
            $fechaEnvio = "";
            $fechaRecibido = "";
            if (isset($resultadoConsultarValijas[$i]['fechaval'])) {
                $fechaEnvio = FechaHora($resultadoConsultarValijas[$i]['fechaval']);
            } else {
                $fechaEnvio = "";
            }
            if (isset($resultadoConsultarValijas[$i]['fecharval'])) {
                $fechaRecibido = FechaHora($resultadoConsultarValijas[$i]['fecharval']);
            } else {
                $fechaRecibido = "";
            }
            $_SESSION["fechaEnvio"][$i] = $fechaEnvio;
            $_SESSION["fechaRecibido"][$i] = $fechaRecibido;
        }
    } else {
        if (isset($resultadoConsultarValijas['fechaval'])) {
            $fechaEnvio = FechaHora($resultadoConsultarValijas['fechaval']);
        } else {
            $fechaEnvio = "";
        }
        if (isset($resultadoConsultarValijas['fecharval'])) {
            $fechaRecibido = FechaHora($resultadoConsultarValijas['fecharval']);
        } else {
            $fechaRecibido = "";
        }
        $_SESSION["fechaEnvio"] = $fechaEnvio;
        $_SESSION["fechaRecibido"] = $fechaRecibido;
    }
}

if (isset($resultadoConsultarValijas)) {
    llenarLog(6, "Comprobante de Valijas", $usuarioBitacora, $ideSede);
    echo"<script>window.open('../pdf/proof_of_bags_report.php');</script>";
    //iraURL('../pdf/proof_of_bags_report.php');
}
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>