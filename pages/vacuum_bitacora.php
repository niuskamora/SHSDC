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

$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$sede = $_SESSION["Sede"]->return->idsed;

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $resultadoListaBitacora = $client->listarBitacora();

    if (!isset($resultadoListaBitacora->return)) {
        $bitacora = 0;
    } else {
        $bitacora = count($resultadoListaBitacora->return);
    }

    if (isset($_POST["vaciar"])) {

$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $resultadoVacioBitacora = $client->vaciarBitacora();

        if (isset($resultadoVacioBitacora->return) == 1) {
            javaalert('Bitacora Vaciada');
            llenarLog(8, "Vacio de Bitácora", $usuarioBitacora, $sede);
            iraURL('../pages/administration.php');
        } else {
            javaalert('Bitacora No Vaciada');
            iraURL('../pages/administration.php');
        }
    }
    include("../views/vacuum_bitacora.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/administration.php');
}
?>