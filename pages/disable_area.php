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
        javaalert("lo sentimos no se pueden deshabilitar areas, no existen sedes registradas, consulte con el administrador");
        iraURL('../pages/inbox.php');
    }

    $reg = count($Sedes->return);
    include("../views/disable_area.php");
} catch (Exception $e) {
    javaalert('Error al deshabiltar el area');
    iraURL('../pages/inbox.php');
}
?>