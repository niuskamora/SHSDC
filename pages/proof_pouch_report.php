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

$_SESSION["valija"] = "";
$_SESSION["codigo"] = "";
$_SESSION["origen"] = "";
$_SESSION["fecha"] = "";

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
    if ($SedeRol['idrol']['idrol'] != "4" && $SedeRol['idrol']['idrol'] != "5") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$nomUsuario = $_SESSION["Usuario"]["userusu"];
$usuarioBitacora = $_SESSION["Usuario"]["idusu"];
$idesede = $_SESSION["Sede"]["idsed"];

$idVal = $_SESSION['val'];

if ($idVal == "") {
    iraURL('../pages/breakdown_valise.php');
} else {

    try {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $idValija = array('codigo' => $idVal);
        $consumoValija = $client->call("consultarValijaXIdOCodigoBarra", $idValija);
        if ($consumoValija != "") {
            $resultadoConsultarValija = $consumoValija['return'];
        }

        if (isset($resultadoConsultarValija)) {

            if (isset($resultadoConsultarValija['fechaval'])) {
                $fecha = FechaHora($resultadoConsultarValija['fechaval']);
            } else {
                $fecha = "";
            }
            //Año de envio del paquete
            $fechaCod = (substr($fecha, 6, 4));

            $idSed = $resultadoConsultarValija['origenval'];
            $idSede = array('idSede' => $idSed);
            $consumoSede = $client->call("consultarSedeXId", $idSede);
            if ($consumoSede != "") {
                $resultadoConsultarSede = $consumoSede['return'];
                if (isset($resultadoConsultarSede)) {
                    $codigoSede = $resultadoConsultarSede['codigosed'];
                    $_SESSION["origen"] = $resultadoConsultarSede;
                } else {
                    $codigoSede = "";
                }
            }

            $idval = $resultadoConsultarValija['idval'];

            //Código total codigosede+añopaquete+idpaquete
            $codigoTotal = $codigoSede . $fechaCod . $idval;
            guardarImagen($codigoTotal);

            $_SESSION["valija"] = $resultadoConsultarValija;
            $_SESSION["codigo"] = $codigoTotal;
            $_SESSION["fecha"] = $fecha;

            llenarLog(6, "Comprobante de Valija", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_pouch.php');</script>";
            //iraURL('../pdf/proof_pouch.php');
        }
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../pages/breakdown_valise.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>