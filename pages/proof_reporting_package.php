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

if ($_SESSION["Usuario"]->return->tipousu != "1" && $_SESSION["Usuario"]->return->tipousu != "2") {
    iraURL('../pages/inbox.php');
}

$_SESSION["fechaEnvio"] = "";
$resultadoConsultarPaquetes = $_SESSION["paquetes"];

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$ideSede = $_SESSION["Sede"]->return->idsed;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;

if (isset($resultadoConsultarPaquetes->return)) {
    $paquetes = count($resultadoConsultarPaquetes->return);
} else {
    $paquetes = 0;
}

if ($paquetes > 0) {
    if ($paquetes > 1) {
        for ($i = 0; $i < $paquetes; $i++) {
            $fechaEnvio = "";
            if (isset($resultadoConsultarPaquetes->return[$i]->fechapaq)) {
                $fechaEnvio = FechaHora($resultadoConsultarPaquetes->return[$i]->fechapaq);
            } else {
                $fechaEnvio = "";
            }
            $_SESSION["fechaEnvio"][$i] = $fechaEnvio;
        }
    } else {
        if (isset($resultadoConsultarPaquetes->return->fechapaq)) {
            $fechaEnvio = FechaHora($resultadoConsultarPaquetes->return->fechapaq);
        } else {
            $fechaEnvio = "";
        }
        $_SESSION["fechaEnvio"] = $fechaEnvio;
    }
}
if (isset($resultadoConsultarPaquetes->return)) {
    llenarLog(6, "Comprobante de Paquetes", $usuarioBitacora, $ideSede);
    echo"<script>window.open('../pdf/proof_reporting_package.php');</script>";
    //iraURL('../pdf/proof_reporting_package.php');
}
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>