<?php

session_start();
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$aux = $_POST['sed'];

$Sede = array('sede' => $aux);
$_SESSION["sedeb"] = $aux;
$Usuarios = $client->consultarUsuariosXSede($Sede);

$reg = 0;
if (isset($Usuarios->return)) {
    $reg = count($Usuarios->return);
}
echo "<option value='' style='display:none'>Seleccionar:</option>";
if ($reg > 1) {
    $i = 0;
    while ($reg > $i) {
        echo '<option value="' . $Usuarios->return[$i]->idusu . '">' . $Usuarios->return[$i]->userusu . '</option>';
        $i++;
    }
} else {
    echo '<option value="' . $Usuarios->return->idusu . '">' . $Usuarios->return->userusu . '</option>';
}
?>