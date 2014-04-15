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

$_SESSION["fechaEnvio"] = "";
$_SESSION["fechaRecibido"] = "";
$resultadoConsultarValijas = $_SESSION["valijas"];
$nombreSede = $_SESSION["nombreSede"];

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

if (!isset($resultadoConsultarValijas->return)) {
    $valijas = 0;
} else {
    $valijas = count($resultadoConsultarValijas->return);
}

if ($valijas > 0) {
    if ($valijas > 1) {
        for ($i = 0; $i < $valijas; $i++) {
            $fechaEnvio = "";
            $fechaRecibido = "";
            if (isset($resultadoConsultarValijas->return[$i]->fechaval)) {
                $fechaEnvio = FechaHora($resultadoConsultarValijas->return[$i]->fechaval);
            } else {
                $fechaEnvio = "";
            }
            if (isset($resultadoConsultarValijas->return[$i]->fecharval)) {
                $fechaRecibido = FechaHora($resultadoConsultarValijas->return[$i]->fecharval);
            } else {
                $fechaRecibido = "";
            }
            $_SESSION["fechaEnvio"][$i] = $fechaEnvio;
            $_SESSION["fechaRecibido"][$i] = $fechaRecibido;
        }
    } else {
        if (isset($resultadoConsultarValijas->return->fechaval)) {
            $fechaEnvio = FechaHora($resultadoConsultarValijas->return->fechaval);
        } else {
            $fechaEnvio = "";
        }
        if (isset($resultadoConsultarValijas->return->fecharval)) {
            $fechaRecibido = FechaHora($resultadoConsultarValijas->return->fecharval);
        } else {
            $fechaRecibido = "";
        }
        $_SESSION["fechaEnvio"] = $fechaEnvio;
        $_SESSION["fechaRecibido"] = $fechaRecibido;
    }
}

if (isset($resultadoConsultarValijas->return)) {
    llenarLog(6, "Comprobante de Valijas", $usuarioBitacora, $ideSede);
    echo"<script>window.open('../pdf/proof_of_bags_report.php');</script>";
    //iraURL('../pdf/proof_of_bags_report.php');
}
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>