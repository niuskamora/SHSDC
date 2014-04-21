<?php

session_start();
include("../recursos/funciones.php");
include("../recursos/codigoBarrasPdf.php");
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

$_SESSION["paquete"] = "";
$_SESSION["codigo"] = "";
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
$idPaq = $_GET["id"];

if ($idPaq == "") {
    iraURL('../pages/inbox.php');
} else {
    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $idPaquete = array('idPaquete' => $idPaq);
        $consumoPaquete = $client->call("consultarPaqueteXId", $idPaquete);
        if ($consumoPaquete != "") {
            $resultadoConsultarPaquete = $consumoPaquete['return'];
        }

        if (isset($resultadoConsultarPaquete)) {

            if (isset($resultadoConsultarPaquete['fechapaq'])) {
                $fecha = FechaHora($resultadoConsultarPaquete['fechapaq']);
            } else {
                $fecha = "";
            }
            //Año de envio del paquete
            $fechaCod = (substr($fecha, 6, 4));

            $sedPaq = $resultadoConsultarPaquete['idsed']['idsed'];
            $idSede = array('idSede' => $sedPaq);
            $consumoSede = $client->call("consultarSedeXId", $idSede);
            if ($consumoSede != "") {
                $resultadoConsultarSede = $consumoSede['return'];
            }
            if (isset($resultadoConsultarSede)) {
                $codigoSede = $resultadoConsultarSede['codigosed'];
            }

            $idpaq = $resultadoConsultarPaquete['idpaq'];

            //Código total codigosede+añopaquete+idpaquete
            $codigoTotal = $codigoSede . $fechaCod . $idpaq;
            guardarImagen($codigoTotal);

            $_SESSION["paquete"] = $resultadoConsultarPaquete;
            $_SESSION["codigo"] = $codigoTotal;
            $_SESSION["fecha"] = $fecha;

            llenarLog(6, "Comprobante de Paquete", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_of_correspondence.php');</script>";
            //iraURL('../pdf/proof_of_correspondence.php');
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/inbox.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>