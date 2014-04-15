<?php

session_start();
try {
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
    $i = 0;
    $BandejaUsu = $client->consultarBandejas();
    $Usuario = array('user' => $_SESSION["Usuario"]->return->idusu, 'ban' => $BandejaUsu->return[$i]->nombreiba);

    $Ban = array('ban' => $BandejaUsu->return[$i]->nombreiba);

    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);
    $reg = 0;
    if (isset($BandejaUsu->return)) {
        $reg = count($BandejaUsu->return);
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../index.php');
}
include("../views/inbox.php");
?>