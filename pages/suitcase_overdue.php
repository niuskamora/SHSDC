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
	} 
     $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
    $consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
        if ($SedeRol["idrol"]["idrol"] != "4" && $SedeRol["idrol"]["idrol"] != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }
    $parametros = array('idSede' => $_SESSION["Sede"]["idsed"]);
	$consumo = $client->call("valijasXFechaVencidaXUsuarioOrigen",$parametros);
	if ($consumo!="") {
	$ValijasOrigen = $consumo['return'];  
	}
    if (isset($ValijasOrigen)) {
        if (!isset($ValijasOrigen[0])) {
            $parametros = array('Id' => $ValijasOrigen["origenval"]);
			 $consumo = $client->call("consultaNombreSedeXId",$parametros);
			if ($consumo!="") {
			$nombreSede = $consumo['return']; 
			$ValijasOrigen["origenval"] = $nombreSede;
			}
            
        } else {
            for ($i = 0; $i < count($ValijasOrigen); $i++) {
                $parametros = array('Id' => $ValijasOrigen[$i]["origenval"]);
				$consumo = $client->call("consultaNombreSedeXId",$parametros);
				if ($consumo!="") {
				$nombreSede = $consumo['return'];
				$ValijasOrigen[$i]["origenval"] = $nombreSede;
				}         
				
            }
        }
    }
    $sede = array('idsed' => $_SESSION["Sede"]["idsed"]);
    $parametros = array('registroSede' => $sede);
	$consumo = $client->call("valijasXFechaVencidaXUsuarioDestino",$parametros);
				if ($consumo!="") {
				$ValijasDestino = $consumo['return'];  
				}    
    if (isset($ValijasDestino)) {
        if (!isset($ValijasDestino[0])) {
            $parametros = array('Id' => $ValijasDestino["origenval"]);
				$consumo = $client->call("consultaNombreSedeXId",$parametros);
				if ($consumo!="") {
				$nombreSede = $consumo['return'];  
				}
				$ValijasDestino["origenval"] = $nombreSede;
        } else {
            for ($i = 0; $i < count($ValijasDestino); $i++) {
                $parametros = array('Id' => $ValijasDestino[$i]["origenval"]);
				$consumo = $client->call("consultaNombreSedeXId",$parametros);
				if ($consumo!="") {
				$nombreSede = $consumo['return'];  
				}                
				$ValijasDestino[$i]["origenval"] = $nombreSede;
            }
        }
    }
    include("../views/suitcase_overdue.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
?>