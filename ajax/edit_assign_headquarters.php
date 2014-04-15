<?php

session_start();
try {
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');

    if (isset($_SESSION["usuedit"]) && isset($_SESSION["sededit"]) && isset($_POST['ed'])) {
        $aux = $_POST['ed'];
        $datosB = array('idusu' => $_SESSION["usuedit"], 'idatr' => $aux, 'idsed' => $_SESSION["sededit"]);
        if ($aux == "") {
            javaalert('Debe seleccionar una Sede');
            iraURL('../pages/edit_type_user.php');
        } else {
            $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
            $client = new SOAPClient($wsdl_url);
            $client->decode_utf8 = false;
            $res = $client->insertarUsuarioSedeXAdicional($datosB);
            if ($res->return == 1) {
                javaalert('Buzon asignado con exito');
                iraURL('../pages/administration.php');
            } elseif($res->return == 2) {
                javaalert('El usuario ya esta en esa sede, Seleccione otra sede');
                //iraURL('../pages/administration.php');
            }else {
                javaalert('Error al realizar la operacion');
                iraURL('../pages/administration.php');
            }
        }
    } else {
        
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../index.php');
}
?>