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

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);

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
                    'nombrebuz' => $_POST["nombre"],
                    'identificacionbuz' => $_POST["cedularif"],
                    'correobuz' => $correo,
                    'direccionbuz' => $direccion,
                    'telefonobuz' => $telefono,
                    'tipobuz' => "1",
                    'borradobuz' => "0");
                $parametros = array('buzon' => $Buzon, 'idusu' => $_SESSION["Usuario"]->return->idusu, 'idsed' => $_SESSION["Sede"]->return->idsed);
                $guardo = $client->insertarBuzonExterno($parametros);
                if ($guardo->return == 0) {
                    javaalert("No se han Guardado los datos del Buzon externo, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos del Buzon externo");
                    llenarLog(1, "Creacion de buzon externo", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
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
    javaalert('Error al crear el Buzon externo');
    iraURL('../pages/inbox.php');
}
?>