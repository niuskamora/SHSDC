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

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

if (isset($SedeRol->return)) {
    if ($SedeRol->return->idrol->idrol != "1" && $SedeRol->return->idrol->idrol != "3") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$ideSede = $_SESSION["Sede"]->return->idsed;
$_SESSION["paquetesConfirmados"] = "";
$_SESSION["paquetes"] = "";
$_SESSION["codigos"] = "";

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;

    $usuario = array('user' => $nomUsuario);
    $resultadoConsultarUsuario = $client->consultarUsuarioXUser($usuario);

    if (!isset($resultadoConsultarUsuario->return)) {
        $usua = 0;
    } else {
        $usua = $resultadoConsultarUsuario->return;
    }

    $idUsuario = $resultadoConsultarUsuario->return->idusu;

    try {
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;

        $usuSede = array('iduse' => $SedeRol->return->iduse,
            'idrol' => $SedeRol->return->idrol,
            'idsed' => $SedeRol->return->idsed);
        $parametros = array('idUsuarioSede' => $usuSede);
        $resultadoPaquetesConfirmados = $client->consultarPaquetesConfirmadosXRol($parametros);

        if (!isset($resultadoPaquetesConfirmados->return)) {
            $paquetes = 0;
        } else {
            $paquetes = count($resultadoPaquetesConfirmados->return);
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/confirm_package.php');
    }

    if (isset($_POST["imprimir"])) {

        if (isset($_POST["ide"])) {

            $imprimirPaquetes = $_POST["ide"];
            for ($i = 0; $i < count($imprimirPaquetes); $i++) {
                $idPaquete = array('idPaquete' => $imprimirPaquetes[$i]);
                $resultadoPaquete = $client->consultarPaqueteXId($idPaquete);
                $idpaq[$i] = $resultadoPaquete->return->idpaq;

                $sedPaq = $resultadoPaquete->return->idsed->idsed;
                $idSede = array('idSede' => $sedPaq);
                $resultadoConsultarSede = $client->consultarSedeXId($idSede);
                $codigoSede = $resultadoConsultarSede->return->codigosed;

                if (isset($resultadoPaquete->return->fechapaq)) {
                    $fecha = FechaHora($resultadoPaquete->return->fechapaq);
                } else {
                    $fecha = "";
                }
                //Año de envio del paquete
                $fechaCod = (substr($fecha, 6, 4));

                //Código total codigosede+añopaquete+idpaquete
                $codigoTotal[$i] = $codigoSede . $fechaCod . $idpaq[$i];
                guardarImagen($codigoTotal[$i]);
                $_SESSION["codigos"][$i] = $codigoTotal[$i];
            }
            $_SESSION["paquetesConfirmados"] = $resultadoPaquetesConfirmados;
            $_SESSION["paquetes"] = $imprimirPaquetes;
            iraURL('../pages/proof_package_confirmed.php');
        } else {
            javaalert("Debe seleccionar al menos un paquete, por favor verifique");
        }
    }
    include("../views/print_packages_confirmed.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/confirm_package.php');
}
?>