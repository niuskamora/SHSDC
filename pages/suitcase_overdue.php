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
        if ($SedeRol->return->idrol->idrol != "4" && $SedeRol->return->idrol->idrol != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }
    $parametros = array('idSede' => $_SESSION["Sede"]->return->idsed);
    $ValijasOrigen = $client->valijasXFechaVencidaXUsuarioOrigen($parametros);
    if (isset($ValijasOrigen->return)) {
        if (count($ValijasOrigen->return) == 1) {
            $parametros = array('Id' => $ValijasOrigen->return->origenval);
            $nombreSede = $client->consultaNombreSedeXId($parametros);
            $ValijasOrigen->return->origenval = $nombreSede->return;
        } else {
            for ($i = 0; $i < count($ValijasOrigen->return); $i++) {
                $parametros = array('Id' => $ValijasOrigen->return[$i]->origenval);
                $nombreSede = $client->consultaNombreSedeXId($parametros);
                $ValijasOrigen->return[$i]->origenval = $nombreSede->return;
            }
        }
    }
    $sede = array('idsed' => $_SESSION["Sede"]->return->idsed);
    $parametros = array('registroSede' => $sede);
    $ValijasDestino = $client->valijasXFechaVencidaXUsuarioDestino($parametros);
    if (isset($ValijasDestino->return)) {
        if (count($ValijasDestino->return) == 1) {
            $parametros = array('Id' => $ValijasDestino->return->origenval);
            $nombreSede = $client->consultaNombreSedeXId($parametros);
            $ValijasDestino->return->origenval = $nombreSede->return;
        } else {
            for ($i = 0; $i < count($ValijasDestino->return); $i++) {
                $parametros = array('Id' => $ValijasDestino->return[$i]->origenval);
                $nombreSede = $client->consultaNombreSedeXId($parametros);
                $ValijasDestino->return[$i]->origenval = $nombreSede->return;
            }
        }
    }
    include("../views/suitcase_overdue.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>