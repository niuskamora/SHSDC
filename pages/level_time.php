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

$usu = $_SESSION["Usuario"]->return->idusu;
$sede = $_SESSION["Sede"]->return->idsed;
try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $datos = array('idusu' => $usu, 'idsed' => $sede);
    $rowPrioridad = $client->listarPrioridad();

    if (!isset($rowPrioridad->return)) {
        $bitacora = 0;
    } else {
        $bitacora = count($rowPrioridad->return);
    }

    if (isset($_POST["Guardar"])) {
        if (isset($_POST["hora"]) && $_POST["hora"] != "" && isset($_POST["prioridad"]) && $_POST["prioridad"] != "" && isset($_POST["area"]) && $_POST["area"] != "") {
			
            $tiempo = array(
                'tiempo' => $_POST["hora"],
                'idniv' => $_POST["area"]);
            $guardo = $client->actualizarTiempoNivel($tiempo);
            if ($guardo->return == 0) {
                javaalert("No se ha Guardado el tiempo de la Area, Consulte con el Admininistrador");
            } else {
                javaalert("Se ha Guardado el tiempo de la Area");
                llenarLog(1, "Inserción tiempo de area", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
            }
            iraURL('../pages/inbox.php');
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/level_time.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/administration.php');
}
?>