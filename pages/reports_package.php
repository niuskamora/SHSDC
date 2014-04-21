<?php

session_start();
include("../recursos/funciones.php");
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

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
    if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$usuario = $_SESSION["Usuario"]['idusu'];
$ideSede = $_SESSION["Sede"]['idsed'];

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$consumoSedes = $client->call("listarSedes");
if ($consumoSedes != "") {
    $resultadoSedes = $consumoSedes['return'];
    if (isset($resultadoSedes[0])) {
        $sedes = count($resultadoSedes);
    } else {
        $sedes = 1;
    }
} else {
    $sedes = 0;
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

        iraURL("../pages/info_reports_package.php");
    } else {
        javaalert("Debe agregar todos los campos, por favor verifique");
    }
}
include("../views/reports_package.php");
?>