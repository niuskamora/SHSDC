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

    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
    $consumo = $client->call("consultarSedeRol", $UsuarioRol);
    if ($consumo != "") {
        $SedeRol = $consumo['return'];
    } else {
        iraURL('../pages/inbox.php');
    }

    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["correo"]) && $_POST["correo"] != "" && isset($_POST["cedularif"]) && $_POST["cedularif"] != "" && isset($_POST["telefono"]) && $_POST["telefono"] != "" && isset($_POST["direccion"]) && $_POST["direccion"] != "") {

            if (preg_match('{^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$}', $_POST["correo"])) {
                $correo = $_POST["correo"];

                if (isset($_POST["telefono"])) {
                    $telefono = $_POST["telefono"];
                }
                if (isset($_POST["direccion"])) {
                    $direccion = $_POST["direccion"];
                }
                $Buzon = array(
                    'nombrebuz' => utf8_decode($_POST["nombre"]),
                    'identificacionbuz' => $_POST["cedularif"],
                    'correobuz' => $correo,
                    'direccionbuz' => utf8_decode($direccion),
                    'telefonobuz' => $telefono,
                    'tipobuz' => "1",
                    'borradobuz' => "0");
                $parametros = array('buzon' => $Buzon, 'idusu' => $_SESSION["Usuario"]['idusu'], 'idsed' => $_SESSION["Sede"]['idsed']);
                $consumo = $client->call("insertarBuzonExterno", $parametros);
                if ($consumo != "") {
                    $guardo = $consumo["return"];
                    if ($guardo == 0) {
                        utf8_decode(javaalert("No se han Guardado los datos del Buzón externo, Consulte con el Admininistrador"));
                    } else {
                        utf8_decode(javaalert("Se han Guardado los datos del Buzón externo"));
                        llenarLog(1, "Creación de buzón externo", $_SESSION["Usuario"]['idusu'], $_SESSION["Sede"]['idsed']);
                    }
                } else {
                    utf8_decode(javaalert("No se han Guardado los datos del Buzón externo, Consulte con el Admininistrador"));
                }

                iraURL('../pages/send_correspondence.php');
            } else {
                javaalert("El formato del correo es incorrecto, por favor verifique");
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_external_mailbox.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Error al crear el Buzón externo'));
    iraURL('../pages/inbox.php');
}
?>