<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$aux = $_POST['sed'];

$Sede = array('sede' => $aux);
$_SESSION["sedeb"] = $aux;
 $client = new nusoap_client($wsdl_sdc, 'wsdl');
	 $_SESSION["cli"]=$client;	
//$Usuarios = $client->consultarAreasXSede($Sede);
$consumo = $client->call("consultarAreasXSede",$Sede);
	if ($consumo!="") {
	$Usuarios = $consumo['return'];   
    }
$reg = 0;
if (isset($Usuarios)) {

echo "<option value='' style='display:none'>Seleccionar:</option>";
if (isset($Usuarios[0])) {
    $i = 0;
    while ($reg > $i) {
        echo '<option value="' . $Usuarios[$i]["idatr"] . '">' . utf8_decode($Usuarios[$i]["nombreatr"]) . '</option>';
        $i++;
    }
} else {
    echo '<option value="' . $Usuarios["idatr"] . '">' . utf8_decode($Usuarios["nombreatr"]) . '</option>';
}
}
?>