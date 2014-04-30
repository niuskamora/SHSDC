<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");


$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
	$_SESSION["cli"]=$client;
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}


 $UsuarioRol = array('idusu' => $_SESSION["Usuario"]['idusu'], 'sede' => $_SESSION["Sede"]['nombresed']);
      $SedeR = $client->call("consultarSedeRol",$UsuarioRol);
	 $SedeRol=$SedeR['return'];
    if ($SedeR!="") {
        if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

$usu = $_SESSION["Usuario"]['idusu'];
$sede = $_SESSION["Sede"]['idsed'];
try {
      
    $datos = array('idusu' => $usu, 'idsed' => $sede);
    $rowPriori = $client->call("listarPrioridad");

    if ($rowPriori=="") {
        $reg = 0;
    } else {
		$rowPrioridad = $rowPriori['return'];
        $reg = count($rowPrioridad);
    }

    if (isset($_POST["Guardar"])) {
        if (isset($_POST["hora"]) && $_POST["hora"] != "" && isset($_POST["prioridad"]) && $_POST["prioridad"] != "" && isset($_POST["area"]) && $_POST["area"] != "") {
			
            $tiempo = array(
                'tiempo' => $_POST["hora"],
                'idniv' => $_POST["area"]);
            $guardo = $client->call("actualizarTiempoNivel",$tiempo);
            if ($guardo['return'] == 0) {
                javaalert("No se ha Guardado el tiempo de la Area, Consulte con el Admininistrador");
            } else {
                javaalert("Se ha Guardado el tiempo de la Area");
                llenarLog(1, "Inserción tiempo de área", $_SESSION["Usuario"]["idusu"], $_SESSION["Sede"]["idsed"]);
            }
            iraURL('../pages/inbox.php');
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/level_time.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/administration.php');
}
?>