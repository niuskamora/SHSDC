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
    if ($SedeRol->return->idrol->idrol != "4" && $SedeRol->return->idrol->idrol != "5") {
        if ($_SESSION["Usuario"]->return->tipousu != "1" && $_SESSION["Usuario"]->return->tipousu != "2") {
            iraURL('../pages/inbox.php');
        }
    }
} else {
    iraURL('../pages/inbox.php');
}

$ideSede = $_SESSION["Sede"]->return->idsed;
$usuario = $_SESSION["Usuario"]->return->idusu;

$resultadoSedes = $client->listarSedes();
if (!isset($resultadoSedes->return)) {
    $sedes = 0;
} else {
    $sedes = count($resultadoSedes->return);
}

$_SESSION["Reporte"] = "";
$_SESSION["Osede"] = "";
$_SESSION["Opcion"] = "";
$_SESSION["Fechaini"] = "";
$_SESSION["Fechafin"] = "";

if (isset($_POST["consultar"])) {
    if (isset($_POST["reporte"]) && $_POST["reporte"] != "" && isset($_POST["osede"]) && $_POST["osede"] != "" && isset($_POST["opcion"]) && $_POST["opcion"] != "") {

        $_SESSION["Reporte"] = $_POST["reporte"];
        $_SESSION["Osede"] = $_POST["osede"];
        $_SESSION["Opcion"] = $_POST["opcion"];
        $_SESSION["Fechaini"] = $_POST["datepicker"];
        $_SESSION["Fechafin"] = $_POST["datepickerf"];

        iraURL("../pages/info_reports_valise.php");
    } else {
        javaalert("Debe agregar todos los campos, por favor verifique");
    }
}
include("../views/reports_valise.php");
?>