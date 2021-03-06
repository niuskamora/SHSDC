<?php

session_start();

include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$client->decode_utf8 = false;
$_SESSION["cli"] = $client;
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}

try {
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
    $SedeR = $client->call("consultarSedeRol", $UsuarioRol);
    $SedeRol = $SedeR['return'];

    if ($SedeR != "") {
        if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

    $Ses = $client->call("ConsultarSedes");

    if ($Ses == "") {
        utf8_decode(javaalert("Lo sentimos no se pueden crear áreas, no existen sedes registradas, Consulte con el administrador"));
        iraURL('../pages/inbox.php');
    } else {
        $Sedes = $Ses["return"];
        if (isset($Sedes[0])) {
            $reg = count($Sedes);
        } else {
            $reg = 1;
        }
    }
    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["sede"]) && $_POST["sede"] != "") {

            $nombre = utf8_decode($_POST["nombre"]);
            $datos = array('area' => $nombre, 'sede' => utf8_decode($_POST["sede"]));
            $result = $client->call("consultarAreaExistente", $datos);

            if ($result['return'] == "0") {
                $correcto = 0;
                utf8_decode(javaalert("No se han Guardado los datos de la área, Consulte con el Admininistrador"));
                iraURL('../pages/create_area.php');
                
            } else if ($result['return'] == "2") {
                utf8_decode(javaalert("Se han Guardado los datos del área"));
                llenarLog(1, "Inserción de área", $_SESSION["Usuario"]['idusu'], $_SESSION["Sede"]['idsed']);
                iraURL('../pages/administration.php');
                
            } else if ($result['return'] == "1") {
                utf8_decode(javaalert('Este nombre de área ya ha sido usado en esta sede'));
                iraURL('../pages/create_area.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_area.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Error al crear el área'));
    iraURL('../pages/inbox.php');
}
?>