<?php

session_start();
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
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
    if ($SedeRol->return->idusu->tipousu != "1" && $SedeRol->return->idusu->tipousu != "2") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$sede = $_SESSION["Sede"]->return->idsed;

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


    if (isset($_POST["reportarPaqExc"])) {

        if (isset($_POST["cPaquete"]) && $_POST["cPaquete"] != "" && isset($_POST["datosPaquete"]) && $_POST["datosPaquete"] != "") {

            try {
                $parametros = array('registroPaquete' => $_POST["cPaquete"],
                    'registroUsuario' => $idUsuario,
                    'registroSede' => $sede,
                    'datosPaquete' => $_POST["datosPaquete"]);
                $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
                $client = new SOAPClient($wsdl_url);
                $client->decode_utf8 = false;
                $reportarPaqExc = $client->reportarPaqueteExtravio($parametros);

                if ($reportarPaqExc->return == 1) {
                    javaalert('Paquete dado de baja por extravió');
                    llenarLog(7, "Paquete Extraviado", $usuarioBitacora, $sede);
                    iraURL('../pages/administration.php');
                } else {
                    javaalert('no se pudo dar de baja el paquete, verifique la informaciÃ³n o consulte con el administrador');
                    iraURL('../pages/administration.php');
                }
            } catch (Exception $e) {
                javaalert('Lo sentimos no hay conexion');
                iraURL('../pages/administration.php');
            }
        } else {
            javaalert("Debe agregar todos los campos, por favor verifique");
        }
    }

    if (isset($_POST["reportarValija"])) {

        if (isset($_POST["cValija"]) && $_POST["cValija"] != "" && isset($_POST["datosValija"]) && $_POST["datosValija"] != "") {

            try {
                $parametros = array('registroValija' => $_POST["cValija"],
                    'registroUsuario' => $idUsuario,
                    'registroSede' => $sede,
                    'datosValija' => $_POST["datosValija"]);
                $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
                $client = new SOAPClient($wsdl_url);
                $client->decode_utf8 = false;
                $reportarValija = $client->reportarValijaExtravio($parametros);

                if ($reportarValija->return == 1) {
                    javaalert('Valija dada de baja por extravió');
                    llenarLog(7, "Valija Extraviada", $usuarioBitacora, $sede);
                    iraURL('../pages/administration.php');
                } else {
                    javaalert('No se pudo dar de baja la Valija, verifique la informacion o consulte con el administrador');
                    iraURL('../pages/administration.php');
                }
            } catch (Exception $e) {
                javaalert('Lo sentimos no hay conexion');
                iraURL('../pages/administration.php');
            }
        } else {
            javaalert("Debe agregar todos los campos, por favor verifique");
        }
    }
    include("../views/misguidance_report.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/administration.php');
}
?>