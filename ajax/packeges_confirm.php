
<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$aux = $_POST['idpaq'];
   $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$_SESSION["cli"]=$client;
$paq = array('idpaq' => $aux);
$consumo = $client->call("actualizarBandeja",$paq);
if($consumo!=""){
	$Valija = $consumo['return'];
	}  

if ($Valija) {
    javaalert("Paquete confirmado con exito");
    iraURL("../pages/inbox.php");
}
?>