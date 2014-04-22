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

try {
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

    $Ses = $client->call("ConsultarSedes");
	
    if ($Ses=="") {
        javaalert("lo sentimos no se pueden crear Areas, no existen sedes registradas, Consulte con el administrador");
        iraURL('../pages/inbox.php');
    }else{
		$Sedes=$Ses["return"];
			if(isset($Sedes[0])){
				$reg = count($Sedes);
			}
			else{
				$reg = 1;
			}
		
	}
    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["sede"]) && $_POST["sede"] != "") {

            $result = 0;
            try {
                $datos = array('area' => $_POST["nombre"], 'sede' => $_POST["sede"]);
                $areas = $client->call("consultarAreaExistente",$datos);
                $result = $areas["return"];
            } catch (Exception $e) {
                
            }
            if ($result == 0) {
                $areanueva = array(
                    'nombreatr' => $_POST["nombre"],
                    'idsed' => $_POST["sede"]);
                $parametros = array('registroArea' => $areanueva, 'idsed' => $_POST["sede"]);
                $guardo = $client->call("insertarArea",$parametros);
                if ($guardo["return"] == 0) {
                    javaalert("No se han Guardado los datos de la Area, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos de la Area");
                    llenarLog(1, "Inserción de Area", $_SESSION["Usuario"]['idusu'], $_SESSION["Sede"]['idsed']);
                }
                iraURL('../pages/inbox.php');
            } else {
                javaalert('Este nombre de Area ya ha sido usado en esta sede');
                iraURL('../pages/inbox.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_area.php");
} catch (Exception $e) {
    javaalert('Error al crear la Area');
    iraURL('../pages/inbox.php');
}
?>