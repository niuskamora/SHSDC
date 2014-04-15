<?php

session_start();
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$aux = $_POST['sed'];

$Sede = array('sede' => $aux);
$_SESSION["sedeb"] = $aux;
$Usuarios = $client->consultarAreasXSede($Sede);

$reg = 0;
if (isset($Usuarios->return)) {
    $reg = count($Usuarios->return);
}
echo "<option value='' style='display:none'>Seleccionar:</option>";
if ($reg > 1) {
    $i = 0;
    while ($reg > $i) {
        echo '<option value="' . $Usuarios->return[$i]->idatr . '">' . $Usuarios->return[$i]->nombreatr . '</option>';
        $i++;
    }
} else {
    echo '<option value="' . $Usuarios->return->idatr . '">' . $Usuarios->return->nombreatr . '</option>';
}
?>