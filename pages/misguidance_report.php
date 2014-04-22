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

$nomUsuario = $_SESSION["Usuario"]['userusu'];
$usuarioBitacora = $_SESSION["Usuario"]['idusu'];
$sede = $_SESSION["Sede"]['idsed'];

try {


    $usuario = array('user' => $nomUsuario);
    $resultadoConsultarUsuario = $client->call("consultarUsuarioXUser",$usuario);
    if ($resultadoConsultarUsuario=="") {
        $usua = 0;
    } else {
        $usua = $resultadoConsultarUsuario['return'];
		$idUsuario = $usua['idusu'];
    }
   


    if (isset($_POST["reportarPaqExc"])) {

        if (isset($_POST["cPaquete"]) && $_POST["cPaquete"] != "" && isset($_POST["datosPaquete"]) && $_POST["datosPaquete"] != "") {

            try {
                $parametros = array('registroPaquete' => $_POST["cPaquete"],
                    'registroUsuario' => $idUsuario,
                    'registroSede' => $sede,
                    'datosPaquete' => $_POST["datosPaquete"]);
               
                $reportarPaqExc = $client->call("reportarPaqueteExtravio",$parametros);

                if ($reportarPaqExc['return'] == 1) {
                    javaalert('Paquete dado de baja por extravió');
                    llenarLog(7, "Paquete Extraviado", $usuarioBitacora, $sede);
                    iraURL('../pages/administration.php');
                } else {
                    javaalert('no se pudo dar de baja el paquete, verifique la informaciÃ³n o consulte con el administrador');
                    iraURL('../pages/administration.php');
                }
            } catch (Exception $e) {
                javaalert('Lo sentimos no hay conexion');
                iraURL('../pages/administration.php');
            }
        } else {
            javaalert("Debe agregar todos los campos, por favor verifique");
        }
    }

    if (isset($_POST["reportarValija"])) {

        if (isset($_POST["cValija"]) && $_POST["cValija"] != "" && isset($_POST["datosValija"]) && $_POST["datosValija"] != "") {

            try {
                $parametros = array('registroValija' => $_POST["cValija"],
                    'registroUsuario' => $idUsuario,
                    'registroSede' => $sede,
                    'datosValija' => $_POST["datosValija"]);
                
                $reportarValija = $client->call("reportarValijaExtravio",$parametros);

                if ($reportarValija['return'] == 1) {
                    javaalert('Valija dada de baja por extravió');
                    llenarLog(7, "Valija Extraviada", $usuarioBitacora, $sede);
                    iraURL('../pages/administration.php');
                } else {
                    javaalert('No se pudo dar de baja la Valija, verifique la informacion o consulte con el administrador');
                    iraURL('../pages/administration.php');
                }
            } catch (Exception $e) {
                javaalert('Lo sentimos no hay conexion');
                iraURL('../pages/administration.php');
            }
        } else {
            javaalert("Debe agregar todos los campos, por favor verifique");
        }
    }
    include("../views/misguidance_report.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/administration.php');
}
?>