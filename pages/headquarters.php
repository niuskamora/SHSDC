<?php

session_start();


try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
	$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$_SESSION["cli"]=$client;
		if (!isset($_SESSION["Usuario"])) {
			iraURL("../index.php");
		} elseif (!usuarioCreado()) {
			iraURL("../pages/create_user.php");
		}elseif (!isset($_SESSION["Sedes"])) {
			iraURL("../pages/index.php");
		}
	$Sedes = $_SESSION["Sedes"];
    if (isset($_POST["Biniciar"])) {
        if (isset($_POST["sede"]) && $_POST["sede"] != "") {
            for ($i = 0; $i < count($Sedes); $i++) {
                if ($Sedes[$i]["idsed"] == $_POST["sede"]) {
                    $_SESSION["Sede"] = $Sedes[$i];
                    break;
                }
            }
            $id = array('idSede' => $_SESSION["Sede"]["idsed"]);
			$consumo = $client->call("consultarSedeXId",$id);
		   if($consumo!=""){
		    $_SESSION["Sede"] = $consumo['return'];
			iraURL('../pages/index.php');
		   }else{
		    javaalert('No se puede seleccionar la sede en estos momentos , consulte con el administrador');
		    iraURL('../pages/inbox.php');
		   }
        } else {
            javaalert('Debe escojer la sede');
        }
    }
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../index.php');
}
include("../views/headquarters.php");
?>