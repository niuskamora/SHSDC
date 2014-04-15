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

$_SESSION["valija"] = "";
$_SESSION["codigo"] = "";
$_SESSION["origen"] = "";
$_SESSION["fecha"] = "";

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

if (isset($SedeRol->return)) {
    if ($SedeRol->return->idrol->idrol != "4" && $SedeRol->return->idrol->idrol != "5") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$ideSede = $_SESSION["Sede"]->return->idsed;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;

$idVal = $_SESSION['val'];

if ($idVal == "") {
    iraURL('../pages/breakdown_valise.php');
} else {

    try {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;

        $idValija = array('codigo' => $idVal);
        $resultadoConsultarUltimaValija = $client->consultarValijaXIdOCodigoBarra($idValija);

        if (isset($resultadoConsultarUltimaValija->return)) {

            if (isset($resultadoConsultarUltimaValija->return->fechaval)) {
                $fecha = FechaHora($resultadoConsultarUltimaValija->return->fechaval);
            } else {
                $fecha = "";
            }
            //Año de envio del paquete
            $fechaCod = (substr($fecha, 6, 4));

            $sedOrigen = $resultadoConsultarUltimaValija->return->origenval;
            $idOrigen = array('idSede' => $sedOrigen);
            $resultadoOrigen = $client->consultarSedeXId($idOrigen);
            $codigoSede = $resultadoOrigen->return->codigosed;

            $idval = $resultadoConsultarUltimaValija->return->idval;

            //Código total codigosede+añovalija+idvalija
            $codigoTotal = $codigoSede . $fechaCod . $idval;
            guardarImagen($codigoTotal);

            $_SESSION["valija"] = $resultadoConsultarUltimaValija;
            $_SESSION["codigo"] = $codigoTotal;
            $_SESSION["origen"] = $resultadoOrigen;
            $_SESSION["fecha"] = $fecha;

            llenarLog(6, "Comprobante de Valija", $usuarioBitacora, $ideSede);
            echo"<script>window.open('../pdf/proof_pouch.php');</script>";
            //iraURL('../pdf/proof_pouch.php');
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/breakdown_valise.php');
    }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
?>