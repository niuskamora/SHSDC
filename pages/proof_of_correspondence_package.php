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

$_SESSION["paqueteDos"] = "";
$_SESSION["codigoDos"] = "";
$_SESSION["fecha"] = "";

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$ideSede = $_SESSION["Sede"]->return->idsed;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$idPaq = $_GET["id"];

if ($idPaq == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;

        $idPaquete = array('idPaquete' => $idPaq);
        $resultadoConsultarPaquete = $client->consultarPaqueteXId($idPaquete);

        if (isset($resultadoConsultarPaquete->return)) {

            if (isset($resultadoConsultarPaquete->return->fechapaq)) {
                $fecha = FechaHora($resultadoConsultarPaquete->return->fechapaq);
            } else {
                $fecha = "";
            }
            //Año de envio del paquete
            $fechaCod = (substr($fecha, 6, 4));

            $sedPaq = $resultadoConsultarPaquete->return->idsed->idsed;
            $idSede = array('idSede' => $sedPaq);
            $resultadoConsultarSede = $client->consultarSedeXId($idSede);
            $codigoSede = $resultadoConsultarSede->return->codigosed;

            $idpaq = $resultadoConsultarPaquete->return->idpaq;

            //Código total codigosede+añopaquete+idpaquete
            $codigoTotal = $codigoSede . $fechaCod . $idpaq;
            guardarImagen($codigoTotal);

            $_SESSION["paqueteDos"] = $resultadoConsultarPaquete;
            $_SESSION["codigoDos"] = $codigoTotal;
            $_SESSION["fecha"] = $fecha;

            llenarLog(6, "Comprobante de Paquete", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_of_correspondence_package.php');</script>";
            //iraURL('../pdf/proof_of_correspondence_package.php');
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/inbox.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>