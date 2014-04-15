<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}
$Sedes = $_SESSION["Sedes"];
try {
    if (isset($_POST["Biniciar"])) {
        if (isset($_POST["sede"]) && $_POST["sede"] != "") {
            for ($i = 0; $i < count($Sedes->return); $i++) {
                if ($Sedes->return[$i]->idsed == $_POST["sede"]) {
                    $_SESSION["Sede"] = $Sedes->return[$i];
                    break;
                }
            }
            $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
            $client = new SOAPClient($wsdl_url);
            $client->decode_utf8 = false;
            $id = array('idSede' => $_SESSION["Sede"]->idsed);
            $_SESSION["Sede"] = $client->consultarSedeXId($id);
            iraURL('../pages/inbox.php');
        } else {
            javaalert('Debe escojer la sede');
        }
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../index.php');
}
include("../views/headquarters.php");
?>