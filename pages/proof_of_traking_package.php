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

$_SESSION["trakingPaquete"] = "";
$_SESSION["fecha"] = "";

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$ideSede = $_SESSION["Sede"]->return->idsed;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$idPaquete = $_GET["id"];

if ($idPaquete == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $paquete = array('idPaquete' => $idPaquete);
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $resultadoPaquete = $client->consultarSeguimientoXPaquete($paquete);

        if (!isset($resultadoPaquete->return)) {
            $segumientoPaquete = 0;
        } else {
            $segumientoPaquete = count($resultadoPaquete->return);
        }

        if ($segumientoPaquete > 1) {
            for ($i = 0; $i < $segumientoPaquete; $i++) {
                if (isset($resultadoPaquete->return[$i]->fechaseg)) {
                    $fecha[$i] = FechaHora($resultadoPaquete->return[$i]->fechaseg);
                } else {
                    $fecha[$i] = "";
                }
                $_SESSION["fecha"][$i] = $fecha[$i];
            }
        } elseif ($segumientoPaquete == 1) {
            if (isset($resultadoPaquete->return->fechaseg)) {
                $fecha = FechaHora($resultadoPaquete->return->fechaseg);
            } else {
                $fecha = "";
            }
            $_SESSION["fecha"] = $fecha;
        }
        $_SESSION["trakingPaquete"] = $resultadoPaquete;

        if (isset($resultadoPaquete->return)) {
            llenarLog(6, "Comprobante de Traking de Paquete", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_of_traking_package.php');</script>";
            //iraURL('../pdf/proof_of_traking_package.php');
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/inbox.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>