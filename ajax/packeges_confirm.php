
<?php

session_start();
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$aux = $_POST['idpaq'];
$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$paq = array('idpaq' => $aux);
$Valija = $client->actualizarBandeja($paq);

if ($Valija->return) {
    javaalert("Paquete confirmado con exito");
    iraURL("../pages/inbox.php");
}
?>