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

    $orga = $client->call("ConsultarOrganizaciones");
    if ($orga=="") {
        javaalert("lo sentimos no se pueden crear sedes, no existen organizaciones registradas, consulte con el administrador");
        iraURL('../pages/inbox.php');
    }else{
		$org=$orga["return"];
			if(isset($org[0])){
				$reg = count($org);
			}
			else{
				$reg = 1;
			}
		
		
	}

    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["direccion"]) && $_POST["direccion"] != "" && isset($_POST["telefono"]) && $_POST["telefono"] != "" && isset($_POST["codigo"]) && $_POST["codigo"] != "" && isset($_POST["organizacion"]) && $_POST["organizacion"] != "") {

            $result = 0;
            try {
                $datos = array('sede' => $_POST["nombre"]);
                $Sedes = $client->call("consultarSedeExistente",$datos);
                $result = $Sedes['return'];
            } catch (Exception $e) {
                
            }
            if ($result == 0) {
                $telefono2 = "";
                if (isset($_POST["telefono"])) {
                    $telefono = $_POST["telefono"];
                }
                if (isset($_POST["telefono2"])) {
                    $telefono2 = $_POST["telefono2"];
                }
                if (isset($_POST["direccion"])) {
                    $direccion = $_POST["direccion"];
                }
                $Sedenueva = array(
                    'nombresed' => $_POST["nombre"],
                    'direccionsed' => $direccion,
                    'telefonosed' => $telefono,
                    'telefono2sed' => $telefono2,
                    'idorg' => $_POST["organizacion"],
                    'borradosed' => "0",
                    'codigosed' => $_POST["codigo"]
                );
                $parametros = array('registroSede' => $Sedenueva, 'idorg' => $_POST["organizacion"]);
                $guardo = $client->call("insertarSede",$parametros);

                if ($guardo["return"] == 0) {
                    javaalert("No se han Guardado los datos de la sede, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos de la sede");
                    llenarLog(1, "Inserción de Sede", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
                }
                iraURL('../pages/inbox.php');
            } else {
                javaalert('Este nombre de sede ya ha sido usado');
                iraURL('../pages/inbox.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_headquarters.php");
} catch (Exception $e) {
    javaalert('Error al crear la sede');
    iraURL('../pages/inbox.php');
}
?>