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
    if (isset($SedeRol->return)) {
        if ($SedeRol->return->idusu->tipousu != "1" && $SedeRol->return->idusu->tipousu != "2") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

    $Sedes = $client->consultarSedes();
    if (!isset($Sedes->return)) {
        javaalert("lo sentimos no se pueden crear Areas, no existen sedes registradas, Consulte con el administrador");
        iraURL('../pages/inbox.php');
    }
    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["sede"]) && $_POST["sede"] != "") {

            $result = 0;
            try {
                $datos = array('area' => $_POST["nombre"], 'sede' => $_POST["sede"]);
                $areas = $client->consultarAreaExistente($datos);
                $result = $areas->return;
            } catch (Exception $e) {
                
            }
            if ($result == 0) {
                $areanueva = array(
                    'nombreatr' => $_POST["nombre"],
                    'idsed' => $_POST["sede"]);
                $parametros = array('registroArea' => $areanueva, 'idsed' => $_POST["sede"]);
                $guardo = $client->insertarArea($parametros);
                if ($guardo->return == 0) {
                    javaalert("No se han Guardado los datos de la Area, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos de la Area");
                    llenarLog(1, "Inserción de Area", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
                }
                iraURL('../pages/inbox.php');
            } else {
                javaalert('Este nombre de Area ya ha sido usado en esta sede');
                iraURL('../pages/inbox.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_area.php");
} catch (Exception $e) {
    javaalert('Error al crear la Area');
    iraURL('../pages/inbox.php');
}
?>