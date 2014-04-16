<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

/* if (!isset($_SESSION["Usuario"])) {
  iraURL("../index.php");
  } elseif (!usuarioCreado()) {
  iraURL("../pages/create_user.php");
  } */

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
    if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
        //iraURL('../pages/inbox.php');
    } else {
        //iraURL('../pages/inbox.php');
    }
}

$usuarioBitacora = $_SESSION["Usuario"]['idusu'];
$sede = $_SESSION["Sede"]['idsed'];

try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $consumoBitacora = $client->call("listarBitacora");
    if ($consumoBitacora != "") {
        $resultadoListaBitacora = $consumoBitacora['return'];
        if (isset($resultadoListaBitacora[0])) {
            $bitacora = count($resultadoListaBitacora);
        } else {
            $bitacora = 1;
        }
    }

    if (isset($_POST["vaciar"])) {
        $client = new nusoap_client($wsdl_sdc, 'wsdl');
        $consumoVacioBitacora = $client->call("vaciarBitacora");
        $resultadoVacioBitacora = $consumoVacioBitacora['return'];
        if (isset($resultadoVacioBitacora) == 1) {
            javaalert('Bitacora Vaciada');
            //llenarLog(8, "Vacio de Bitácora", $usuarioBitacora, $sede);
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