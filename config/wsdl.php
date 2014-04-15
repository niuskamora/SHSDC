<?php 
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');

//DESARROLLO LOCAL
//$ip = "172.30.3.93";//MAQUINA LUIS
//$ip2 = "172.30.3.119";//MAQUINA KEIWER
//$ip3 = "127.0.0.1";
//$puerto = "8080";

//DESARROLLO-PRUEBAS
//$ip = "172.30.3.161";
$ip="127.0.0.1";
$puerto = "7001";

//CERTIFICACION
//$ip = "172.24.102.152";
//$puerto = "8181";

//PRODUCCION
//$ip = "10.10.80.2"; 
//$puerto = "8181";

$ws_sdc              = "http://" . $ip . ":" . $puerto . "/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL";

$cachesdc = new wsdlcache('../cache', 864000000);

$wsdl_sdc = $cachesdc->get($ws_sdc);

if (is_null($wsdl_sdc)) {
	$wsdl_sdc = new wsdl($ws_sdc);
	$cachesdc->put($wsdl_sdc);
} else {
	$wsdl_sdc->clearDebug();
}

$filter = new InputFilter();

$_POST = $filter->process($_POST);
$_GET = $filter->process($_GET);
?>